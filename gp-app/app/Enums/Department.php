<?php

namespace App\Enums;

/**
 * The four departments described on the GraphicsPixels about page.
 */
enum Department: string
{
    case Administration = 'administration';
    case Marketing = 'marketing';
    case Production = 'production';
    case QualityControl = 'quality_control';

    public function label(): string
    {
        return match ($this) {
            self::Administration => 'Administration',
            self::Marketing => 'Marketing',
            self::Production => 'Production',
            self::QualityControl => 'Quality Control',
        };
    }
}
