<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<?php
    $url = LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale());
?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc><?= $url."/projects"; ?></loc>
    </sitemap>
    <sitemap>
        <loc><?= $url."/posts"; ?></loc>
    </sitemap>
    <sitemap>
        <loc><?= $url."/news"; ?></loc>
    </sitemap>
    <sitemap>
        <loc><?= $url."/links"; ?></loc>
    </sitemap>
</sitemapindex>