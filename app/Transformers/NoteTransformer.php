<?php

namespace App\Transformers;

use App\Note;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class NoteTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Transform object into a generic array
     *
     * @var $resource
     * @return array
     */
    public function transform(Note $note)
    {
        return [

            'id' => $note->id,
            'author_id' => $note->author_id,
            'title' => $note->title,
            'body' => $note->body,
            'created_at' => $note->created_at->format('d M Y'),
            'updated_at' => $note->updated_at->format('d M Y'),

        ];
    }

    public function includeAuthor(Note $note)
    {
        return $this->item($note->author(), new UserTransformer());
    }
}
