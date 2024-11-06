<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Component extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
    ];

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'medicine_component')
            ->withTimestamps();
    }
}
