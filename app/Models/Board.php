<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'color', 'user_id'];

    public function lists()
    {
        return $this->hasMany(CardList::class, 'board_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    protected static function booted()
    {
        static::creating(function (Board $board) {
            if (Auth::user())
            {
                $board->user()->associate(Auth::user());
            }
        });
    }
}
