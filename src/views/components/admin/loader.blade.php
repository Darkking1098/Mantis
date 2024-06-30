@prependOnce('css')
    <style>
        #mu-loader {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            z-index: 99;
        }

        #mu-loader:not(.show) {
            display: none;
        }

        .mu-loader {
            border: 7px solid var(--primary, black);
            width: 60px;
            display: block;
            aspect-ratio: 1;
            animation: load 2s infinite forwards;
            border-radius: 60px;
            border-left-color: transparent;
            margin-inline: auto;
            margin-bottom: 30px;
        }

        .loading_msg {
            font-size: 1.1em;
            font-weight: 600;
        }

        @keyframes load {
            0% {
                rotate: 0deg;
            }

            100% {
                rotate: 360deg;
            }
        }
    </style>
@endPrependOnce
<div id="mu-loader" class="show">
    <div class="loader_details">
        <i class="mu-loader"></i>
        <p class="loading_msg">{{ $msg ?? 'Loading...' }}</p>
    </div>
</div>
{{ mantisJs('MLoader') }}
@prepend('js')
    <script>
        let loader = new MLoader($('#mu-loader'));
    </script>
@endprepend
