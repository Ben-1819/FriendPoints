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


}
