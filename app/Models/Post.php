<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Save;
use App\Models\User;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'category_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderByDesc('created_at');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function saves(): HasMany
    {
        return $this->hasMany(Save::class);
    }

    public function isLikedBy(User $user): bool
    {
        $like = $this->likes->where('user_id', $user->id)->first();

        if ($like)
            return true;
        return false;
    }

    public function isSaved(): bool
    {
        $save = $this->saves()->where(['post_id' => $this->id, 'user_id' => Auth::user()->id])->first();
        if ($save !== null)
            return true;
        return false;
    }
}
