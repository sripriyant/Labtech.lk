<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TestParameter extends Model
{
    protected $fillable = [
        'test_master_id',
        'name',
        'symbol',
        'unit',
        'reference_range',
        'reference_image_path',
        'reference_image_width',
        'reference_image_height',
        'remarks',
        'sort_order',
        'is_active',
        'show_interpretation',
        'is_visible',
        'is_bold',
        'is_underline',
        'is_italic',
        'text_color',
        'result_column',
        'group_label',
        'display_type',
        'font_size',
        'dropdown_options',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_interpretation' => 'boolean',
        'sort_order' => 'integer',
        'is_visible' => 'boolean',
        'is_bold' => 'boolean',
        'is_underline' => 'boolean',
        'is_italic' => 'boolean',
        'result_column' => 'integer',
        'font_size' => 'integer',
    ];

    public function testMaster()
    {
        return $this->belongsTo(TestMaster::class);
    }

    protected function dropdownOptions(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value === null || $value === '') {
                    return [];
                }

                $decoded = json_decode((string) $value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    if (is_array($decoded)) {
                        return array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $decoded), static fn ($item) => $item !== ''));
                    }
                    if (is_string($decoded)) {
                        return array_values(array_filter(array_map('trim', explode(',', $decoded)), static fn ($item) => $item !== ''));
                    }
                }

                return array_values(array_filter(array_map('trim', explode(',', (string) $value)), static fn ($item) => $item !== ''));
            },
            set: function ($value) {
                if ($value === null || $value === '') {
                    return null;
                }

                if (is_string($value)) {
                    $items = array_values(array_filter(array_map('trim', explode(',', $value)), static fn ($item) => $item !== ''));
                    return empty($items) ? null : json_encode($items);
                }

                if (is_array($value)) {
                    $items = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $value), static fn ($item) => $item !== ''));
                    return empty($items) ? null : json_encode($items);
                }

                return null;
            }
        );
    }
}
