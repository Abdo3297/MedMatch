<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Medicine extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
    ];

    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Component::class, 'medicine_component')
            ->withTimestamps();
    }
}
