<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Auth::user()
            ->events()
            ->with('template')
            ->latest()
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    // Paso 1: elegir tipo de evento
    public function create(): View
    {
        $eventTypes = EventType::active()->withCount(['templates' => fn ($q) => $q->active()])->get();

        return view('events.create-step1', compact('eventTypes'));
    }

    // Paso 2: elegir plantilla del tipo seleccionado
    public function selectTemplate(Request $request): View|RedirectResponse
    {
        $request->validate(['event_type' => ['required', 'exists:event_types,slug']]);

        $eventType = EventType::where('slug', $request->event_type)->firstOrFail();
        $templates = $eventType->templates()->active()->get();

        return view('events.create-step2', compact('eventType', 'templates'));
    }

    // Paso 3: formulario de detalles con plantilla ya elegida
    public function createWithTemplate(Template $template): View
    {
        return view('events.create-step3', compact('template'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'template_id'           => ['required', 'exists:templates,id'],
            'name'                  => ['required', 'string', 'max:255'],
            'event_date'            => ['required', 'date'],
            'event_time'            => ['nullable', 'date_format:H:i'],
            'venue_name'            => ['nullable', 'string', 'max:255'],
            'venue_address'         => ['nullable', 'string', 'max:255'],
            'venue_maps_url'        => ['nullable', 'url', 'max:500'],
            'dress_code'            => ['nullable', 'string', 'max:100'],
            'notes'                 => ['nullable', 'string', 'max:2000'],
            'custom_colors'         => ['nullable', 'array'],
            'itinerary'             => ['nullable', 'array'],
            'itinerary.*.time'      => ['nullable', 'string', 'max:10'],
            'itinerary.*.title'     => ['required_with:itinerary.*', 'string', 'max:150'],
            'itinerary.*.description' => ['nullable', 'string', 'max:300'],
        ]);

        $data['itinerary'] = array_values(array_filter(
            $data['itinerary'] ?? [],
            fn ($item) => !empty($item['title'])
        ));

        $event = Auth::user()->events()->create($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Evento creado correctamente.');
    }

    public function show(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load(['template', 'guests', 'photos']);

        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        $eventTypes = EventType::active()->with(['templates' => fn ($q) => $q->active()])->get();

        return view('events.edit', compact('event', 'eventTypes'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $data = $request->validate([
            'template_id'           => ['required', 'exists:templates,id'],
            'name'                  => ['required', 'string', 'max:255'],
            'event_date'            => ['required', 'date'],
            'event_time'            => ['nullable', 'date_format:H:i'],
            'venue_name'            => ['nullable', 'string', 'max:255'],
            'venue_address'         => ['nullable', 'string', 'max:255'],
            'venue_maps_url'        => ['nullable', 'url', 'max:500'],
            'dress_code'            => ['nullable', 'string', 'max:100'],
            'notes'                 => ['nullable', 'string', 'max:2000'],
            'custom_colors'         => ['nullable', 'array'],
            'itinerary'             => ['nullable', 'array'],
            'itinerary.*.time'      => ['nullable', 'string', 'max:10'],
            'itinerary.*.title'     => ['required_with:itinerary.*', 'string', 'max:150'],
            'itinerary.*.description' => ['nullable', 'string', 'max:300'],
        ]);

        $data['itinerary'] = array_values(array_filter(
            $data['itinerary'] ?? [],
            fn ($item) => !empty($item['title'])
        ));

        $event->update($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Evento actualizado.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Evento eliminado.');
    }

    public function restore(int $id): RedirectResponse
    {
        $event = Auth::user()->events()->withTrashed()->findOrFail($id);

        $this->authorize('restore', $event);

        $event->restore();

        return redirect()->route('events.show', $event)
            ->with('success', 'Evento restaurado.');
    }

    public function publish(Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->update([
            'status'       => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('events.show', $event)
            ->with('success', 'Evento publicado. Ya puedes compartir la invitación.');
    }
}
