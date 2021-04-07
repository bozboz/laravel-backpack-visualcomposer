<div class="row-template vc-full-width-text">
    <input type="hidden" class="content">

    <input class="title" placeholder="{{ trans('visualcomposer::templates.full-width-text.crud.title') }}">

    <textarea class="wysiwyg"></textarea>

    <label>
        {{ trans('visualcomposer::templates.full-width-text.crud.bg_color_container') }}
        <select class="bg_color_container">
            @foreach(config('visualcomposer.colors') as $name => $code)
                <option value="{{ $code }}">{{ trans("visualcomposer::colors.$name") }}</option>
            @endforeach
        </select>
    </label>

    <label>
        {{ trans('visualcomposer::templates.full-width-text.crud.text_color') }}
        <select class="text_color">
            @foreach(config('visualcomposer.font_colors') as $name => $code)
                <option value="{{ $code }}">{{ trans("visualcomposer::font_colors.$name") }}</option>
            @endforeach
        </select>
    </label>
</div>

@push('crud_fields_scripts')
    <script src="{{ asset('vendor/backpack/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/backpack/ckeditor/adapters/jquery.js') }}"></script>
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            var $hiddenInput = $(".content[type=hidden]", $row);
            var fields = [
                'title',
                'wysiwyg',
                'bg_color_container',
                'text_color',
            ];

            // Setup update routine
            var update = function () {
                var contents = [];
                fields.map(function (item) {
                    contents.push($('.'+item, $row).val());
                });
                $hiddenInput.val(
                    JSON.stringify(contents)
                );
            };

            // Parse and fill fields from json passed in params
            fields.map(function (item, index) {
                try {
                    $('.'+item, $row).val(JSON.parse(content)[index]);
                } catch(e) {
                    console.log('Empty or invalid json:', content);
                }
            });

            // Setup wysiwyg
            $('.wysiwyg', $row).ckeditor({
                filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                extraPlugins: '{{ implode(',', config('visualcomposer.ckeditor.extra_plugins', [])) }}',
                toolbar: @json(config('visualcomposer.ckeditor.toolbar')),
                on: {change: update}
            });

            // Update hidden field on change
            $row.on(
                'change blur keyup',
                'input, textarea, select',
                update
            );

            // Initialize hidden form input in case we submit with no change
            update();
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .vc-full-width-text .cke_chrome {
            width: 100%;
        }
        .vc-full-width-text input {
            display: block;
            width: 100%;
            margin: 1rem 0;
        }
        .vc-full-width-text label {
            font-weight: inherit;
            margin-right: 3rem;
        }
    </style>
@endpush
