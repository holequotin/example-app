<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['content','user_id','imgPath'];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function reactions() : HasMany
    {
        return $this->hasMany(Reaction::class);
    }
}