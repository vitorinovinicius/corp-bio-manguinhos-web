@if(isset($occurrence_forms) && $occurrence_forms->count() > 0)
    @php $i = 0 @endphp
    @foreach($occurrence_forms as $occurrence_form)
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">{{$occurrence_form->form->name }}</h3>
            </div>
            <div class="card-content">
                <div class="card-body box-body">
                    <input type="hidden" name="form[{{$i}}][contractor_id]" value="{{$occurrence_form->form->contractor_id}}">
                    <input type="hidden" name="form[{{$i}}][id]" value="{{$occurrence_form->form->id}}">
                    <input type="hidden" name="form[{{$i}}][name]" value="{{$occurrence_form->form->name}}">
                    <input type="hidden" name="form[{{$i}}][description]" value="{{$occurrence_form->form->description}}">
                    <input type="hidden" name="form[{{$i}}][uuid]" value="{{$occurrence_form->form->uuid}}">

                    @php $s = 0 @endphp
                    @foreach($occurrence_form->form->form_sections as $formSection)
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][contractor_id]" value="{{$formSection->contractor_id}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_id]" value="{{$formSection->form_id}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][id]" value="{{$formSection->id}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][name]" value="{{$formSection->name}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][description]" value="{{$formSection->description}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][uuid]" value="{{$formSection->uuid}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][updated_at]" value="{{$formSection->updated_at}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][created_at]" value="{{$formSection->created_at}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_group_id]" value="{{$formSection->form_group_id}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_group_id]" value="{{$formSection->form_group_id}}">

                        <div class="card border">
                            <div class="card-header">
                                <h3 class="box-title">{{$formSection->name }}</h3>
                            </div>
                            <div class="card-content">
                                <div class="card-body box-body">
                                    @php $f = 0 @endphp
                                    @foreach($formSection->form_fields as $field)

                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][form_section_id]" value="{{$field->form_section_id}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][is_photo]" value="{{$field->is_photo}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][code]" value="{{$field->code}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][min_photo]" value="{{$field->min_photo}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][description]" value="{{$field->description}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][required_photo]" value="{{$field->required_photo}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][created_at]" value="{{$field->created_at}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][list]" value="{{$field->list}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][uuid]" value="{{$field->uuid}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][deleted_at]" value="{{$field->deleted_at}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][required]" value="{{$field->required}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][contractor_id]" value="{{$field->contractor_id}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][updated_at]" value="{{$field->updated_at}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][type_field]" value="{{$field->type_field}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][name]" value="{{$field->name}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][id]" value="{{$field->id}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][item_inspection]" value="{{$field->item_inspection}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][acceptance_criteria]" value="{{$field->acceptance_criteria}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][status]" value="{{$field->status}}">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div>
                                                        <label class="cs-label">{{$field->name }}</label>
                                                        <p>{!! $field->description !!}</p>
                                                    </div>
                                                    <div class="">

                                                        @if ($field->type_field == 1 || $field->type_field == 3 || $field->type_field == 6)
                                                            @php
                                                                $values = array_filter(explode(';',$field->value));
                                                                $list = array_filter(explode(';',$field->list));
                                                            @endphp
                                                        @endif

                                                        @switch($field->type_field)

                                                            @case(1)
                                                            @foreach($list as $value)
                                                                <div class="form-control">
                                                                    <input type="checkbox"
                                                                           id="{{$value}}"
                                                                           {{-- name="{{$value}}" --}}
                                                                           name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value][]"
                                                                           value="{{$value}}"
                                                                           @if (in_array($value, $values))
                                                                           checked
                                                                        @endif
                                                                        {{--                                                        {{$field->required == 1 ? " required" : ""}}--}}
                                                                    >
                                                                    <label for="">{{$value}}</label>
                                                                </div>
                                                            @endforeach
                                                            @break

                                                            @case("2")
                                                            <input type="text" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]" placeholder="Sua resposta">
                                                            @break

                                                            @case(3)
                                                            @foreach($list as $value)
                                                                <div class="form-control">
                                                                    <input type="radio"
                                                                           id="{{$value}}"
                                                                           {{-- name="{{$field->name}}" --}}
                                                                           name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]"
                                                                           value="{{$value}}"
                                                                           @if (in_array($value, $values))
                                                                           checked
                                                                        @endif
                                                                        {{$field->required == 1 ? " required" : ""}}
                                                                    >
                                                                    <label for="">{{$value}}</label>
                                                                </div>
                                                            @endforeach
                                                            @break

                                                            @case(4)
                                                            <input type="number" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]">
                                                            @break

                                                            @case(5)
                                                            <input type="file" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]">
                                                            @break

                                                            @case(6)
                                                            <select name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]" class="form-control" {{$field->required == 1 ? " required" : ""}}>
                                                                <option value=""></option>
                                                                @foreach($list as $value)
                                                                    <option value="{{$value}}">{{$value}}</option>

                                                                    @if (in_array($value, $values))
                                                                        selected
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @break

                                                            @case(7)
                                                            <input type="file" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]">
                                                            @break
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </div>
                                            @php $f++ @endphp
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php $s++ @endphp
                    @endforeach
                    @php $i++ @endphp

                </div>
            </div>
        </div>
    @endforeach

    {{-- </form> --}}
@endif
