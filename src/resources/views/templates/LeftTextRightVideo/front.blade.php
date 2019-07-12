@php
    list(
        $right_video_url,
        $left_title,
        $left_wysiwyg,
        $bg_color_container,
        $text_color,
    ) = json_decode($content)
@endphp
<div class="vc vc-left-image-right-text" style="background:{{ $bg_color_container }}; color:{{ $text_color }}">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>
                    {{ $left_title }}
                </h2>
                <div>
                    {!! $left_wysiwyg !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="yt__embed">
                    <iframe src="//www.youtube.com/embed/{{ $right_video_url }}" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
