<div id="visualcomposer_{{ $field['name'] }}" @include('crud::inc.field_wrapper_attributes')>

    <label>
        {{ $field['label'] }}
    </label>

    <input type="hidden"
           name="{{ $field['name'] }}"
           value="{!! htmlspecialchars(old($field['name']) ?: $field['value'] ?? json_encode($field['default'] ?? []), ENT_QUOTES, 'UTF-8', true) !!}"
            @include('crud::inc.field_attributes')>

    @if (isset($field['hint']))
        <p class="help-block">
            {!! $field['hint'] !!}
        </p>
    @endif

    <div class="vc-rows"></div>

    <div class="vc-templates">
        {{-- Load available templates --}}
        @foreach(config('visualcomposer.templates') as $template)
            <div class="vc-row"
                 data-template="{{ $template }}"
                 data-template-label="{{ trans("visualcomposer::templates.{$template::$name}.name") }}">
                <div class="vc-handle"></div>
                <div class="vc-icons">
                    <button class="up">
                        <i class="fa fa-arrow-up"></i>
                    </button>
                    <button class="down">
                        <i class="fa fa-arrow-down"></i>
                    </button>
                    <button class="trash">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <div class="vc-content">
                    {!! $template::renderCrud() !!}
                </div>
            </div>
        @endforeach
    </div>

    <select name="templates">
        <option value="" disabled selected>
            {{ trans('visualcomposer::interface.choose_a_template') }}
        </option>
        @foreach($field['templates'] ?? config('visualcomposer.templates') as $template)
            <option value="{{ $template }}">
                {{ trans("visualcomposer::templates.{$template::$name}.name") }}
            </option>
        @endforeach
    </select>
    <button class="add">
        {{ trans('visualcomposer::interface.add_template') }}
    </button>

</div>

@push('crud_fields_styles')
    <style>
        #visualcomposer_{{ $field['name'] }} .vc-templates {
            display: none;
        }

        .vc-row {
            border: solid 1px silver;
            background: #eee;
            position: relative;
            padding-left: 20px;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .vc-row:before {
            content: attr(data-template-label);
            display: block;
            padding: 10px;
            color: gray;
        }

        .vc-row .vc-handle {
            background: silver;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 20px;
        }

        .vc-row .vc-icons {
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px;
        }

        .vc-row:first-child .vc-icons .up,
        .vc-row:last-child .vc-icons .down {
            display: none;
        }

        .vc-row .vc-content {
            padding: 0 5px;
        }
    </style>
@endpush

@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function($) {
            var $crudSection = $('#visualcomposer_{{ $field['name'] }}');
            var $hiddenInput = $crudSection.find('> input[name="{{ $field['name'] }}"]');
            var $rowsContainer = $crudSection.find('.vc-rows');

            // Load rows
            $.each(JSON.parse($hiddenInput.val()), function(i, row) {
                addRow(row.template, row.content);
            });

            // Add a row
            $crudSection.find('button.add').click(function (e) {
                e.preventDefault();
                var template = $crudSection.find('select[name=templates] option:checked').val();
                template && addRow(template);
            });

            // Delete a row
            $crudSection.on('click', '.vc-row button.trash', function (e) {
                e.preventDefault();
                $row = $(this).closest('.vc-row');
                $row.remove();
                refreshVisualComposerValue();
            });

            // Move a row upwards
            $crudSection.on('click', '.vc-row button.up', function (e) {
                e.preventDefault();
                $row = $(this).closest('.vc-row');
                // save previous row
                $prev = $row.prev();
                var template = $prev.attr('data-template');
                var content = $prev.find('[type=hidden]').val();
                var order = $prev.index();
                // Remove it
                $prev.remove();
                // Re-insert it below
                addRow(template, content, order+1);
                refreshVisualComposerValue();
            });

            // Move a row downwards
            $crudSection.on('click', '.vc-row button.down', function (e) {
                e.preventDefault();
                $row = $(this).closest('.vc-row');
                // Save next row
                $next = $row.next();
                var template = $next.attr('data-template');
                var content = $next.find('[type=hidden]').val();
                var order = $next.index();
                // Remove it
                $next.remove();
                // Re-insert it above
                addRow(template, content, order-1);
                refreshVisualComposerValue();
            });

            // Refresh visual composer value. Didn’t find a better way yet.
            $crudSection.on('mousemove mousewheel', function (e) {
                setTimeout(refreshVisualComposerValue, 10);
            });

            function refreshVisualComposerValue()
            {
                var contents = [];
                $rowsContainer.find('.vc-row').each(function() {
                    contents.push({
                        template: $(this).attr('data-template'),
                        content: $(this).find('[type=hidden]').val()
                    });
                });
                $hiddenInput.val(JSON.stringify(contents));
            }

            function addRow(template, content, order)
            {
                if (window['vc_boot', template] === undefined) {
                    console.log('Template isn’t supported: '+template);
                    return;
                }
                var $row = $crudSection
                    .find(".vc-templates > .vc-row[data-template$='"+template.split('\\').pop()+"']").clone();
                if (order === undefined) {
                    $row.appendTo($rowsContainer);
                } else if (order <= 0) {
                    $row.prependTo($rowsContainer);
                } else {
                    $row.insertAfter($rowsContainer.children(':nth-child('+(order)+')'));
                }
                window['vc_boot', template]($row, content);
                refreshVisualComposerValue();
            }
        });
    </script>
@endpush
