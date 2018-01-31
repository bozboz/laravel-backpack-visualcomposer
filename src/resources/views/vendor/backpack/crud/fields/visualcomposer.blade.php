{{-- Only one Visual Composer per CRUD --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    <div id="visualcomposer_{{ $field['name'] }}"
            @include('crud::inc.field_wrapper_attributes')>

        <label>
            {{ $field['label'] }}
        </label>

        <input type="hidden"
               name="{{ $field['name'] }}"
               value="{{ json_encode($field['value']) }}"
                @include('crud::inc.field_attributes')>

        @if (isset($field['hint']))
            <p class="help-block">
                {!! $field['hint'] !!}
            </p>
        @endif

        <div class="vc-rows">
            {{-- Load rows from model --}}
            @foreach($field['value'] as $row)
                <?php /** @var \Novius\Backpack\VisualComposer\Models\VisualComposerRow $row */ ?>
                <div class="vc-row"
                     data-rowid="{{ $row->id }}"
                     data-template="{{ class_basename($row->template_class) }}">
                    <div class="vc-handle"></div>
                    <div class="vc-icons">
                        <button class="trash">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <div class="vc-content">
                        {!! $row->template_class::renderCrud($row) !!}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="vc-templates">
            {{-- Load available templates --}}
            @foreach(config('visualcomposer.templates') as $template)
                <div class="vc-row"
                     data-template="{{ class_basename($template) }}">
                    <div class="vc-handle"></div>
                    <div class="vc-icons">
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
            @foreach(config('visualcomposer.templates') as $template)
                <option value="{{ class_basename($template) }}">
                    {{ $template::$name }} — {{ $template::$description }}
                </option>
            @endforeach
        </select>
        <button class="add">
            Ajouter
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
                margin-bottom: 5px;
            }

            .vc-row .vc-handle {
                background: silver;
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                width: 20px;
                cursor: move;
            }

            .vc-row .vc-icons {
                position: absolute;
                top: 0;
                right: 0;
            }

            .vc-row .vc-content {
                padding: 20px;
            }
        </style>
    @endpush

    @push('crud_fields_scripts')
        <script>
            jQuery(document).ready(function($) {
                $crudSection = $('#visualcomposer_{{ $field['name'] }}');
                $hiddenInput = $crudSection.find('input[type=hidden]');
                $rowsContainer = $crudSection.find('.vc-rows');

                // Debug: Load all templates
                $crudSection.find('.vc-templates > .vc-row').clone().appendTo($rowsContainer);

                $crudSection.find('button.add').click(function (e) {
                    e.preventDefault();
                    insertRow($crudSection.find('select[name=templates] option:checked').val());
                });

                $crudSection.find('button.get-visualcomposer-content').click(function (e) {
                    e.preventDefault();
                    refreshVisualComposerValue();
                });

                $crudSection.on('click', '.vc-row button.trash', function (e) {
                    e.preventDefault();
                    $row = $(this).closest('.vc-row');
                    deleteRow($row);
                    refreshVisualComposerValue();
                });

                function insertRow(template)
                {
                    $crudSection.find('.vc-templates > .vc-row[data-template='+template+']').clone().appendTo($rowsContainer);
                    refreshVisualComposerValue();
                }

                function deleteRow($row)
                {
                    $row.remove();
                    refreshVisualComposerValue();
                }

                function refreshVisualComposerValue()
                {
                    var contents = [];
                    $rowsContainer.find('.vc-row').each(function() {
                        contents.push(JSON.parse(
                            $(this).find('input[type=hidden]').val()
                        ));
                    });
                    $hiddenInput.val(JSON.stringify(contents));
                }
            });
        </script>
    @endpush

@endif
