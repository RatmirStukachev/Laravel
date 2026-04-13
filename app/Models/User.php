<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email',
        'password',
        'role',                
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected  $casts = [
        'password' => 'hashed',
        'info' => 'array',
        'role' => UserRoleEnum::class,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == UserRoleEnum::ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role == UserRoleEnum::ADMIN;
    }
}
