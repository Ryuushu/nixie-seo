<?php

namespace Nixie\Seo\Traits;

use Illuminate\Support\Facades\URL;

trait SeoHelperTrait
{
    public function seoMeta()
    {
        return $this->morphOne(\Nixie\Seo\Models\SeoMeta::class, 'seoable');
    }

    public function getOrCreateSeoMeta()
    {
        return $this->seoMeta()->firstOrCreate([]);
    }

    public function updateSeoMeta(array $data)
    {
        $seoMeta = $this->getOrCreateSeoMeta();
        $seoMeta->update($data);
        return $seoMeta;
    }

    public function generateMetaTags(): string
    {
        $seo = $this->seoMeta;
        $config = config('seo');

        $defaults = $config['defaults'] ?? [];
        $ogDefaults = $config['og_defaults'] ?? [];
        $twDefaults = $config['twitter_defaults'] ?? [];
        $separator = $config['title_separator'] ?? ' | ';

        $escape = fn($v) => htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
        $makeUrl = function ($path) {
            if (!$path) return null;
            return str_starts_with($path, 'http') ? $path : asset($path);
        };

        $html = [];

        // 🔹 TITLE
        $title = $seo->title ?? ($this->title ?? $defaults['title']);
        $fullTitle = $title . ($separator ? $separator . config('app.name') : '');
        $html[] = '<title>' . $escape($fullTitle) . '</title>';
        $html[] = '<meta name="title" content="' . $escape($fullTitle) . '">';

        // 🔹 BASIC META
        $description = $seo->description ?? $defaults['description'];
        $keywords    = $seo->keywords ?? $defaults['keywords'];
        $robots      = $seo->robots ?? $defaults['robots'];

        $html[] = '<meta name="description" content="' . $escape($description) . '">';
        $html[] = '<meta name="keywords" content="' . $escape($keywords) . '">';
        $html[] = '<meta name="robots" content="' . $escape($robots) . '">';

        $html[] = '<link rel="canonical" href="' . $escape($seo->canonical_url ?? URL::current()) . '">';

        // 🔹 OPEN GRAPH
        $ogTitle = $seo->og_title ?? $title;
        $ogDesc  = $seo->og_description ?? $description;
        $ogImage = $makeUrl($seo->og_image ?? $seo->meta_image);
        $ogUrl   = $seo->og_url ?? URL::current();
        $ogType  = $seo->og_type ?? $ogDefaults['type'];
        $ogSite  = $seo->og_site_name ?? $ogDefaults['site_name'];
        $ogLocale = $seo->og_locale ?? $ogDefaults['locale'];

        $html[] = '<meta property="og:title" content="' . $escape($ogTitle) . '">';
        $html[] = '<meta property="og:description" content="' . $escape($ogDesc) . '">';
        $html[] = '<meta property="og:type" content="' . $escape($ogType) . '">';
        $html[] = '<meta property="og:url" content="' . $escape($ogUrl) . '">';
        $html[] = '<meta property="og:site_name" content="' . $escape($ogSite) . '">';
        $html[] = '<meta property="og:locale" content="' . $escape($ogLocale) . '">';
        if ($ogImage) {
            $html[] = '<meta property="og:image" content="' . $escape($ogImage) . '">';
        }

        // 🔹 TWITTER CARD
        $twCard  = $seo->twitter_card ?? $twDefaults['card'];
        $twSite  = $twDefaults['site'];
        $twTitle = $seo->twitter_title ?? $ogTitle;
        $twDesc  = $seo->twitter_description ?? $ogDesc;
        $twImage = $makeUrl($seo->twitter_image ?? $ogImage);

        $html[] = '<meta name="twitter:card" content="' . $escape($twCard) . '">';
        $html[] = '<meta name="twitter:site" content="' . $escape($twSite) . '">';
        if ($twTitle) $html[] = '<meta name="twitter:title" content="' . $escape($twTitle) . '">';
        if ($twDesc)  $html[] = '<meta name="twitter:description" content="' . $escape($twDesc) . '">';
        if ($twImage) $html[] = '<meta name="twitter:image" content="' . $escape($twImage) . '">';

        // 🔹 AUTHOR & SCHEMA
        if ($seo->author) {
            $html[] = '<meta name="author" content="' . $escape($seo->author) . '">';
        }

        if ($seo->schema_markup) {
            $decoded = json_decode($seo->schema_markup);
            if (json_last_error() === JSON_ERROR_NONE) {
                $html[] = '<script type="application/ld+json">' . $seo->schema_markup . '</script>';
            }
        }

        return implode("\n", $html);
    }

    public static function generateFor($model): string
    {
        return $model?->generateMetaTags() ?? '';
    }
}
