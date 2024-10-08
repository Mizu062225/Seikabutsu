<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function posts()   
    {
        return $this->hasMany(Post::class);  
    }
    
    public function chats()   
    {
        return $this->hasMany(Chat::class, 'owner_id');  
    }
    
    public function likes()   
    {
        return $this->hasMany(Like::class);  
    }
    
    public function messages()   
    {
        return $this->hasMany(Message::class);  
    }
    
     // フォローしているユーザー
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id');
    }

    // フォロワー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id');
    }
    
    public function isFollowing(User $user)
    {
        return $this->followings()->where('followee_id', $user->id)->exists();
    }
    
    
}
