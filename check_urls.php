<?php
$urls = [
    'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1543857778-c4a1a3e0b2eb?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1510915228340-29c85a43dcfe?auto=format&fit=crop&w=800&q=80'
];

foreach ($urls as $i => $url) {
    stream_context_set_default( [
        'http' => [
            'method' => 'HEAD'
        ]
    ]);
    $headers = get_headers($url);
    echo "New Image " . ($i+1) . ": " . $headers[0] . "\n";
}
