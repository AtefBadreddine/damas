<?php
namespace App\Enums;

enum PostType: string
{
    case BLOG = 'blog';
    case DEVELOPER = 'developer';
    case REPORT = 'report';
    case NEWS = 'news';

    public static function fromSectionContentType($contentType)
    {
        if ($contentType === 'posts') {
            return self::BLOG;
        }
        $type = self::tryFrom($contentType);
        return $type ?: self::BLOG;
    }

    public static function fromRoute($routeName)
    {
        $routeName = (string) $routeName;
        foreach (self::cases() as $case) {
            $prefix = 'admin.' . $case->value;
            if ($routeName === $prefix || strpos($routeName, $prefix . '.') === 0) {
                return $case;
            }
        }
        return self::BLOG;
    }

    public static function adminListRoutes()
    {
        $routes = [];
        foreach (self::cases() as $case) {
            $routes[] = $case->adminListRoute();
        }
        return $routes;
    }

    public static function isAdminList($route)
    {
        return in_array($route, self::adminListRoutes(), true);
    }

    public function adminListRoute()
    {
        return 'admin.' . $this->value . '.posts';
    }

    /**
     * Categories, tags, and front URLs stay blog vs news.
     * Developer and report posts share the blog group.
     */
    public function categoryType()
    {
        return $this === self::NEWS ? self::NEWS->value : self::BLOG->value;
    }

    public function label()
    {
        return match ($this) {
            self::BLOG => 'Guides',
            self::DEVELOPER => 'Developers',
            self::REPORT => 'Reports',
            self::NEWS => 'News',
        };
    }

    public function frontPath()
    {
        return match ($this) {
            self::BLOG => 'guides',
            self::DEVELOPER => 'developers',
            self::REPORT => 'reports',
            self::NEWS => 'news',
        };
    }

    public function frontIndexRoute()
    {
        return match ($this) {
            self::BLOG => 'front.blog.index',
            self::DEVELOPER => 'front.developer.index',
            self::REPORT => 'front.report.index',
            self::NEWS => 'front.news',
        };
    }

    public function frontCountryRoute()
    {
        return match ($this) {
            self::BLOG => 'front.blog.country',
            self::DEVELOPER => 'front.developer.country',
            self::REPORT => 'front.report.country',
            self::NEWS => 'front.news.country',
        };
    }

    public function frontShowRoute()
    {
        return match ($this) {
            self::BLOG => 'front.blog.post.show',
            self::DEVELOPER => 'front.developer.post.show',
            self::REPORT => 'front.report.post.show',
            self::NEWS => 'front.news.post.show',
        };
    }
}
