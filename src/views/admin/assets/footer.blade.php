@prepend('css')
    <style>
        footer {
            padding: 15px 30px;
        }

        footer p {
            font-size: 0.8em;
            font-weight: 600;
            gap: 5px;
        }

        footer img {
            height: 18px;
            margin-left: 8px;
        }
    </style>
@endprepend
<footer class="rflex jcsb">
    <p class="rflex jcc aic wrap">Developed by
        <a href="{{ url('') }}" class="brand mu-link">
            <img src="{{ url(config('mantis.logo')) }}" alt="MantisUi Logo">
        </a>
    </p>
    <b>2.0.0</b>
</footer>
