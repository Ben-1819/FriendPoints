<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
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
}
