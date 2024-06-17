@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Formulários</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @is(['superuser','admin'])
        <a class="btn btn-success pull-right" href="{{ route('forms.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Formulários</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($forms->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover" data-order='[[ 0, "desc" ]]' data-page-length='25'>
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th>Ano</th>
                                        <th>Situação</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($forms as $form)
                                        <tr>
                                            <td>{{$form->id}}</td>
                                            <td>{{ $form->descricao}}</td>
                                            <td>{{$form->ano}}</td>
                                            <td>{{$form->status()}}</td>
                                            <td class="text-right">
                                                
                                                @is(['superuser', 'admin'])
                                                    @if($form->status == 0)
                                                        <a href="{{ route('forms.inicia_ajax', $form->uuid) }}" class="btn btn-icon btn-sm btn-success" data-toggle="tooltip" data-placement="left" title="Validar"><i class="bx bx-mail-send"></i></a>
                                                    @endif
                                                        <a href="{{ route('forms.show', $form->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-receipt"></i></a>
                                                @endis                                                
                                                @is(['colaborador', 'gestor'])
                                                    @php
                                                        $userHasAccess = false;
                                                        // Percorre todas as seções do formulário para verificar se o usuário está associado a alguma delas.
                                                        foreach ($form->secoes as $secao) {
                                                            if (isset($secao->usuario) && $secao->usuario->id == auth()->user()->id) {
                                                                $userHasAccess = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    @if($userHasAccess)
                                                        <a href="{{ route('forms.preenchimento', $form->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-receipt"></i></a>
                                                    @else
                                                        <button type="button" class="btn btn-icon btn-sm btn-secondary" data-toggle="tooltip" data-placement="left" title="Exibir" disabled><i class="bx bx-low-vision"></i></button>
                                                    @endif
                                                @endis
                                                    
                                                @is('gestor')
                                                    @php
                                                        $userHasAccess = false;
                                                        // Percorre todas as seções do formulário para verificar se o usuário está associado a alguma delas.
                                                        foreach ($form->secoes as $secao) {
                                                            if (isset($secao->setor) && auth()->user()->setores->contains('id', $secao->setor_id)) {
                                                                $userHasAccess = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    @if($userHasAccess)
                                                        <a href="{{ route('forms.vincula', $form->uuid) }}" class="btn btn-icon btn-sm btn-info" data-toggle="tooltip" data-placement="left" title="Vincular"><i class='bx bxs-user-check'></i></a>
                                                    @else
                                                        <button type="button" class="btn btn-icon btn-sm btn-secondary" data-toggle="tooltip" data-placement="left" title="Exibir" disabled><i class="bx bx-low-vision"></i></button>
                                                    @endif
                                                @endis

                                                @is(['superuser', 'admin'])
                                                    <form action="{{ route('forms.destroy', $form->uuid) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                    </form>
                                                @endis
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {!! $forms->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- DataTables -->
    @section('vendor-scripts')
        <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
    @endsection
    {{-- page scripts --}}
    @section('page-scripts')
        <script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
    @endsection
    <script nonce="{{ csp_nonce() }}">
        $(document).ready(function() {
        //Buttons examples
            $('.table').DataTable({
                lengthChange: false,
                paginate: true,
                info: false,
                
                language: {
                    info: "Mostrando de _START_ a _END_ de um total de _TOTAL_ paginas",
                    paginate: {
                        first: "Primeira",
                        previous: "Anterior",
                        next: "Proxima",
                        last: "Ultima",
                        search: 'Filtro:'
                    },
                },
                bFilter: true
            });
        });
    </script>
    
@if(session('message'))
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@elseif(session('error'))
<script>
    Swal.fire({
        position: "center",
        icon: "error",
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 4000
    });
</script>
@endif
@endsection