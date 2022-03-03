<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const TOP_RATED_LIMIT = 6;
    public const DEFAULT_RECORD_LIMIT = 3;
    public const DEFAULT_PAGINATION_RECORDS = 9;

    protected $table = 'recipes';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'featured_image',
        'additional_images',
        'type',
        'preparation_time',
        'preparation_level',
        'ingredients',
        'recommended',
        'approved'
    ];

    protected $casts = [
        'additional_images' => 'array',
        'ingredients' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'recipe_id', 'id')->with(['Replies']);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'recipe_id', 'id');
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->where('approved', '=', Recipe::DB_TRUE)->count();
    }
}
