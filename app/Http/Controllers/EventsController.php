<?php

namespace App\Http\Controllers;

use App\Event;
use App\Helpers\FileHandler;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Jobs\PublishEvent;
use App\Media;
use App\Services\EventToken;
use App\Services\QRCodeGenerator;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        $data = $this->parseFormData($request);

        Event::create($data);

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

        $data = $this->parseFormData($request);

        $event->update($data);

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

        $event->delete();

        return response(200);
    }

    public function removeParticipant(Event $event, User $user) {
        $this->authorize('edit', Event::class);
        $event->removeUser($user);

        session()->flash('message', "{$user->name} remove from the event.");

        return redirect()->back();
    }

    public function publish(Event $event) {
        $users = User::isActive()->get();
        foreach ($users as $user) {
            $job = new PublishEvent($event, $user);
            $this->dispatch($job);
        }
    }

    public function getQrCode(Event $event, QRCodeGenerator $generator) {
        $token = EventToken::create(auth()->user(), $event);
        $message = url('/events/' . $event->id . '/signin?token=' . $token);
        $label = $event->title . " Sign In";
        $qrCode = $generator->create($message, $label);

        return response($qrCode->writeString(), 200)->header("Content-Type", $qrCode->getContentType());
    }

    #region Handle save photo and parse form data

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Media|null
     */
    private function savePhoto(Request $request):?Media {

        if ($request->hasFile('photo')) {
            $value = $request->file('photo');
            $fh = new FileHandler();
            $link = str_replace(public_path(), '', $fh->move($value));
            $mediaRecord = Media::whereLink($link)->first();

            if (!$mediaRecord) {
                $fields['link'] = $link;
                $fields['name'] = $value->getClientOriginalName();
                $fields['type'] = $value->getClientMimeType();
                $mediaRecord = Media::create($fields);
            } else {
                $mediaRecord->touch();
            }

            return $mediaRecord;
        }

        return null;

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function parseFormData(Request $request): array {
        $data = [
            'title'          => $request->get('title'),
            'venue'          => $request->get('venue'),
            'body'           => $request->get('body'),
            'vacancies'      => $request->get('vacancies'),
            'start_datetime' => new Carbon($request->get('start_datetime')),
            'end_datetime'   => new Carbon($request->get('end_datetime')),
        ];
        if ($request->has('remove_photo')) {
            if ($request->get('remove_photo')) {
                $data['photo'] = null;
            }
        }
        if ($mediaRecord = $this->savePhoto($request)) {
            $data['photo'] = $mediaRecord->link;
        }

        return $data;
    }

    #endregion
}
