<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventPhotoController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $request->validate([
            'photos'   => ['required', 'array', 'max:20'],
            'photos.*' => ['required', 'image', 'max:5120'], // 5 MB por foto
        ]);

        $disk      = config('filesystems.photo_disk', 'public');
        $nextOrder = $event->photos()->max('sort_order') + 1;

        foreach ($request->file('photos') as $file) {
            $key = "events/{$event->id}/" . Str::uuid() . '.' . $file->getClientOriginalExtension();

            Storage::disk($disk)->put($key, $file->getContent(), 'public');

            $event->photos()->create([
                'uploaded_by' => Auth::id(),
                'r2_key'      => $key,
                'url'         => Storage::disk($disk)->url($key),
                'sort_order'  => $nextOrder++,
            ]);
        }

        return redirect()->route('events.show', $event)
            ->with('success', 'Fotos subidas correctamente.');
    }

    public function setCover(Event $event, EventPhoto $photo): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($photo->event_id !== $event->id, 404);

        $event->photos()->update(['is_cover' => false]);
        $photo->update(['is_cover' => true]);

        return redirect()->route('events.show', $event)
            ->with('success', 'Foto de portada actualizada.');
    }

    public function reorder(Request $request, Event $event): JsonResponse
    {
        $this->authorize('update', $event);

        $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'exists:event_photos,id'],
        ]);

        foreach ($request->order as $position => $photoId) {
            $event->photos()->where('id', $photoId)->update(['sort_order' => $position]);
        }

        return response()->json(['ok' => true]);
    }

    public function destroy(Event $event, EventPhoto $photo): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($photo->event_id !== $event->id, 404);

        $disk = config('filesystems.photo_disk', 'public');
        Storage::disk($disk)->delete($photo->r2_key);
        $photo->delete();

        return redirect()->route('events.show', $event)
            ->with('success', 'Foto eliminada.');
    }
}
