@prepend('css')
    <style>
        form {
            gap: 20px;
        }

        .section_info {
            margin-bottom: 20px;
        }

        .section_info .section_desc {
            margin-block: 4px 20px;
            font-size: 0.8em;
            color: var(--gray_500);
            font-weight: 600;
        }

        form .hidden {
            display: none;
        }

        .mu-btn[type="submit"] {
            background: var(--prime);
            color: white;
            transition: all 0.3s;
        }

        .mu-btn[type="submit"]:hover {
            background: var(--prime_dark);
        }

        fieldset {
            border: none;
            display: grid;
            gap: 10px 15px;
            grid-template-columns: repeat(auto-fit, minmax(min(230px, 100%), 1fr));
        }

        fieldset label.checkbox_field {
            display: flex;
            gap: 15px;
            font-size: 0.8em;
            font-weight: 600;
            cursor: pointer;
            align-items: center;
            width: fit-content;
        }
    </style>
@endprepend
<x-Mantis::admin.response :actions="$actions ?? ''" />
<form action="{{ Request::url() }}" method="post" @class(['cflex', $class ?? '']) enctype="multipart/form-data"
    id="{{ $id ?? '' }}">
    <div class="hidden">@csrf</div>
    {{ $slot }}
    {{ mantisCss(['mu-btn']) }}
    <button type="submit" class="mu-btn">{{ ucfirst($current['title'] ?? $btn) }}</button>
</form>
