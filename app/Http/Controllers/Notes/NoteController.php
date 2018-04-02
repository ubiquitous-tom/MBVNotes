<?php

namespace App\Http\Controllers\Notes;

use App\Http\Requests\Notes\StoreNoteRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Note;
use App\Transformers\NoteTransformer;
use Cyvelnet\Laravel5Fractal\Facades\Fractal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all();

        return Fractal::collection($notes, new NoteTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteRequest $request)
    {
        $note = new Note();

        $note->author_id = 1; // $request->author_id;
        $note->title = $request->title;
        $note->body = $request->body;

        $note->save();

        return Fractal::item($note, new NoteTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return Fractal::item($note, new NoteTransformer());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->title = $request->get('title', $note->title);
        $note->body = $request->get('body', $note->body);

        $note->save();

        return Fractal::item($note, new NoteTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $id = $note->id;
        $title = $note->title;

        $content = [
            'response' => 200,
            'message' => 'Note ' . $id . ' - ' . $title . ' is deleted',
            'data' => [
                'id' => $id,
                'title' => $title,
            ],
        ];

        $note->delete();

        return response(json_encode($content), 200);

    }
}
