@php
    $groups = $pageCont::getAllowedPages('admin');
@endphp
@prepend('css')
    <style>
        .mu-sidebar {
            background: white;
            border-right: 1px solid var(--gray_300);
        }

        .mu-sidebar .prime_nav {
            padding: 10px;
            display: flex;
            gap: 6px;
            flex-direction: column;
        }

        .mu-sidebar .prime_nav::-webkit-scrollbar {
            display: none;
        }

        .mu-sidebar .prime_nav ul {
            overflow: hidden;
            transition: all 0.3s;
        }

        .mu-sidebar .prime_nav a {
            display: inline-flex;
            padding: 10px 20px;
            color: inherit;
            cursor: pointer;
            text-decoration: none;
            align-items: center;
            font-weight: 600;
            justify-content: space-between;
            transition: all 0.3s;
            font-size: 0.9em;
        }

        .mu-sidebar .prime_nav ul li a {
            padding-block: 8px;
        }

        .mu-sidebar .prime_nav ul li a:where(:hover,.active) {
            color: var(--success_dark);
        }

        .mu-sidebar .prime_nav li {
            flex-shrink: 0;
        }

        .mu-sidebar .prime_nav>li {
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid rgba(var(--success_rgb), 0.3);
        }

        .mu-sidebar .prime_nav>li.active {
            background: rgba(var(--success_rgb), 0.1);
        }

        .mu-sidebar .prime_nav>li.active>a {
            color: var(--success_dark);
            background: rgba(var(--success_rgb), 0.1);
        }

        .mu-sidebar .prime_nav a i {
            transition: all 0.3s;
            font-size: 0.8em;
        }

        .mu-sidebar .prime_nav li.active>a i {
            transform: rotate(180deg);
        }

        .mu-sidebar .prime_nav li ul {
            padding-left: 20px;
            font-size: 0.9em;
        }

        .mu-sidebar .sec_nav {
            padding: 10px;
            gap: 10px;
        }

        .clock {
            flex-grow: 1;
            border-radius: 6px;
            background: rgba(var(--success_rgb), 0.3);
        }

        #logout {
            border-radius: 6px;
            background: var(--error);
            color: white;
            transition: all 0.4s;
        }

        #logout i {
            width: 40px;
        }

        #logout:hover {
            background: var(--error_dark);
        }

        @media screen and (max-width: 950px) {
            .mu-sidebar {
                position: absolute;
                height: 100%;
                right: 0;
                transform: translateX(100%);
                transition: all 0.4s;
                z-index: 99;
                box-shadow: 0 0 0px 800px #00000000;
            }

            .mu-sidebar.active {
                transform: translateX(0);
                box-shadow: 0 0 0px 800px #00000044;
            }
        }
    </style>
@endprepend
{{ mantis(['mu-sidebar']) }}
<aside class="mu-sidebar">
    <a href="{{ url('') }}" class="brand">
        <img src="{{ url(config('mantis.logo')) }}" alt="">
    </a>
    <ul class="prime_nav">
        <li @class(['active' => $current['uri'] == 'admin'])><a href="{{ route('admin.home') }}">Dashboard</a></li>
        @foreach ($groups as $group)
            <li @class(['active' => ($current['group_id'] ?? -1) == $group['id']])>
                <a>{{ $group['title'] }}
                    <i class="fa-solid fa-chevron-down"></i></a>
                <ul>
                    @foreach ($group['display_pages'] as $page)
                        <li @class(['active' => $current['uri'] == $page['uri']])>
                            <a href="{{ url($page['uri']) }}">
                                {{ $page['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
    <nav class="sec_nav rflex">
        <div class="clock"></div>
        <a href="{{ route('admin.employee.logout') }}" id="logout" class=" mu-link">
            <i class="icon fa-solid fa-sign-out"></i>
        </a>
    </nav>
</aside>
