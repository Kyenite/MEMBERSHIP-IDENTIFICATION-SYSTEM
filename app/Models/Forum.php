<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Forum extends Model
{
    //use HasFactory;

    protected $table = 'forum';

    protected $fillable = [
        'user_id',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
