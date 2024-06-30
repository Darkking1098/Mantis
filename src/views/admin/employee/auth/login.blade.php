@extends('Mantis::layout.mantis')
@prepend('css')
    <style>
        main {
            padding: 50px 25px 0;
        }

        .form_wrapper {
            width: min(350px, 100%);
        }

        .form_wrapper form .form_info {
            gap: 25px;
            margin-bottom: 35px;
        }

        form #admin_text {
            width: 100%;
            justify-content: space-between;
            display: flex;
            font-weight: 600;
            font-size: 0.9em;
        }

        form #admin_text span {
            opacity: 0.15;
            animation: blink 4s linear calc(var(--i) * 0.1s) infinite;
        }

        .form_wrapper form {
            gap: 15px;
        }

        .form_wrapper form a.brand {
            height: 30px;
            margin-inline: auto;
        }

        .form_wrapper form a.brand img {
            height: 100%;
        }

        .form_wrapper form .mu-btn {
            border-radius: 6px;
            background: var(--gray_700);
            color: white;
        }
        .form_wrapper form .mu-btn:hover {
            background: black;
        }

        .form_wrapper .brand_footer {
            margin-top: 45px;
        }

        .form_wrapper .brand_footer p {
            font-size: 0.7em;
            font-weight: 600;
            gap: 5px;
            padding: 20px;
        }

        .form_wrapper .brand_footer img {
            height: 14px;
        }

        @keyframes click {

            0%,
            100% {
                transform: unset;
                box-shadow: 2px 2px 0 0 #00000022;
            }

            50% {
                transform: translate(2px, 2px);
                box-shadow: 0px 0px 0 0 #00000022;
            }
        }

        @keyframes blink {

            0%,
            40% {
                opacity: 0.15;
                scale: 0.8;
            }

            20% {
                opacity: 1;
                scale: 1.5;
            }
        }

        p.error {
            font-size: 0.7em;
            font-weight: 600;
            color: var(--error);
            text-align: right;
            margin: -5px 0 0;
        }
    </style>
@endprepend
@section('layout')
    <main class="cflex aic jcc">
        <div class="form_wrapper cflex">
            <form action="{{ Request::url() }}" method="post" class="cflex">
                @csrf
                <div class="form_info cflex aic">
                    <a href="{{ url('') }}" class="brand mu-link"><img src="{{ url(config('mantis.logo')) }}"
                            alt="MantisUi Logo"></a>
                    <p class="h6" id="admin_text">Admin Verification</p>
                </div>
                {{ mantis(['mu-field', 'mu-field1', 'mu-btn']) }}
                <x-Mantis::field label="USERNAME" fname="username">
                    <input type="text" name="username" id="username" placeholder="Username" required />
                </x-Mantis::field>
                <x-Mantis::field label="PASSWORD" fname="password">
                    <input type="password" name="password" id="password" placeholder="Password" required />
                </x-Mantis::field>
                @if (session('result'))
                    <p class="error">{{ session('result')['msg'] }}</p>
                @endif
                <button class="mu-btn">Log In</button>
            </form>
            <div class="brand_footer jse">
                <p class="rflex jcc aic wrap">Powered By
                    <a href="{{ url('') }}" class="brand mu-link">
                        <img src="{{ url(config('mantis.logo')) }}" alt="MantisUi Logo">
                    </a>
                </p>
            </div>
        </div>
    </main>
    {{ mantisJs('MText') }}
@endsection
@prepend('js')
    <script>
        $('#admin_text').MU.MText.split();
        // $("#myForm").MU.ajaxSubmit({
        //     url: "{{ url('api/admin/login') }}",
        //     success: (res) => {
        //         res = JSON.parse(res);
        //     }
        // });
    </script>
@endprepend
