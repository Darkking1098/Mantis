@prependonce('css')
    <style>
        .mu-breadcrumb {
            padding: 5px 0 30px;
            font-weight: 600;
            font-size: 0.8em;
            display: flex;
            gap: 5px;
        }

        .mu-breadcrumb .mu-link {
            color: var(--prime);
            text-decoration: none;
        }

        .page_title {
            font-size: 2.6rem;
            color: var(--prime_text);
        }

        .page_desc {
            margin-top: 7px;
            font-size: 0.9em;
            color: var(--sec_text);
        }
    </style>
@endprependonce
<div class="page_details">
    <div class="page_info">
        <h1 class="page_title">{{ $current['page_title'] ?? 'Dashboard' }}</h1>
        @isset($pageDesc)
            <h6 class="page_desc">{{ $pageDesc }}</h6>
        @endisset
    </div>
    <div class="mu-breadcrumb">
        <a href="{{ url('') }}" class="mu-link">Home</a>
        <i class="sep">/</i>
        @for ($i = 0; $i < count($path) - 1; $i++)
            <a href="{{ $path[$i]['link'] }}" class="mu-link">
                {{ ucfirst($path[$i]['title']) }}
            </a>
            <i class="sep">/</i>
        @endfor
        <span>{{ ucfirst($path[count($path) - 1]['title']) }}</span>
    </div>
</div>
