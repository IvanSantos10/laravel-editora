<?php

namespace CodeEduUser\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function Permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
