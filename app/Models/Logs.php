<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class logs extends Model
{
    use HasFactory;

    //them user_id de cho phep mass asigment
    protected $fillable = ['user_id', 'action'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
