<?php

namespace Editora\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;

class Book extends Model implements TableInterface
{
    protected $fillable = [
        'title',
        'subtitle',
        'price',
        'author_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return ['#', 'Título', 'Autor', 'Preço'];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch ($header) {
            case '#';
                return $this->id;
            case 'Autor';
                return $this->author->name;
            case 'Título';
                return $this->title;
            case 'Preço';
                return $this->price;
        }
    }
}
