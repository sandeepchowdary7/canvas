<?php

namespace Canvas\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends BaseEntity
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'body',
        'published_at',
    ];

    /**
     * @var array
     */
    protected $with = ['tags'];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @param $value
     * @return bool
     */
    public function getPublishedAttribute($value): bool
    {
        if ($this->published_at <= now()->toDateTimeString()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function getSlugAttribute($value): string
    {
        return kebab_case($this->title);
    }
}