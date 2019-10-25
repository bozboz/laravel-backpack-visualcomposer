<div class="row-template vc-image-in-container">
    <input type="hidden" class="content">

    <!--<input class="image_url" type="hidden" rel="image">-->
    <div class="image">
            <img class="preview" src>
            @include('visualcomposer::vc-browse', ['field'=>['name' => 'image_url']])
            <!--<input type="file">-->
    </div>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            var $hiddenInput = $(".content[type=hidden]", $row);
            var fields = ['image_url'];

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

            // Setup picture uploader
            let $preview = $('img.preview', $row);
            let $file = $('.image_url', $row);

            // Setup picture uploader
            let updatePreview = function(){
                let src = $file.val();

                if(src.charAt(0) !== '/') 
                    src = '/'+src;

                $preview.attr('src', src);
            };

            $file.on('change', function(){
                updatePreview();
                update();
            });

            updatePreview();

            // Initialize hidden form input in case we submit with no change
            update();
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .vc-image-in-container img.preview {
            width: 720px;
            max-width: 100%;
            margin: auto;
            display: block;
        }
        .vc-image-in-container img.preview[src=""] {
            display: none;
        }
    </style>
@endpush
