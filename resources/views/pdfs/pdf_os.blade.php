<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    <title>Ordem de serviço</title>

    <style type="text/css">
        body {
            background-color: #FFFFFF;
        }

        span {
            font-size: 1rem;
            font-weight: 300;
        }

        .new-page {
            page-break-before: always;
        }

        .header {
            /*margin-top: 20px;*/
            /*margin-bottom: 50px !important;*/
            display: contents;
            height: 125px;
            width: 100%;
            display: block;
        }

        .min-height-120 {
            min-height: 120px !important;
        }

        .header .col-4 {
            height: 100%;
            padding-top: 30px;
        }

        .img-assinatura {
            height: 120px !important;
            max-width: 100%;
        }

        .row {
            width: 100%;
            margin-left: 3px;
            clear: both;
        }

        div {
            min-height: 24px !important;
        }

        .col-12 {
            position: relative;
            width: 100%;
            min-height: 100%;
        }

        .col-6 {
            position: relative;
            float: left;
            width: 50%;
            min-height: 100%;
        }

        .col-4 {
            position: relative;
            float: left;
            width: 33.3333% !important;
            min-height: 100%;
        }

        .col-3 {
            position: relative;
            float: left;
            width: 25%;
            min-height: 100%;
        }

        .col-2 {
            position: relative;
            float: left;
            margin-left: 40px;
            width: 16.66%
            min-height: 100%;
        }

        .col-8 {
            position: relative;
            float: left;
            flex: 0 0 66.6666666667%;
            max-width: 66.6666666667%;
            padding-right: 15px;
            padding-left: 15px;
            min-height: 100%;
        }

        .d-flex {
            width: 100%;
            display: inline-block;
        }

        .d-flex-column {
            flex-direction: column;
        }

        .d-flex * {
            flex: 1;

        }

        .d-flex-column * {
            flex: 1;
            text-align: center;
        }

        .justify-content-center {
            text-align: center;
        }

        *
        .content {
            position: relative;
        }

        .title {
            background-color: #e6e6e6;
            border: 1px solid #b6b6b6;
            font-size: 20px;
        }

        .form {
            margin-top: 20px;
        }

        .formTitle {
            background-color: #e6e6e6;
            border: 1px solid #DFE3E7;
            font-size: 20px;
            width: 100%;
            text-align: center;
        }

        .table {
            margin-bottom: 0px;
        }

        .subtitle {
            background-color: #f5f5f5;
            border: 1px solid #b6b6b6;
            font-weight: bold;
        }

        .subtitle2 {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 1.15em;
            width: 100%;
        }

        .subtitle_p {
            font-weight: normal;
            font-size: 1rem;
        }

        .subtitleData {
            border: 1px solid #b6b6b6;
            font-weight: bold;
        }

        .subtitleData2 {
            font-weight: bold;
        }

        .data {
            border: 1px solid #b6b6b6;
            background-color: #ffffff;
        }

        .text-center * {
            text-align: center
        }

        img {
            max-width: 175px;
        }

        .logo {
            max-height: 100%;
            padding: 0px 5px 20px;
        }


    </style>
