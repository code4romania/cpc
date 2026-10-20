<?php

namespace App\Support;

use App\Models\StaticPage;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Str;

class StaticPageBlocks
{
    /**
     * @return list<array{key: string, lang: string, rows: int, slug: string}>
     */
    public static function fields(string $slug): array
    {
        return array_values(array_filter(
            self::definitions(),
            fn (array $field): bool => $field['slug'] === $slug && self::hasTranslation($field['lang']),
        ));
    }

    /**
     * @return array<string, array{ro: string, en: string}>
     */
    public static function defaults(string $slug): array
    {
        $defaults = [];

        foreach (self::fields($slug) as $field) {
            $defaults[$field['key']] = [
                'ro' => self::translation($field['lang'], 'ro'),
                'en' => self::translation($field['lang'], 'en'),
            ];
        }

        return $defaults;
    }

    /**
     * @return list<Textarea>
     */
    public static function formFields(string $locale): array
    {
        return array_map(function (array $field) use ($locale): Textarea {
            return Textarea::make("blocks.{$field['key']}.{$locale}")
                ->label(Str::headline($field['key']))
                ->rows($field['rows'])
                ->visible(fn (?StaticPage $record): bool => $record?->slug === $field['slug'])
                ->dehydrated(fn (?StaticPage $record): bool => $record?->slug === $field['slug']);
        }, array_values(array_filter(
            self::definitions(),
            fn (array $field): bool => self::hasTranslation($field['lang']),
        )));
    }

    /**
     * @return list<array{key: string, lang: string, rows: int, slug: string}>
     */
    private static function definitions(): array
    {
        $fields = [];

        foreach ([
            'explore' => 2,
            'learn_more' => 2,
            'emergency_title' => 2,
            'emergency_text' => 3,
            'features_title' => 2,
            'feat_edu_title' => 2,
            'feat_edu_desc' => 4,
            'feat_tools_title' => 2,
            'feat_tools_desc' => 4,
            'feat_org_title' => 2,
            'feat_org_desc' => 4,
            'feat_stats_title' => 2,
            'feat_stats_desc' => 4,
            'featured_title' => 2,
            'view_all' => 2,
            'stats_title' => 2,
            'stats_subtitle' => 3,
            'stat_cases' => 2,
            'stat_victims' => 2,
            'stat_conviction' => 2,
            'stat_recovered' => 2,
            'view_all_stats' => 2,
            'cta_title' => 2,
            'cta_subtitle' => 3,
            'cta_submit' => 2,
            'cta_partners' => 2,
        ] as $key => $rows) {
            $fields[] = ['key' => $key, 'lang' => "home.$key", 'rows' => $rows, 'slug' => 'home'];
        }

        $fields[] = ['key' => 'support_title', 'lang' => 'support_lines.title', 'rows' => 2, 'slug' => 'home'];

        foreach (['119', '116111', 'anitp', '112'] as $line) {
            foreach (['number' => 2, 'name' => 2, 'detail' => 3] as $part => $rows) {
                $fields[] = [
                    'key' => "support_{$line}_{$part}",
                    'lang' => "support_lines.lines.$line.$part",
                    'rows' => $rows,
                    'slug' => 'home',
                ];
            }
        }

        foreach ([
            'subtitle' => 3,
            'mission_title' => 2,
            'values_title' => 2,
            'offer_title' => 2,
            'notice_title' => 2,
            'notice_body' => 4,
        ] as $key => $rows) {
            $fields[] = ['key' => $key, 'lang' => "about.$key", 'rows' => $rows, 'slug' => 'about'];
        }

        foreach (['evidence', 'accessible', 'trauma', 'child'] as $value) {
            foreach (['title' => 2, 'body' => 4] as $part => $rows) {
                $fields[] = [
                    'key' => "value_{$value}_{$part}",
                    'lang' => "about.values.$value.$part",
                    'rows' => $rows,
                    'slug' => 'about',
                ];
            }
        }

        foreach (['education', 'tools', 'development', 'cases'] as $offer) {
            foreach (['title' => 2, 'body' => 4] as $part => $rows) {
                $fields[] = [
                    'key' => "offer_{$offer}_{$part}",
                    'lang' => "about.offers.$offer.$part",
                    'rows' => $rows,
                    'slug' => 'about',
                ];
            }
        }

        foreach ([
            'website' => 2,
            'email' => 2,
            'phone' => 2,
            'partnership_title' => 2,
            'partnership_body' => 3,
            'partnership_button' => 2,
        ] as $key => $rows) {
            $lang = match ($key) {
                'partnership_title' => 'partnership.cta_title',
                'partnership_body' => 'partnership.cta_body',
                'partnership_button' => 'partnership.cta_button',
                default => "contact.$key",
            };
            $fields[] = ['key' => $key, 'lang' => $lang, 'rows' => $rows, 'slug' => 'contact'];
        }

        foreach (['anitp', 'fonpc', 'eliberare', 'tdh', 'world_vision', 'code'] as $organization) {
            foreach ([
                'name' => 2,
                'body' => 5,
                'website' => 2,
                'website_url' => 2,
                'email' => 2,
                'phones' => 3,
                'note' => 2,
            ] as $part => $rows) {
                $fields[] = [
                    'key' => "org_{$organization}_{$part}",
                    'lang' => "contact.organizations.$organization.$part",
                    'rows' => $rows,
                    'slug' => 'contact',
                ];
            }
        }

        return $fields;
    }

    private static function hasTranslation(string $key): bool
    {
        $value = __($key, [], 'ro');

        if (is_array($value)) {
            return $value !== [];
        }

        return $value !== $key;
    }

    private static function translation(string $key, string $locale): string
    {
        $value = __($key, [], $locale);

        if (is_array($value)) {
            return implode("\n", array_map(strval(...), $value));
        }

        return $value !== $key ? $value : '';
    }
}
