<?php

namespace Nixie\Seo\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $table = 'seo_metas';

    protected $fillable = [
        // Polymorphic relation
        'seoable_type',
        'seoable_id',

        // Basic meta fields
        'url',
        'title',
        'description',
        'keywords',
        'robots',
        'canonical_url',

        // Open Graph
        'og_title',
        'og_description',
        'og_image',
        'og_image_alt',
        'og_type',
        'og_url',
        'og_site_name',
        'og_locale',

        // Twitter
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',

        // Schema (JSON)
        'schema_markup',

        // Author & Publisher
        'author',
        'publisher',

        // Visuals
        'meta_image',
        'favicon',
    ];

    protected $casts = [
        'schema_markup' => 'array',
    ];

    /**
     * Relasi polymorphic ke model lain (seoable)
     */
    public function seoable()
    {
        return $this->morphTo();
    }
}
