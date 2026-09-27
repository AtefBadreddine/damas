<?php
namespace App\Enums;

/**
 * Post type values (blog, developer, report, news).
 * Class-based stand-in for a backed enum so PHP 7.4+ / 8.0 can parse this file.
 */
final class PostType
{
    /** @var PostType */
    public static $BLOG;

    /** @var PostType */
    public static $DEVELOPER;

    /** @var PostType */
    public static $REPORT;

    /** @var PostType */
    public static $NEWS;

    /** @var string */
    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function boot()
    {
        if (self::$BLOG instanceof self) {
            return;
        }

        self::$BLOG = new self('blog');
        self::$DEVELOPER = new self('developer');
        self::$REPORT = new self('report');
        self::$NEWS = new self('news');
    }

    /**
     * @return PostType[]
     */
    public static function cases()
    {
        self::boot();

        return array(self::$BLOG, self::$DEVELOPER, self::$REPORT, self::$NEWS);
    }

    /**
     * @param string $value
     * @return PostType|null
     */
    public static function tryFrom($value)
    {
        $value = (string) $value;
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        return null;
    }

    public static function fromSectionContentType($contentType)
    {
        if ($contentType === 'posts') {
            return self::$BLOG;
        }
        $type = self::tryFrom($contentType);

        return $type ?: self::$BLOG;
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

        return self::$BLOG;
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
        return $this === self::$NEWS ? self::$NEWS->value : self::$BLOG->value;
    }

    public function label()
    {
        if ($this === self::$BLOG) {
            return 'Guides';
        }
        if ($this === self::$DEVELOPER) {
            return 'Developers';
        }
        if ($this === self::$REPORT) {
            return 'Reports';
        }

        return 'News';
    }

    public function frontPath()
    {
        if ($this === self::$BLOG) {
            return 'guides';
        }
        if ($this === self::$DEVELOPER) {
            return 'developers';
        }
        if ($this === self::$REPORT) {
            return 'reports';
        }

        return 'news';
    }

    public function frontIndexRoute()
    {
        if ($this === self::$BLOG) {
            return 'front.blog.index';
        }
        if ($this === self::$DEVELOPER) {
            return 'front.developer.index';
        }
        if ($this === self::$REPORT) {
            return 'front.report.index';
        }

        return 'front.news';
    }

    public function frontCountryRoute()
    {
        if ($this === self::$BLOG) {
            return 'front.blog.country';
        }
        if ($this === self::$DEVELOPER) {
            return 'front.developer.country';
        }
        if ($this === self::$REPORT) {
            return 'front.report.country';
        }

        return 'front.news.country';
    }

    public function frontShowRoute()
    {
        if ($this === self::$BLOG) {
            return 'front.blog.post.show';
        }
        if ($this === self::$DEVELOPER) {
            return 'front.developer.post.show';
        }
        if ($this === self::$REPORT) {
            return 'front.report.post.show';
        }

        return 'front.news.post.show';
    }
}

PostType::boot();
