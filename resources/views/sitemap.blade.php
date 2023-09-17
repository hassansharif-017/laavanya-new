<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>https://laavanya-gracefullyyou.in/order-tracking</loc>
        <lastmod>2023-09-14T05:40:58+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://laavanya-gracefullyyou.in/user/register</loc>
        <lastmod>2023-09-14T05:40:58+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://laavanya-gracefullyyou.in/user/login</loc>
        <lastmod>2023-09-14T05:40:58+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://laavanya-gracefullyyou.in/wishlist</loc>
        <lastmod>2023-09-14T05:40:58+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://laavanya-gracefullyyou.in/cart</loc>
        <lastmod>2023-09-14T05:40:58+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://laavanya-gracefullyyou.in/checkout</loc>
        <lastmod>2023-09-14T05:40:58+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    @foreach ($pages as $page)
        <url>
            <loc>{{ url('/') }}/{{ $page->slug }}</loc>
            <lastmod>{{ $page->modified_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach ($products as $product)
        <url>
            <loc>{{ url('/') }}/product/{{ $product->id }}/{{ $product->slug }}</loc>
            <lastmod>{{ $product->modified_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @for ($i = 1; $i <= $storePages; $i++)
    <url>
        <loc>{{ url('/') }}/stores/62/httpslaavanya-gracefullyyouin?page={{ $i }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.41</priority>
    </url>
    @endfor
</urlset>
