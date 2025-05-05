<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FGMember extends Model
{
    //
    use HasFactory;

    protected $table = 'fg_members';
    
    protected $fillable = [
        'name', 'birthday', 'age', 'gender', 'status', 
        'fathers_name', 'mothers_name', 'folder_id', 'activity', 
        'baptism', 'communion', 'confirmation', 'marriage', 'profile', 'family_code'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'fg_member_id');
    }
}
