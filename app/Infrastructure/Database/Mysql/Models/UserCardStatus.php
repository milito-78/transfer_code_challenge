<?php

namespace App\Infrastructure\Database\Mysql\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCardStatus extends Model
{
    use HasFactory;
    protected $table = "user_cards_statuses";

    protected $fillable = ["id" , "title"];
}
