<?php

namespace App\Infrastructure\Database\Mysql\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title",
    ];
}
