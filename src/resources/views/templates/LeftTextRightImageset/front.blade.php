@php
    list(
        $right_imageset_url,
        $left_title,
        $left_wysiwyg,
        $bg_color_container,
        $text_color,
    ) = json_decode($content)
@endphp
<div class="vc vc-left-text-right-imageset" style="background:{{ $bg_color_container }}; color:{{ $text_color }}">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>{{ $left_title }}</h2>
                <div>
                    {!! $left_wysiwyg !!}
                </div>
            </div>
            <div class="col-md-6 breakout-imageset--right">
                @foreach (Storage::disk('uploads')->files($right_imageset_url) as $file)
                    <img class="breakout-imageset__img" src="/uploads/{{ ($file) }}" />
                @endforeach
            </div>
        </div>
    </div>
</div>
