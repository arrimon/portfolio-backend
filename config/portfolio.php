<?php

/**
 * Allowlist of editable settings. Admin can only edit keys listed here.
 * No raw CSS / JS / HTML settings by design.
 */
return [
    'settings' => [
        'general' => [
            'site_title' => ['label' => 'Site title', 'translatable' => true, 'max' => 120],
            'footer_text' => ['label' => 'Footer text', 'translatable' => true, 'max' => 255],
            'contact_email' => ['label' => 'Public contact email', 'translatable' => false, 'email' => true, 'max' => 150],
        ],
        'seo' => [
            'meta_title' => ['label' => 'Meta title', 'translatable' => true, 'max' => 70],
            'meta_description' => ['label' => 'Meta description', 'translatable' => true, 'input' => 'textarea', 'max' => 300],
        ],
        'theme' => [
            'accent' => ['label' => 'Accent color', 'translatable' => false, 'in' => ['indigo', 'emerald', 'rose', 'amber', 'sky'], 'default' => 'indigo'],
            'default_mode' => ['label' => 'Default mode', 'translatable' => false, 'in' => ['light', 'dark', 'system'], 'default' => 'system'],
        ],
    ],

    'social_platforms' => [
        'github' => 'GitHub',
        'linkedin' => 'LinkedIn',
        'x' => 'X (Twitter)',
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'youtube' => 'YouTube',
        'email' => 'Email',
        'website' => 'Website',
    ],
];
