<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'created_by_user_id'];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    // public function events()
    // {
    //     return $this->hasMany(Event::class);
    // }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}