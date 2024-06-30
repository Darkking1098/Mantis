@foreach (config('mantis.plugins') as $addon)
    @if (View::exists("MP.{$addon['plugin']}::" . $view))
        @include("MP.{$addon['plugin']}::" . $view)
    @endif
@endforeach
