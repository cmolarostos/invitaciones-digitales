<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\Template;
use Illuminate\View\View;

class CatalogController extends Controller
{
    // Catálogo público: todos los tipos y sus plantillas
    public function index(): View
    {
        $eventTypes = EventType::active()
            ->with(['templates' => fn ($q) => $q->active()])
            ->get();

        return view('catalog.index', compact('eventTypes'));
    }

    // Plantillas de un tipo específico (usado en el paso 2 del wizard vía AJAX)
    public function byType(string $slug): View
    {
        $eventType = EventType::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $templates = $eventType->templates()->active()->get();

        return view('catalog.partials.templates-grid', compact('eventType', 'templates'));
    }
}
