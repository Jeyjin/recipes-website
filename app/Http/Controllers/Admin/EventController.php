<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);

        Event::create($request->all());
        return redirect()->route('admin.events.index')->with('success', 'Мероприятие добавлено');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);

        Event::findOrFail($id)->update($request->all());
        return redirect()->route('admin.events.index')->with('success', 'Мероприятие обновлено');
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return redirect()->route('admin.events.index')->with('success', 'Мероприятие удалено');
    }
}