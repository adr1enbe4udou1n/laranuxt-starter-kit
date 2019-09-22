<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use App\Models\Traits\HasUser;
use Illuminate\Support\Carbon;
use App\Models\Traits\Bulkable;
use App\Models\Traits\Toggleable;
use App\Models\Traits\HasActivity;
use App\Models\Traits\Publishable;
use App\Models\Traits\HasMediaRequest;
use App\Models\Enums\PublishStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\HasTranslatableSlug;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * App\Models\Post.
 *
 * @property int                                                                          $id
 * @property int|null                                                                     $user_id
 * @property string                                                                       $type
 * @property string                                                                       $status
 * @property array                                                                        $title
 * @property array|null                                                                   $summary
 * @property array|null                                                                   $body
 * @property string                                                                       $slug
 * @property bool                                                                         $is_pinned
 * @property mixed|null                                                                   $publication_date
 * @property \Illuminate\Support\Carbon|null                                              $created_at
 * @property \Illuminate\Support\Carbon|null                                              $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[]              $activities
 * @property int|null                                                                     $activities_count
 * @property mixed                                                                        $featured_image
 * @property mixed                                                                        $is_draft
 * @property mixed                                                                        $is_published
 * @property mixed                                                                        $is_scheduled
 * @property mixed                                                                        $path
 * @property mixed                                                                        $status_badge
 * @property mixed                                                                        $status_enum
 * @property mixed                                                                        $status_label
 * @property mixed                                                                        $translations
 * @property mixed                                                                        $url
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property int|null                                                                     $media_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[]                   $tags
 * @property int|null                                                                     $tags_count
 * @property \App\Models\User|null                                                        $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post bySlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post pages()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post posts()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post scheduled()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAnyTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAnyTagsOfAnyType($tags)
 * @mixin \Eloquent
 */
class Post extends Model implements HasMedia
{
    use HasUser;
    use HasActivity;
    use Publishable;
    use HasMediaTrait;
    use HasMediaRequest;
    use HasTags;
    use HasTranslations;
    use HasTranslatableSlug;
    use Bulkable;
    use Toggleable;

    protected $fillable = [
        'title',
        'type',
        'user_id',
        'summary',
        'body',
        'status',
        'publication_date',
        'is_pinned',
        'slug',
    ];

    protected $casts = [
        'is_pinned'        => 'boolean',
        'publication_date' => 'datetime:Y-m-d H:i',
    ];

    protected $appends = [
        'path',
        'url',
        'featured_image',
        'status_enum',
        'status_label',
        'status_badge',
    ];

    protected $with = [
        'user',
        'tags',
        'user',
        'media',
    ];

    public $mediables = [
        'featured_image' => 'featured_images',
    ];

    public $translatable = [
        'title',
        'summary',
        'body',
        'slug',
    ];

    public $toggleables = [
        'is_pinned',
    ];

    public $sluggable = 'title';

    public function getPathAttribute(): ?string
    {
        switch ($this->type) {
            case 'post':
                return "/blog/{$this->slug}";
            case 'page':
                return "/$this->slug";
        }

        return null;
    }

    public function getUrlAttribute()
    {
        return config('app.client_url').$this->path;
    }

    public function getStatusEnumAttribute()
    {
        return PublishStatusEnum::make($this->status);
    }

    public function getStatusLabelAttribute()
    {
        return empty($this->status) ? null : (string) $this->status_enum;
    }

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'draft':
                return 'danger';
            case 'scheduled':
                return 'warning';
            case 'published':
                return 'success';
        }

        return 'info';
    }

    public function getFeaturedImageAttribute()
    {
        $media = $this->getFirstMedia('featured_images');

        return $media ? $media->getFullUrl() : null;
    }

    public function setPublicationDateAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['publication_date'] = Carbon::parse($value);

            return;
        }
        $this->attributes['publication_date'] = $value;
    }

    public function scopePosts(Builder $builder)
    {
        return $builder->where('posts.type', 'post');
    }

    public function scopePages(Builder $builder)
    {
        return $builder->where('posts.type', 'page');
    }

    public function scopeOrdered(Builder $builder)
    {
        // Tri par défaut par articles épinglés puis date de publication
        return $builder
            ->orderByDesc('is_pinned')
            ->orderByDesc('publication_date');
    }

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        /*
         * Appliquer les traductions du site dans sa langue par défaut
         */
        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, $this->getLocale());
        }

        /*
         * Liste des tags
         */
        $attributes['tags'] = $this->tagsWithType()->pluck('name');

        return $attributes;
    }

    public function __toString()
    {
        return (string) $this->title;
    }
}
