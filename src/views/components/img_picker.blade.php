<label for="{{ $fname }}" @class(['img_picker', ...explode(' ', $class ?? '')])>
    {!! $slot !!}
    <div class="hidden">
        <input type="file" name="{{ $fname }}" id="{{ $fname }}" onchange="display_pic(this)">
    </div>
</label>
@prependOnce('js')
    <script>
        function display_pic(input) {
            let img_con = $(input.closest('.img_con'));
            img_con.MU.$('.preview')[0].src = URL.createObjectURL(input.files[0]);
        }
    </script>
@endPrependOnce
