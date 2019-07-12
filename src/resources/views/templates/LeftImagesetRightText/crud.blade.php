<div class="row-template vc-left-imageset-right-text">
    <input type="hidden" class="content">

    <div class="float-left">
        <input class="left_imageset_url" rel="left_imageset" placeholder="{{ trans('visualcomposer::templates.left-imageset-right-text.crud.left_imageset_url') }}">
    </div>

    <div class="float-right">
        <input class="right_title" placeholder="{{ trans('visualcomposer::templates.left-imageset-right-text.crud.right_title') }}">
        <textarea class="right_wysiwyg"></textarea>
    </div>

    <div class="clearfix"></div>

    <label>
        {{ trans('visualcomposer::templates.left-imageset-right-text.crud.bg_color_container') }}
        <select class="bg_color_container">
            @foreach(config('visualcomposer.colors') as $name => $code)
                <option value="{{ $code }}">{{ trans("visualcomposer::colors.$name") }}</option>
            @endforeach
        </select>
    </label>

    <label>
        {{ trans('visualcomposer::templates.left-imageset-right-text.crud.text_color') }}
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
                'left_imageset_url',
                'right_title',
                'right_wysiwyg',
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

            // Setup wysiwygs
            $('.right_wysiwyg', $row).ckeditor({
                height: '260px',
                filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                extraPlugins: '{{ implode(',', config('visualcomposer.ckeditor.extra_plugins', [])) }}',
                toolbar: @json(config('visualcomposer.ckeditor.toolbar')),
                on: {change: update}
            });

            // imageset
            // See /project/vendor/backpack/crud/src/resources/views/fields/imageset.blade.php for imageset tricks

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
        .vc-left-imageset-right-text .cke_chrome {
            width: 100%;
        }
        .vc-left-imageset-right-text input {
            display: block;
            width: 100%;
            margin: 1rem 0;
        }
        .vc-left-imageset-right-text .float-right {
            width: 49%;
            float: right;
        }
        .vc-left-imageset-right-text .float-left {
            width: 49%;
            float: left;
        }
        .vc-left-imageset-right-text img {
            width: 100%;
            height: 450px;
            object-fit: contain;
            font-family: 'object-fit: contain;';
            margin: auto;
            display: block;
        }
        .vc-left-imageset-right-text img[src=""] {
            display: none;
        }
    </style>
@endpush
