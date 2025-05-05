<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //
    protected $fillable = [
        'folder_name'
    ];

    public function members()
    {
        return $this->hasMany(FGMember::class, 'folder_id');
    }
}
