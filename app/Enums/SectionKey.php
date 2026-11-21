<?php

namespace App\Enums;

/**
 * The ONLY section keys the CMS knows. Astro's section registry must mirror this list.
 * Admin cannot create arbitrary keys, component names, CSS or JS.
 */
enum SectionKey: string
{
    case Hero = 'hero';
    case About = 'about';
    case Skills = 'skills';
    case Experience = 'experience';
    case Education = 'education';
    case Projects = 'projects';
    case Services = 'services';
    case Testimonials = 'testimonials';
    case Blog = 'blog';
    case Contact = 'contact';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    /** Allowed layout variants per section (allowlist). */
    public function variants(): array
    {
        return match ($this) {
            self::Hero => ['default', 'centered'],
            self::Skills => ['default', 'grid', 'bars'],
            self::Projects => ['default', 'grid', 'list'],
            self::Experience, self::Education => ['default', 'timeline'],
            default => ['default'],
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $c) => $c->value, self::cases());
    }
}
