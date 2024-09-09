<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    use HasFactory;
     protected $fillable = [
        'owner_id',
        'guest_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function messages()   
    {
        return $this->hasMany(Message::class);  
    }
}
