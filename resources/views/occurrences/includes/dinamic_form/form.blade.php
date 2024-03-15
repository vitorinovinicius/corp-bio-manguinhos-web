@if($occurrence->status == 2)
    @php
    $forms = [];
    if(!empty($occurrence->json)){
        $json = json_decode($occurrence->json, true);
        $forms = isset($json["forms"]) ? $json["forms"] : [];
    } else {
        $json = $occurrence->occurrence_dynamo_last();
        $forms = isset($json->json["forms"]) ? $json->json["forms"] : [];
    }
    @endphp

        @foreach($forms  as $form)
            @php $form_position = (isset($form["position"]) && !empty($form["position"])) ? $form["position"] : null @endphp

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="box-title">{{$form["name"] }}</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @if($form["sections"] !== '[]')
                                            @foreach($form["sections"] as $section)
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="box-title">{{$section["name"] }}</h3>
                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">

                                                            @if(isset($section["form_fields"]))
                                                                @foreach($section["form_fields"] as $field)
                                                                    <div class="row">

                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label><strong>{{$field["name"] }}</strong></label>
                                                                                <p>{!! $field["description"] !!}</p>
                                                                                @if (($field['type_field'] == 1 || $field['type_field'] == 3 || $field['type_field'] == 6) && isset($field['value']))
                                                                                    @php
                                                                                        if($occurrence->manual_execution == 1 && $field['type_field'] == 1){
                                                                                            $values = $field['value'];
                                                                                        }else{
                                                                                        $values = array_filter(explode(';',$field['value']));
                                                                                        }
                                                                                        $list = array_filter(explode(';',$field['list']));
                                                                                    @endphp

                                                                                    @foreach($list as $value)
                                                                                        @if(in_array($value, $values))
                                                                                            <div class="form-control input-static">
                                                                                                {{$value}}
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @elseif($field['type_field'] == 5 || $field['type_field'] == 7)

                                                                                    @if(isset($field["value"]) && !empty($field["value"]))
                                                                                        <div class="row">
                                                                                            <div class="col-2 text-center">
                                                                                                <img src="{{$field["value"]}}"
                                                                                                    style="display: block; max-width: 100%; height:auto;"
                                                                                                    class="img-responsive cursor-pointer open-modal-img"
                                                                                                    id="image-rotate-{{$field["value"]}}" data-toggle="modal" data-target="#imgModal"
                                                                                                    data-image="{{$field["value"]}}">
                                                                                                <div class="hidden-pdf">
                                                                                                    <a href="{{$field["value"]}}" class="btn btn-link" target="_blank">
                                                                                                        Abrir externamente
                                                                                                        <i class="bx bx-share"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @else
                                                                                    <div class="form-control input-static">
                                                                                        {{ (isset($field["value"])) ? $field["value"] : ""}}
                                                                                    </div>
                                                                                @endif
                                                                            </div>

                                                                        </div>

                                                                        @include('occurrences.includes.dinamic_form.image_dinamic')

                                                                    </div>
                                                                    <hr>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@else




@endif
