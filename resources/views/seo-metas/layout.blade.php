@php
    // Coba ambil layout dari config, default 'layouts.app'
    $layout = config('seo.layout', 'layouts.app');
    $section = config('seo.section', 'content');
@endphp

@if(View::exists($layout))
    {{-- Jika layout utama tersedia, extend ke sana --}}
    @extends($layout)

    @section($section)
        <div class="seo-wrapper">
            @yield('seo_content')
        </div>
    @endsection
@else
    {{-- Jika layout tidak ada, tampilkan standalone layout --}}
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'SEO Meta Management')</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
        <div class="container mx-auto py-6">
            @yield('seo_content')
        </div>
    </body>
    </html>
@endif
