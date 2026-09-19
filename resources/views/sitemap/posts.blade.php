<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    
    
    
    @foreach ($posts as $post)
        <url>
            <loc><?= ($post->country=='oman'?route("front.blog.post.oman", $post->slug):($post->country=='syria'?route("front.blog.post.syria", $post->slug):route("front.blog.post", $post->slug))); ?></loc>
            <lastmod><?= $post->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
            <image:image>
                <image:loc>
                    <?= Helper::media_url($post->photoCard); ?>
                </image:loc>
            </image:image>
        </url>
    @endforeach
</urlset>