<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
     protected $fillable = [
        'owner_id',
        'guest_id',
    ];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }
    
    public function messages()   
    {
        return $this->hasMany(Message::class);  
    }
}
