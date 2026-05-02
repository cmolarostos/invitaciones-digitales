<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function index(Event $event): View
    {
        $this->authorize('view', $event);

        $guests = $event->guests()->latest()->paginate(50);

        return view('guests.index', compact('event', 'guests'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $event->guests()->create($data);

        return redirect()->route('events.guests.index', $event)
            ->with('success', 'Invitado agregado.');
    }

    public function update(Request $request, Event $event, Guest $guest): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($guest->event_id !== $event->id, 404);

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $guest->update($data);

        return redirect()->route('events.guests.index', $event)
            ->with('success', 'Invitado actualizado.');
    }

    public function destroy(Event $event, Guest $guest): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($guest->event_id !== $event->id, 404);

        $guest->delete();

        return redirect()->route('events.guests.index', $event)
            ->with('success', 'Invitado eliminado.');
    }

    public function import(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $path = $request->file('csv')->getRealPath();
        $rows = array_map('str_getcsv', file($path));

        $imported = 0;

        foreach ($rows as $row) {
            if (count($row) < 2) {
                continue;
            }

            [$name, $phone] = $row;
            $name  = trim($name);
            $phone = trim($phone);

            if (! $name || ! $phone) {
                continue;
            }

            $event->guests()->firstOrCreate(
                ['phone' => $phone],
                ['name'  => $name],
            );

            $imported++;
        }

        return redirect()->route('events.guests.index', $event)
            ->with('success', "{$imported} invitados importados.");
    }
}
