<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleType;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasMedia
{
    use HasFactory, HasRoles, InteractsWithMedia, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'ssn',
        'result',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')->singleFile();
        $this->addMediaCollection('rays');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $user = Auth::user();

        if ($panel->getId() === 'admin') {
            return $user->hasRole(RoleType::admin->value);
        } elseif ($panel->getId() === 'doctor') {
            return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
        } else {
            return false;
        }
    }

    public function surgeries(): BelongsToMany
    {
        return $this->belongsToMany(Surgery::class, 'user_surgery')
            ->withTimestamps();
    }

    public function allergies(): BelongsToMany
    {
        return $this->belongsToMany(Allergy::class, 'user_allergy')
            ->withTimestamps();
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'user_medicine')
            ->withTimestamps();
    }

    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'user_disease')
            ->withTimestamps();
    }
}
