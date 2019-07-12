@php
list(
    $title,
    $wysiwyg,
    $bg_color_container,
    $text_color,
) = json_decode($content)
@endphp
<div class="vc vc-article" style="background:{{ $bg_color_container }}; color:{{ $text_color }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    {{ $title }}
                </h2>
                <div>
                    {!! $wysiwyg !!}
                </div>
            </div>
        </div>
    </div>
</div>
