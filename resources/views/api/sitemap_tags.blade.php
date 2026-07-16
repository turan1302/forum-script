<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @php $i = 0; @endphp
    @forelse($etiket_bulut as $etiket)
        @if($i==0)
            <url>
                <loc>{{url("")}}</loc>
                <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime(date('Y-m-d H:i:s'))) }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.5</priority>
            </url>
        @endif
        <url>
            <loc>{{url("/question/tags/".$etiket)}}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime(date('Y-m-d H:i:s'))) }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
        @php $i++; @endphp
    @empty
    @endforelse
</urlset>
