<?php

namespace App\Enums;

/**
 * The services advertised on the public site, used as the order's work type.
 */
enum ServiceType: string
{
    case ClippingPath = 'clipping_path';
    case BackgroundRemoval = 'background_removal';
    case PhotoRetouching = 'photo_retouching';
    case GhostMannequin = 'ghost_mannequin';
    case HeadshotEditing = 'headshot_editing';
    case ColorCorrection = 'color_correction';
    case DropShadow = 'drop_shadow';
    case ImageMasking = 'image_masking';
    case EcommerceOptimisation = 'ecommerce_optimisation';
    case PhotoRestoration = 'photo_restoration';
    case AiImageFixes = 'ai_image_fixes';
    case ThreeDModelling = 'three_d_modelling';
    case VideoEditing = 'video_editing';

    public function label(): string
    {
        return match ($this) {
            self::ClippingPath => 'Clipping Path',
            self::BackgroundRemoval => 'Background Removal',
            self::PhotoRetouching => 'Photo Retouching',
            self::GhostMannequin => 'Ghost Mannequin',
            self::HeadshotEditing => 'Headshot Editing',
            self::ColorCorrection => 'Colour Correction',
            self::DropShadow => 'Drop Shadow',
            self::ImageMasking => 'Image Masking',
            self::EcommerceOptimisation => 'E-commerce Optimisation',
            self::PhotoRestoration => 'Photo Restoration',
            self::AiImageFixes => 'AI Image Fixes',
            self::ThreeDModelling => '3D Modelling & Rendering',
            self::VideoEditing => 'Video Editing',
        };
    }

    /**
     * Best-effort match of the free-text service a lead selected on the website
     * onto a service type, so converting a lead can pre-fill the order.
     */
    public static function guessFrom(?string $text): ?self
    {
        $needle = strtolower(trim((string) $text));

        if ($needle === '') {
            return null;
        }

        foreach (self::cases() as $case) {
            if (str_contains($needle, strtolower($case->label()))) {
                return $case;
            }
        }

        // A few common phrasings that do not match the label directly.
        return match (true) {
            str_contains($needle, 'clipping') => self::ClippingPath,
            str_contains($needle, 'background') => self::BackgroundRemoval,
            str_contains($needle, 'retouch') => self::PhotoRetouching,
            str_contains($needle, 'mannequin') => self::GhostMannequin,
            str_contains($needle, 'headshot') => self::HeadshotEditing,
            str_contains($needle, 'colour'), str_contains($needle, 'color') => self::ColorCorrection,
            str_contains($needle, 'shadow') => self::DropShadow,
            str_contains($needle, 'mask') => self::ImageMasking,
            str_contains($needle, 'ecommerce'), str_contains($needle, 'e-commerce') => self::EcommerceOptimisation,
            str_contains($needle, 'restor') => self::PhotoRestoration,
            str_contains($needle, '3d') => self::ThreeDModelling,
            str_contains($needle, 'video') => self::VideoEditing,
            default => null,
        };
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $s) => $s->value, self::cases());
    }
}
