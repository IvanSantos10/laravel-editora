<?php

namespace Editora;

use Bootstrapper\Interfaces\TableInterface;
use CodeEduUser\Models\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model implements TableInterface
{
    protected $fillable = [
        'title',
        'subtitle',
        'price',
        'user_id'
    ];

    public function user()
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
        return ['#', 'Título', 'Subtítulo', 'Preço', 'Autor'];
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
            case 'Título';
                return $this->title;
            case 'Subtítulo';
                return $this->subtitle;
            case 'Preço';
                return $this->price;
            case 'Autor';
                return $this->user->name;
        }
    }
}
