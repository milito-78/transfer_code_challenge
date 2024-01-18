<?php

namespace App\Infrastructure\Database\Mysql\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Entities\UserEntity;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property int $id
 * @property string $name,
 * @property string $mobile,
 * @property string $password,
 * @property Carbon $created_at,
 * @property Carbon $updated_at,
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function newFactory()
    {
        return app()->make(UserFactory::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function toEntity() : UserEntity
    {
        return new UserEntity(
            $this->id,$this->name,$this->mobile,$this->created_at,$this->updated_at
        );
    }

    public static function fromEntity(UserEntity $userEntity) : User
    {
        $user               = new User();
        $user->id           = $userEntity->id;
        $user->name         = $userEntity->name;
        $user->mobile       = $userEntity->mobile;
        $user->created_at   = $userEntity->created_at;
        $user->updated_at   = $userEntity->updated_at;
        return $user;
    }
}
