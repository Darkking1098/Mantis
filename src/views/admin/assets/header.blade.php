@prepend('css')
    <style>
        .header_main {
            display: flex;
            flex-direction: column;
            padding: 15px 30px;
            border-bottom: 1px solid var(--gray_400);
        }

        .header_main_prime {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header_main_prime .brand {
            height: 25px;
        }

        .header_main_prime .sec_nav i {
            cursor: pointer;
            border-radius: 6px;
            width: 36px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .header_main_prime .sec_nav picture {
            height: 100%;
        }

        .header_main_prime .sec_nav i:hover {
            color: var(--success_dark);
            background: rgba(var(--success_rgb), 0.2);
            font-size: 0.9em;
        }

        .header_main_prime .sec_nav img {
            border-radius: 6px;
        }

        #menu_btn {
            display: none;
        }

        @media screen and (max-width: 950px) {
            #menu_btn {
                display: inline-flex;
            }
        }
    </style>
@endprepend
<header>
    <section class="header_main">
        <div class="header_main_prime">
            <a href="{{ url('') }}" class="brand mu-link">
                <img src="{{ url(config('mantis.logo')) }}" alt="">
            </a>
            <nav class="sec_nav rflex aic" style="gap: 12px;">
                <i class="icon img_wrap">
                    {{-- <x-Mantis::image :img="$admin['profile_img']"></x-Mantis::image> --}}
                </i>
                <i class="icon fa-solid fa-list-check" id="task_btn"></i>
                <i class="icon fa-solid fa-clock" id="time_btn"></i>
                <i class="icon fa-solid fa-bell" id="noti_btn"></i>
                <i class="icon fa-solid fa-bars" id="menu_btn"></i>
            </nav>
        </div>
        <div class="header_main_sec"></div>
    </section>
</header>
@prepend('js')
    <script>
        $('#menu_btn').addEventListener('click', () => {
            let sidebar = $('.mu-sidebar')[0];
            sidebar.MU.addClass('active');
            let domevent = (e) => {
                if (!sidebar.contains(e.target)) {
                    sidebar.MU.removeClass('active');
                    removeEventListener('click', domevent);
                }
            }
            setTimeout(() => addEventListener('click', domevent), 1);
        })
    </script>
@endprepend
