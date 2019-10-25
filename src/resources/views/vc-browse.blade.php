<!-- browse server input -->

<div>

	<input
		type="text"
		class="{{ $field['name'] }}"
        data-id-hook-input
		name="{{ $field['name'] }}"
        value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
	>

    <script>
    function hookupId(e){
        let id = '_'+Math.random().toString(36).slice(2);
        let input = (e.parentNode.querySelector('[data-id-hook-input]'));
        let btn = (e.parentNode.querySelector('[data-id-hook-btn]'));

        input.setAttribute('id', id);
        btn.setAttribute('data-inputid', id);

    }

    </script>
    <img onload="hookupId(this)"
    src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" width="0" height="0" alt="" />


	<div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">

	  <button type="button" 
                data-id-hook-btn
                data-inputid="{{ $field['name'] }}-filemanager" 
                class="btn btn-default popup_selector">
		<i class="fa fa-cloud-upload"></i> {{ trans('backpack::crud.browse_uploads') }}</button>
	</div>

</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}


{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
	<script>
		$(document).on('click','.popup_selector[data-inputid]',function (event) {
		    event.preventDefault();

		    // trigger the reveal modal with elfinder inside
		    var triggerUrl = "{{ url(config('elfinder.route.prefix')) }}/popup/"+event.target.getAttribute('data-inputid');

		    $.colorbox({
		        href: triggerUrl,
		        fastIframe: true,
		        iframe: true,
		        width: '80%',
		        height: '80%'
		    });
		});

		// function to update the file selected by elfinder
		function processSelectedFile(filePath, requestingField) {
		    $('#' + requestingField).val(filePath.replace(/\\/g,"/"));
		    $('#' + requestingField).trigger('change');
		}

	</script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}