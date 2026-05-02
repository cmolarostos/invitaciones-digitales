<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function show(string $slug): View
    {
        $event = Event::with(['template', 'photos'])
            ->where('slug', $slug)
            ->where('status', '!=', 'draft')
            ->firstOrFail();

        return view($event->template->blade_file, compact('event'));
    }
}
