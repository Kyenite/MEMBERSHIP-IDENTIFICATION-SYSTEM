<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    //
    use HasFactory;

    protected $table = 'donations';

    protected $fillable = [
        'fg_member_id',
        'month', 'amount',
        'date', 'year'
    ];

    public function fgMember()
    {
        return $this->belongsTo(FgMember::class, 'fg_member_id');
    }
}
