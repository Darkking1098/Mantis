@php
    if (isset($metaCont) && ($meta_required ?? true)) {
        $universal = $metaCont::getUrlData('*');
        $data = $metaCont::getUrlData();
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    {{-- browser support meta tags --}}
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- Developer Attribute --}}
    <meta author="Ajay Kumar" />
    <meta designer="Ajay Kumar" />
    <meta developer="Ajay Kumar" />
    @if (is_file(public_path('manifest.json')))
        {{-- Manifest --}}
        <link rel="manifest" href="{{ url('manifest.json') }}" />
    @endif
    @if ($canonical ?? true)
        {{-- Canonical Tag --}}
        <link rel="canonical" href="{{ Request::url() }}" />
    @endif
    {{-- Title Tag for website --}}
    <title>{{ $data['title'] ?? ($title ?? ($universal['title'] ?? 'Page Title')) }}</title>
    {{-- Meta Keywords --}}
    <meta name="keywords"
        content="{{ $data['keyword'] ?? ($keywords ?? ($universal['keyword'] ?? 'Page Keywords')) }}" />
    {{-- Meta Description --}}
    <meta name="description"
        content="{{ $data['description'] ?? ($description ?? ($universal['description'] ?? 'Page Description')) }}" />
    {{-- Other Meta tags that are usesd on all pages --}}
    {!! ($universal['other_meta'] ?? '') . ($data['other_meta'] ?? '') !!}
    {{-- html page Theme Color --}}
    <meta name="theme-color" content="{{ config('app.color', 'white') }}" />
    {{-- html page icons --}}
    @if (config('app.favicon'))
        <link rel="icon" href="{{ url(config('app.favicon')) }}" type="image/png" />
        <link rel="apple-touch-icon" href="{{ url(config('app.favicon')) }}" type="image/png" />
    @endif
    {{-- Other Meta from specific page --}}
    @stack('meta')
    {{-- Stacking css --}}
    @yield('styles')
</head>

@yield('body')

</html>
