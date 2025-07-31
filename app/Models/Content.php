<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = []; 

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime', 
        'updated_at' => 'datetime',
        'body' => 'json',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formated_status',
        'thumbnail_path',
        'cover_image_path',
        'formated_created_at',
        'formated_updated_at',
        'slug',
    ];

    /**
     * The accessors to get thumbnail with full path.
     *
     * @param string|null $value
     * 
     * @return string
     */
    public function getThumbnailPathAttribute($value)
    {
        return $this->thumbnail ? asset("uploads/content/{$this->id}/{$this->thumbnail}") : null;
    }

    /**
     * The accessors to get cover image with full path.
     *
     * @param string|null $value
     * 
     * @return string
     */
    public function getCoverImagePathAttribute($value)
    {
        return $this->cover_image ? asset("uploads/content/{$this->id}/{$this->cover_image}") : null;
    }

    /**
     * The accessors to get formated status.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getFormatedStatusAttribute($value)
    {
        switch ($this->status) {
            case 0: return __('Draft');
            case 1: return __('Published');
            default: return __('Undefined');
        }
    }

    /**
     * The accessors to get slug attribut.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getSlugAttribute($value)
    {
        return \Str::slug($this->title, "-") ."-{$this->id}";
    }

    /**
     * The accessors to get formated created_at.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getFormatedCreatedAtAttribute($value)
    {
        return $this->created_at->translatedFormat('l, d-m-Y');
    }

    /**
     * The accessors to get formated created_at.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getFormatedUpdatedAtAttribute($value)
    {
        return $this->updated_at->translatedFormat('l, d-m-Y');
    }

    /**
     * Get The model relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, "model");
    }

    /**
     * Get The model relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, "model");
    }

    /**
     * Get the model relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    /**
     * Get the model relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscribe()
    {
        return $this->hasMany(ContentSubscribe::class, "content_id", "id");
    }

    /**
     * Get the model relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ContentCategory::class, "category_id", "id");
    }
    
    /**
     * Get the model relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function support()
    {
        return $this->hasMany(Support::class);
    }
}
