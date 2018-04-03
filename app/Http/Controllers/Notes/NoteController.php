<?php

namespace App\Http\Controllers\Notes;

use App\Http\Requests\Notes\StoreNoteRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Note;
use App\Transformers\NoteTransformer;
use Cyvelnet\Laravel5Fractal\Facades\Fractal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    private $user;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->user = Auth::guard()->user();
        $author_id = $this->user->id;
        $notes = Note::where(['author_id' => $author_id])->paginate(10);

        return Fractal::includes('author')->collection($notes, new NoteTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteRequest $request)
    {
        $this->user = Auth::guard()->user();

        $note = new Note();

        $note->author_id =  $this->user->id;
        $note->title = $request->title;
        $note->body = $request->body;

        $note->save();

        return Fractal::includes('author')->item($note, new NoteTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        $this->user = Auth::guard()->user();

        return Fractal::includes('author')->item($note, new NoteTransformer());
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
        $this->user = Auth::guard()->user();
        $author_id = $this->user->id;
        $noteAuthorId = $note->author_id;

        $note->title = $request->get('title', $note->title);
        $note->body = $request->get('body', $note->body);

        if ($author_id === $noteAuthorId) {
            $note->save();
        }

        return Fractal::includes('author')->item($note, new NoteTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $this->user = Auth::guard()->user();

        $id = $note->id;
        $title = $note->title;
        $noteAuthorId = $note->author_id;
        $authorId = $this->user->id;

        $content = [
            'response' => 200,
            'message' => 'Note ' . $id . ' - ' . $title . ' is deleted',
            'data' => [
                'id' => $id,
                'title' => $title,
            ],
        ];

        if ($noteAuthorId === $authorId) {
            $note->delete();
        }

        return response(json_encode($content), 200);

    }
}
