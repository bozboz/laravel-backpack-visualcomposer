@php
    list(
        $left_imageset_url,
        $right_title,
        $right_wysiwyg,
        $bg_color_container,
        $text_color,
    ) = json_decode($content)
@endphp
<div class="vc vc-left-image-right-text" style="background:{{ $bg_color_container }}; color:{{ $text_color }}">
    <div class="container">
        <div class="row">
            <div class="col-md-6 breakout-imageset--left">
                @foreach (Storage::disk('uploads')->files($left_imageset_url) as $file)
                    <img class="breakout-imageset__img" src="/uploads/{{ ($file) }}" />
                @endforeach
            </div>
            <div class="col-md-6">
                <h2>{{ $right_title }}</h2>
                <div>
                    {!! $right_wysiwyg !!}
                </div>
            </div>
        </div>
    </div>
</div>
