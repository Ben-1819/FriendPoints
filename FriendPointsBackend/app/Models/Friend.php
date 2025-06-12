<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{

    /** @use HasFactory<\Database\Factories\FriendFactory> */
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "owner_id",
        "group",
        "points",
    ];

    /**
     * Define the relationship between Friend and User for the user_id column
     */
    public function friend(){
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship between Friend and User for the owner_id column
     */
    public function owner(){
        return $this->belongsTo(User::class(), "owner_id", "id");
    }

    /**
     * Define the relationship between Friend and History
     */
    public function history(){
        return $this->hasMany(History::class());
    }
}
