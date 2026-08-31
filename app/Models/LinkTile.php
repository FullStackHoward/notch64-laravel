<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LinkTile extends Model
{
    public const SECTION_MAIN = 'main';

    public const SECTION_COMMUNITY = 'community';

    public const SECTION_SOCIAL = 'social';

    protected $table = 'link_tiles';

    protected $fillable = [
        'section',
        'title',
        'url',
        'image_path',
        'bg_color',
        'bg_position',
        'bg_size',
        'bg_position_mobile',
        'bg_size_mobile',
        'open_in_new_tab',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'open_in_new_tab' => 'boolean',
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeSection(Builder $query, string $section): Builder
    {
        return $query->where('section', $section);
    }

    public function imageUrl(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        $url = Storage::disk('public')->url($this->image_path);

        /*
         * The public disk builds absolute URLs from APP_URL, which pins the
         * markup to one host and port (and to one scheme). Everything else on
         * the page uses request-relative asset() URLs, so reduce a URL on our
         * own host back to a path and leave a genuinely external one (an S3 or
         * CDN disk, later) untouched.
         */
        $appUrl = rtrim((string) config('app.url'), '/');

        if ($appUrl !== '' && str_starts_with($url, $appUrl)) {
            $url = substr($url, strlen($appUrl)) ?: '/';
        }

        return $url;
    }

    /**
     * Build the inline custom-property declarations that style this tile.
     *
     * Appearance used to live in a hand-written CSS class per tile. It now
     * travels as CSS variables on the element itself, which is what lets the
     * shared .col / .col2 / .col3 rules stay generic. Only the properties that
     * actually have a value are emitted, so the CSS-side var() fallbacks (and,
     * for the mobile pair, the desktop value) still apply to the rest.
     */
    public function styleVars(): string
    {
        $declarations = [];

        if ($color = $this->cssValue($this->bg_color)) {
            $declarations[] = "--tile-color:{$color}";
        }

        if ($url = $this->cssUrl()) {
            // Unquoted url() on purpose: cssUrl() strips everything that would
            // need quoting, so the whole style attribute stays quote-free and
            // Blade's escaping is a no-op on it.
            $declarations[] = "--tile-image:url({$url})";
        }

        if ($position = $this->cssValue($this->bg_position)) {
            $declarations[] = "--tile-pos:{$position}";
        }

        if ($size = $this->cssValue($this->bg_size)) {
            $declarations[] = "--tile-size:{$size}";
        }

        if ($positionMobile = $this->cssValue($this->bg_position_mobile)) {
            $declarations[] = "--tile-pos-m:{$positionMobile}";
        }

        if ($sizeMobile = $this->cssValue($this->bg_size_mobile)) {
            $declarations[] = "--tile-size-m:{$sizeMobile}";
        }

        return implode(';', $declarations);
    }

    /*
     * These values are admin-authored and land inside a style attribute, so
     * they are whitelisted rather than escaped: only the characters CSS colors,
     * positions and sizes actually need survive. A stray quote or semicolon
     * from a typo therefore can't terminate the declaration or the attribute.
     */
    private function cssValue(?string $value): ?string
    {
        $value = trim((string) preg_replace('/[^A-Za-z0-9#%.,\- ]/', '', (string) $value));

        return $value === '' ? null : $value;
    }

    private function cssUrl(): ?string
    {
        $url = $this->imageUrl();

        if ($url === null) {
            return null;
        }

        $url = preg_replace('/[^A-Za-z0-9\/:._\-%?=&]/', '', $url);

        return $url === '' ? null : $url;
    }
}
