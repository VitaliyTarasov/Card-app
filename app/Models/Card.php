<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'order', 'list_id', 'user_id'];

    public function list()
    {
        return $this->belongsTo(CardList::class, 'list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
