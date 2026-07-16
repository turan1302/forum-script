<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @php $i = 0; @endphp
    @forelse($users as $user)
        @if($i==0)
            <url>
                <loc>{{url("")}}</loc>
                <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($user->updated_at)) }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.5</priority>
            </url>
        @endif
        <url>
            <loc>{{url("user/".$user->nickname)}}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($user->updated_at)) }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
        @php $i++; @endphp
    @empty
    @endforelse
</urlset>