</head>
<body>
<div class="page">
    <section class="content" style="padding-top: 5px;">
        <div class="row">
            <div class="header">
                @if($occurrence->contractor->logo_cabecalho)
                    <div class="col-4 text-center">
                        <img src="{{$occurrence->contractor->logo_cabecalho}}" class="logo"/>
                    </div>
                @endif
                <div class='col-4 text-center'>
                    <h4>Ordem de Serviço</h4>
                    <p>{{$occurrence->occurrence_type->name}}</p>
                </div>
                <div class='col-4 text-center'>
                    <p>Número da os</p>
                    <p>{{$occurrence->numero_os ? $occurrence->numero_os : $occurrence->id}}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-12 title"><strong>Dados do Cliente</strong></div>
        </div>

        <div class="row">
            <div class="col-12 subtitle">
                Nome compledo do cliente
            </div>
        </div>

        <div class="row">
            <div class="col-12 data">
                {{$occurrence->occurrence_client->name}}
            </div>
        </div>

        <div class="row">
            <div class="col-4 subtitle">
                E-mail
            </div>
            <div class="col-4 subtitle">
                CPF ou CNPJ
            </div>
            <div class="col-4 subtitle">
                Número externo do cliente
            </div>
        </div>

        <div class="row">
            <div class="col-4 data">
                {{optional($occurrence->occurrence_client)->email}}
            </div>
            <div class="col-4 data">
                {{optional($occurrence->occurrence_client)->cpf_cnpj}}
            </div>
            <div class="col-4 data">
                {{optional($occurrence->occurrence_client)->client_number}}
            </div>
        </div>


        <div class="row">
            <div class="col-12 subtitle">
                Telefone
            </div>
        </div>

        <div class="row">
            @forelse($occurrence->occurrence_client->occurrence_client_phones as $phone)
                <div class="col-4 data">
                    {{$phone->phone}}
                </div>
            @empty
                Não há telefone associado
            @endforelse
        </div>
        <div class="row">
            <div class="col-12 subtitle">
                Endereço
            </div>
            <div class="col-12 data">
                {{optional($occurrence->occurrence_client)->address}}
            </div>
        </div>
        <div class="row">
            <div class="col-3 subtitle">
                Número
            </div>
            <div class="col-3 subtitle">
                Bairro
            </div>
            <div class="col-3 subtitle">
                Cidade
            </div>
            <div class="col-3 subtitle">
                Estado
            </div>
        </div>
        <div class="row">
            <div class="col-3 data">
                {{optional($occurrence->occurrence_client)->number}}
            </div>
            <div class="col-3 data">
                {{optional($occurrence->occurrence_client)->district}}
            </div>
            <div class="col-3 data">
                {{optional($occurrence->occurrence_client)->city}}
            </div>
            <div class="col-3 data">
                {{getToUf(optional($occurrence->occurrence_client)->uf)}}
            </div>

        </div>
        @if(optional($occurrence->occurrence_client)->complement)
            <div class="row">
                <div class="col-12 subtitle">
                    Complemento
                </div>
                <div class="col-12 data">
                    {{optional($occurrence->occurrence_client)->complement}}
                </div>
            </div>
        @endif
        @if(optional($occurrence->occurrence_client)->reference)
            <div class="row">
                <div class="col-12 subtitle">
                    Referência
                </div>
                <div class="col-12 data">
                    {{optional($occurrence->occurrence_client)->reference}}
                </div>
            </div>
        @endif
    </section>

    <section class="content">
        <div class="justify-content-center title" style="margin-top:20px">
            <strong>Dados da OS</strong>
        </div>
        <div class="">
            <div class="col-3 subtitle">
                Status da OS
            </div>
            <div class="col-3 subtitle">
                Turno
            </div>
            <div class="col-3 subtitle">
                Prioridade
            </div>
            <div class="col-3 subtitle">
                Conclusão
            </div>
        </div>
        <div class="">
            <div class="col-3 data">
                {{$occurrence->getStatus()}}
            </div>
            <div class="col-3 data">
                {{$occurrence->shift()}}
            </div>
            <div class="col-3 data">
                {{$occurrence->priority()}}
            </div>
            <div class="col-3 data">
                {{status_schedule($occurrence->status_schedule)}}
            </div>
        </div>
        <div class="">
            <div class="col-6 subtitle">
                Técnico
            </div>
            <div class="col-6 subtitle">
                Empreiteira
            </div>
        </div>
        <div class="">
            <div class="col-6 data">
                @if(isset($occurrence->operator))
                    {{$occurrence->operator_id}} - {{$occurrence->operator->name}}
                @else
                    Sem técnico associado
                @endif
            </div>
            <div class="col-6 data">
                {!! optional($occurrence->contractor)->name !!}
            </div>
        </div>
        <div class="">
            <div class="col-6 subtitle">
                Inserido em
            </div>
            <div class="col-6 subtitle">
                Agendado
            </div>
        </div>
        <div class="">
            <div class="col-6 data">
                {{(!empty($occurrence->created_at) > 0 ? date('d/m/Y H:i', strtotime($occurrence->created_at)) : "-")}}
            </div>
            <div class="col-6 data">
                {{$occurrence->dataAgendamentoFormart()}}
            </div>
        </div>
        <div>
            <div class=" subtitle">
                Observação da empresa
            </div>
            <div class=" data">
                {!! $occurrence->obs_empreiteira !!}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center title" style="margin-top:20px">
            <div class="col-12"><strong>Dados da execução OS</strong></div>
        </div>
        <div class="row">
            <div class="col-12 subtitle"><strong> Dado atendimento - Informações</strong></div>
        </div>
        <div class="row">
            <div class="col-6 subtitleData">Tempo de execução</div>
            <div class="col-6 data">
                {{(!empty($occurrence->check_in && !empty($occurrence->check_out))) ? calcula_minutos($occurrence->check_in,$occurrence->check_out) : "-"}}
            </div>
        </div>
        <div class="row">
            <div class="col-6 subtitleData">Observações gerais</div>
            <div class="col-6 data">
                {!! nl2br($occurrence->obs_os) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6 subtitleData">Motivo</div>
            <div class="col-6 data">
                {{optional($occurrence->nao_realizado_status)->name}}
            </div>
        </div>
        <div class="row">
            <div class="col-6 subtitleData">Descrição do motivo</div>
            <div class="col-6 data">
                {{null_or_na($occurrence->motivo_nao_realizacao)}}
            </div>
        </div>
        <div class="row">
            <div class="col-6 subtitleData">Descrição do motivo</div>
            <div class="col-6 data">
                {{null_or_na($occurrence->motivo_nao_realizacao)}}
            </div>
        </div>
        <div class="row">
            <div class="col-6 subtitleData min-height-120">Assinatura do Cliente</div>
            @if($occurrence->assinatura)
                <div class="col-6 data">
                    <img src="{{$occurrence->assinatura}}" class="img-assinatura">
                </div>
            @else
                <div class="col-6 data min-height-120">Sem assinatura registrado</div>
            @endif
        </div>
        @if(optional($occurrence->occurrence_data_client)->cliente_assinatura_tecnico)
            <div class="row">
                <div class="col-6 subtitleData min-height-120">Assinatura do Técnico (Quando houver)</div>
                <div class="col-6 data">
                    <img src="{{ optional($occurrence->occurrence_data_client)->cliente_assinatura_tecnico }}" class="img-assinatura">
                </div>
            </div>
        @endif
    </section>
</div>
<div class="page">
    <section>
        {{-- fORMULÁRIO DINÂMICO --}}
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
                    @if(!$formId || ($formId && $form['id'] == $formId))
                        <div class="new-page"></div>
                        <div class="form">
                            <div class="formTitle"><strong> {{$form["name"] }}</strong></div>
                        </div>
                        @if($form["sections"] !== '[]')
                            @foreach($form["sections"] as $section)
                                <table class="table table-sm table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="2" class="subtitle2">
                                            {{$section["name"] }}
                                            @if(isset($section["description"]) && !empty($section["description"]))
                                                <p class="subtitle_p">{!! $section["description"] !!} </p>@endif
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($section["form_fields"]))
                                        @foreach($section["form_fields"] as $field)
                                            <tr>
                                                <td style="width: 33%">
                                                    <span class="subtitleData2">{{$field["name"] }}</span>
                                                    <p>{!! $field["description"] !!} </p>

                                                </td>
                                                <td style="width: 66%">
                                                    @if($field['type_field'] != 5 && $field['type_field'] != 7)
                                                        @if (($field['type_field'] == 1 || $field['type_field'] == 3 || $field['type_field'] == 6) && isset($field['value']))
                                                            @php
                                                                if($occurrence->manual_execution == 1 && $field['type_field'] == 1){
                                                                    $values = $field['value'];
                                                                }else{
                                                                    $values = array_filter(explode(';',$field['value']));
                                                                }
                                                                    $list = array_filter(explode(';',$field['list']));
                                                            @endphp

                                                            <ul>
                                                                @foreach($list as $value)
                                                                    @if(in_array($value, $values))
                                                                        <li>
                                                                            {{$value}}
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            {{ (isset($field["value"])) ? $field["value"] : ""}}
                                                        @endif
                                                    @endif

                                                    @if($image != 1 && ($field['type_field'] == 5 || $field['type_field'] == 7))
                                                        @if(isset($field["value"]) && !empty($field["value"]))
                                                            <img src="{{$field["value"]}}" style="margin-top: 30px">
                                                            {{$field["name"] }}
                                                        @endif
                                                        @if($occurrence->occurrence_images->where('form_field_id',$field["id"])->where('position',$form_position)->count() > 0)
                                                            @foreach($occurrence->occurrence_images->where('form_field_id',$field['id'])->where('position',$form_position) as $imagems3)
                                                                <div class="col-2">
                                                                    <img src="{{$imagems3->url}}" style="margin-top: 30px">
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>

                                            @if($image != 1 && ($field['type_field'] != 5 && $field['type_field'] != 7))
                                                <tr>
                                                    <td colspan="2">
                                                        @foreach($occurrence->occurrence_images->where('form_field_id',$field['id']) as $imagems3)
                                                            <div class="col-2">
                                                                <img src="{{$imagems3->url}}" style="margin-top: 30px">
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    @endif
                                    </tbody>
                                </table>
                            @endforeach
                        @endif

                    @endif
                @endforeach
        @endif

        {{-- FIM DO FORM DINAMICO --}}
        @if(($image != 1 && $occurrence->occurrence_images->where('form_id',null)->where('form_field_id', null)->count()) ||  $occurrence->model_evaluation)
            <div class="new-page"></div>

            @if($image != 1 && $occurrence->occurrence_images->where('form_id',null)->where('form_field_id', null)->count())
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th class="subtitle2">Imagens finais</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            @if($occurrence->occurrence_images->where('form_id',null)->where('form_field_id', null)->count())
                                @foreach($occurrence->occurrence_images->where('form_id',null)->where('form_field_id', null) as $imagems3)
                                    <div class="col-2 ">
                                        <img src="{{$imagems3->url}}" style="margin-top: 30px">
                                        <br>{{$imagems3->reference}}
                                    </div>
                                @endforeach
                            @else
                                <div class="data">
                                    Não há mais imagens
                                </div>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

            @endif

            @if($occurrence->model_evaluation)
                <div class="row">
                    <div class="col-12 subtitle"><strong> Avaliação do cliente </strong></div>
                </div>
                <div class="row">
                    <div class="col-6 subtitleData">
                        Nota
                    </div>
                    <div class="col-6 data">
                        {{ optional($occurrence->model_evaluation)->rate}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 subtitleData">
                        Comentário
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 data">
                        {!! optional($occurrence->model_evaluation)->comment !!}
                    </div>
                </div>
            @endif
        @endif
    </section>
</div>
</body>
</html>
