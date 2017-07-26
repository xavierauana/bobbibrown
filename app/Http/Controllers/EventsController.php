<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventRegistrationRequest;
use App\Http\Requests\Events\DeleteEventRequest;
use App\Http\Requests\Events\EditEventRequest;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\User;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->authorize('view', Event::class);

        $events = Event::all();

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $this->authorize('create', Event::class);

        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request) {

        Event::create([
            'title'          => $request->get('title'),
            'body'           => $request->get('body'),
            'vacancies'      => $request->get('vacancies'),
            'start_datetime' => new Carbon($request->get('start_datetime')),
            'end_datetime'   => new Carbon($request->get('end_datetime')),
        ]);

        return redirect()->route('events.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $this->authorize('show', Event::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event) {
        $this->authorize('edit', Event::class);

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Event               $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event) {
        $event->update([
            'title'          => $request->get('title'),
            'body'           => $request->get('body'),
            'vacancies'      => $request->get('vacancies'),
            'start_datetime' => new Carbon($request->get('start_datetime')),
            'end_datetime'   => new Carbon($request->get('end_datetime')),
        ]);

        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event) {
        $this->authorize('delete', Event::class);

        return response(200);
    }

    public function registration(EventRegistrationRequest $request, Event $event) {
        $request->user()->register($event);

        return response()->json(['status' => 'Completed', 'user' => $request->user()]);
    }

    public function removeParticipant(Event $event, User $user) {
        $this->authorize('edit', Event::class);
        $event->removeUser($user);

        session()->flash('message', "{$user->name} remove from the event.");

        return redirect()->back();
    }
}
