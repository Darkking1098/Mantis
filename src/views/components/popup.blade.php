@prependOnce('css')
    <style>
        .mu-popup {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #00000033;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 998;
            display: flex;
            align-items: center;
            justify-content: center;
            isolation: isolate;
        }

        .popup {
            background: white;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 0 40px 0 #00000033;
        }

        .mu-popup:not(:has(.popup.active)) {
            display: none;
        }

        .popup:not(.active) {
            display: none;
        }

        .close_btn {
            z-index: 11;
            position: absolute;
            top: 0;
            right: 0;
            margin: 15px 20px;
        }
    </style>
@endPrependOnce
<div class="mu-popup">
    @stack('popup')
</div>
@prependOnce('js')
    <script>
        $('.mu-popup .close_btn').addEvent('click', function(e, n) {
            $(n.node.closest('.popup')).MU.removeClass('active');
        })
    </script>
@endPrependOnce
