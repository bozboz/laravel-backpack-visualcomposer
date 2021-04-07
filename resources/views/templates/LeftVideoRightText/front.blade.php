@php
    list(
        $left_video_url,
        $right_title,
        $right_wysiwyg,
        $bg_color_container,
        $text_color,
    ) = json_decode($content)
@endphp
<div class="vc vc-left-video-right-text" style="background:{{ $bg_color_container }}; color:{{ $text_color }}">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="yt__embed">
                    <iframe src="//www.youtube.com/embed/{{ $left_video_url }}" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-6">
                <h2>
                    {{ $right_title }}
                </h2>
                <div>
                    {!! $right_wysiwyg !!}
                </div>
            </div>
        </div>
    </div>
</div>
