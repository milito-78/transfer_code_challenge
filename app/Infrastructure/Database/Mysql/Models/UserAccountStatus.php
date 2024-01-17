<?php

namespace App\Infrastructure\Database\Mysql\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccountStatus extends Model
{
    use HasFactory;

    protected $table = "user_accounts_statuses";
    protected $fillable = [
        "id","title"
    ];


}
