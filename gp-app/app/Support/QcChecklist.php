<?php

namespace App\Support;

use App\Enums\ServiceType;

/**
 * The checks a QC reviewer works through, per service.
 *
 * Hard-coded for now; the shape (service => ordered list of checks) is what a
 * future editable version would store, so moving this to the database later
 * does not change how callers use it.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class QcChecklist
{
    /**
     * Checks that apply to any service, used when a service has no specific
     * list of its own.
     *
     * @var list<string>
     */
    private const GENERAL = [
        'Matches the client brief',
        'Consistent across the whole batch',
        'Correct dimensions and file format',
        'No visible artefacts or stray pixels',
    ];

    /**
     * @var array<string,list<string>>
     */
    private const CHECKLISTS = [
        'clipping_path' => [
            'Edges clean and precise',
            'No halos or white fringing',
            'Transparency correct where required',
            'Path follows the product, not the shadow',
            'Layer structure intact',
        ],
        'background_removal' => [
            'Background fully removed',
            'No residual colour cast from the old background',
            'Fine detail preserved at the edges',
            'Replacement background is even',
        ],
        'photo_retouching' => [
            'Skin texture retained, not plastic',
            'Colour consistent across the set',
            'No cloning or healing artefacts',
            'Blemishes removed as briefed',
            'Highlights and shadows still natural',
        ],
        'ghost_mannequin' => [
            'Neck joint seamless',
            'Interior label visible where required',
            'Symmetry and proportions correct',
            'Shadows consistent with the product',
            'No mannequin visible anywhere',
        ],
        'headshot_editing' => [
            'Skin natural and unretouched-looking',
            'Eyes sharp and catchlights intact',
            'Stray hairs tidied without gaps',
            'Background even',
        ],
        'color_correction' => [
            'White balance neutral',
            'Colour matches the physical product',
            'Consistent across the whole set',
            'No clipped highlights or crushed blacks',
        ],
        'drop_shadow' => [
            'Shadow direction consistent across the set',
            'Opacity and softness look natural',
            'Shadow grounded to the product',
            'No hard edges where there should be falloff',
        ],
        'image_masking' => [
            'Hair and fur detail preserved',
            'Semi-transparent areas handled correctly',
            'No fringing from the old background',
            'Mask edges soft where appropriate',
        ],
        'ecommerce_optimisation' => [
            'Meets the target marketplace specification',
            'Product fills the frame consistently',
            'File size within limits',
            'Correct aspect ratio and resolution',
        ],
        'photo_restoration' => [
            'Damage repaired without inventing detail',
            'Grain and texture consistent with the original',
            'Colour or tone true to the period',
            'Faces reconstructed faithfully',
        ],
        'ai_image_fixes' => [
            'Anatomy and proportions corrected',
            'No residual AI artefacts',
            'Text and logos legible and correct',
            'Lighting internally consistent',
        ],
        'three_d_modelling' => [
            'Geometry clean and watertight',
            'Textures aligned with no visible seams',
            'Lighting and reflections plausible',
            'Renders at the agreed resolution',
        ],
        'video_editing' => [
            'Cuts land on the beat as briefed',
            'Audio levels consistent throughout',
            'Colour graded consistently across shots',
            'Exported at the agreed codec and resolution',
        ],
    ];

    /**
     * Ordered checks for a service.
     *
     * @return list<string>
     */
    public static function for(ServiceType $service): array
    {
        return self::CHECKLISTS[$service->value] ?? self::GENERAL;
    }

    /**
     * Whether this service has its own list rather than falling back to the
     * general one.
     */
    public static function hasSpecificList(ServiceType $service): bool
    {
        return isset(self::CHECKLISTS[$service->value]);
    }

    /**
     * @return list<string>
     */
    public static function general(): array
    {
        return self::GENERAL;
    }
}
