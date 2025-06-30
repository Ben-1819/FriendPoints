<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    /** @use HasFactory<\Database\Factories\FriendFactory> */
    use HasFactory;

    protected $fillable = [
        "friend_id",
        "title",
        "reason",
        "change",
        "before",
        "after",
    ];

    /**
     * Define the relationship between Friend and History
     */
    public function friend(){
        return $this->belongsTo(Friend::class());
    }
}
