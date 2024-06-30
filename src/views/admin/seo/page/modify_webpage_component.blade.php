<section class="panel">
    <div class="section_info">
        <h5 class="section_title">Webpage SEO Info</h5>
        <p class="section_desc">Just normal things to create a new Webpage</p>
    </div>
    <fieldset class="cflex">
        <fieldset>
            <x-Mantis::field fname="slug" label="Webpage Slug">
                @slot('label')
                    <div class="rflex jcsb">
                        <div>
                            Page Slug
                            <i class="text success">Can not be updated</i>
                        </div>
                        <i class="text prime" style="text-transform: none;">a-z, 0-9, -, +</i>
                    </div>
                @endslot
                <input type="text" name="slug" id="page_slug"
                    value="{{ $webpage['slug'] ?? ($slug ?? ($prefix ?? '')) }}" required @readonly(($webpage['slug'] ?? '') == '*')
                    placeholder="Webpage Slug" pattern="^[a-z0-9\-+\/]*$">
            </x-Mantis::field>
            <x-Mantis::field fname="page_title">
                @slot('label')
                    <div class="rflex jcsb">
                        Page Title
                        <i class="text success"><span>0</span> char</i>
                    </div>
                @endslot
                <input type="text" name="title" id="page_title" required value="{{ $webpage['title'] ?? '' }}"
                    placeholder="Page Title">
            </x-Mantis::field>
        </fieldset>
        <fieldset>
            <x-Mantis::field fname="page_desc">
                @slot('label')
                    <div class="rflex jcsb">
                        Page Description
                        <i class="text info"><span></span></i>
                    </div>
                @endslot
                <input type="text" name="description" id="page_desc" value="{{ $webpage['description'] ?? '' }}"
                    placeholder="Page Description">
            </x-Mantis::field>
            <x-Mantis::field fname="page_keywords">
                @slot('label')
                    <div class="rflex jcsb">
                        <span>Page Keywords <i class="text info">(','seprated)</i></span>
                        <i class="text prime"><span class="count_info"></span> Keywords</i>
                    </div>
                @endslot
                <input type="text" name="keyword" id="page_keywords" value="{{ $webpage['keyword'] ?? '' }}"
                    placeholder="Keyword1, Keyword2">
            </x-Mantis::field>
        </fieldset>
        <x-Mantis::field fname="other_meta">
            @slot('label')
                Other Meta Tags
                <i class="text warn">Don't fill unnecessary</i>
            @endslot
            <textarea name="other_meta" id="other_meta" placeholder="Extra Metadata">{{ $webpage['other_meta'] ?? '' }}</textarea>
        </x-Mantis::field>
    </fieldset>
</section>
<fieldset class="cflex">
    <x-Mantis::checkbox fname="status" :checked="$webpage['status'] ?? true" label="Page is available to use" />
</fieldset>
@push('js')
    <script>
        $("#page_title").addEventListener("input", function() {
            let char = this.value.length;
            let span = $("label[for='page_title'] span")[0];
            let parent = $(span.parentElement).VU;
            span.innerText = char;
            parent.removeClass(["warn", "error"]);
            if (char > 60) parent.addClass("error");
            else if (char > 40) parent.addClass("warn")
        })
        $("#page_keywords").addEventListener("input", function() {
            let words = this.value.split(",").filter((x) => x).length;
            let span = $("label[for='page_keywords'] .count_info")[0];
            span.innerText = words;
        })
        $("#page_desc").addEventListener("input", function() {
            let char = this.value.length;
            let words = this.value.split(" ").filter((x) => x).length;
            let span = $("label[for='page_desc'] span")[0];
            span.innerText = `${char} Char, ${words} Word`;
        })
        @if ($validate ?? true)
            $('form')[0].addEventListener('submit', (e) => {
                ajax({
                    url: "{{ route('admin.webpage.check') }}",
                    async: false,
                    data: {
                        webpage: $('#page_slug').value
                    },
                    success: (res) => {
                        res = JSON.parse(res);
                        if (res.isExist) {
                            e.preventDefault();
                            alert("Web slug already exists");
                        }
                    },
                    error: () => {
                        $('#page_slug').setCustomValidity("Web slug already exists");
                    }
                });
            });
        @endif
    </script>
@endpush
