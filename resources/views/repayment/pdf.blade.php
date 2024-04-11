
<!DOCTYPE html>
<html>
<head>
    {{-- <title>Bio-Manguinhos - Ocorrência Nº {{ $occurrence->id }}</title> --}}
    <meta charSet="utf-8"/>
</head>
<body>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors-rtl.min.css')}}">
<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-extended.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/colors.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/components.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/themes/dark-layout.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/themes/semi-dark-layout.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('css/custom-rtl.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/vertical-menu.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style-rtl.css')}}">
<link rel="stylesheet" href="{{ url('/css/admin.css') }}">

<section>
    <div class="col-md-12">
        <img class="img-thumbnail" id="recebe-image" style="width:200px" src="{{$expenses[0]->contractor->logo_cabecalho}}">
    </div>
</section>

<section class="mt-2">
    @if($expenses->count())

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1>Reembolso</h1>
                    <p style="font-size: 20px"><b>Peíodo:</b> {{$dateIn}} à {{$dateFn}}</p>
                </div>
                <div class="col-md-12 pt-2 pb-2" id="resume" style="background: #fafafa">
                    <h3>Valores</h3>
                    <ul>
                        <li>
                            <b>Total:</b> R$ {{number_format((float)($valueTotal), 2, ',', '')}}
                        </li>
                        <li>
                            <b>Pagas:</b> R$ {{number_format((float)($paidOutValueTotal), 2, ',', '')}}
                        </li>
                        <li>
                            <b>Pendentes:</b> R$ {{number_format((float)($pendingValueTotal), 2, ',', '')}}
                        </li>
                        <li>
                            <b>Recusadas:</b> R$ {{number_format((float)($refusedValueTotal), 2, ',', '')}}
                        </li>
                        <li>
                            <b>Inválidas:</b> R$ {{number_format((float)($inactiveValueTotal), 2, ',', '')}}
                        </li>
                    </ul>
                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="row">
                            <h3>Detalhes</h3>

                            {{-- Daddos das dispesas do tipo KM --}}
                            {{-- <div class="col-12">
                                <div class="card" style="border: 1px solid #dfe3e7">
                                    <div class="card-header" style="border-bottom: 1px solid #dfe3e7; padding: 10px">
                                        KM
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div> --}}

                            {{-- Daddos das dispesas do tipo avulso --}}

                            @if(count($aExpenses) > 0)
                                @foreach($aExpenses as $expenses)
                                    <div class="col-12">
                                        <div class="card" style="border: 1px solid #dfe3e7">
                                            <div class="card-header" style="border-bottom: 1px solid #dfe3e7; padding: 10px">
                                                {{$expenses['expenses'][0]->dateFormat()}} - R$ {{number_format((float)($expenses['total']), 2, ',', '')}}
                                            </div>
                                            <div class="card-body">
                                                @if(count($expenses))
                                                @foreach($expenses['expenses'] as $expense)
                                                <div class="">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Operador</th>
                                                                <th>OS</th>
                                                                <th>Despesa</th>
                                                                <th>Valor</th>
                                                                <th>Data</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                                <tr>
                                                                    <td>{{optional($expense->user)->name}}</td>
                                                                    <td>{{optional($expense->occurrence)->id}}</td>
                                                                    <td>{{optional($expense->expenseTypes)->name}}</td>
                                                                    <td>{{number_format((float)$expense->value, 2, ',', '.')}}</td>
                                                                    <td>{{$expense->dateFormat()}}</td>
                                                                    <td>
                                                                        <span
                                                                            class=
                                                                                @if($expense->status == 1)
                                                                                    'text-warning'
                                                                                @elseif($expense->status == 2)
                                                                                    'text-success'
                                                                                @elseif($expense->status == 3)
                                                                                    'text-danger'
                                                                                @else
                                                                                    'text-secondary'
                                                                                @endif
                                                                        >

                                                                            @if($expense->status == 1)
                                                                                Pendente
                                                                            @elseif($expense->status == 2)
                                                                                Pago
                                                                            @elseif($expense->status == 3)
                                                                                Recusado
                                                                            @else
                                                                                Inválida
                                                                            @endif
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" class="text-center">
                                                                        @if($expense->archives->count())
                                                                            @foreach ($expense->archives as $fotos)
                                                                                <img class="img-thumbnail" id="recebe-image" src="{{$fotos->url}}">
                                                                            @endforeach
                                                                        @else
                                                                            Não há comprovante para essa despesa
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
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
    @endif

<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Fechar">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Imagem ampliada</h4>
            </div>
            <div class="modal-body">
                <div><img class="img-thumbnail max-75vh" id="recebe-image"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

</section>
</body>
</html>
