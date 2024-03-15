@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas / Exibir #{{$contractor->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Empresas</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('contractors.destroy', $contractor->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('contractor.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('contractors.edit', $contractor->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('contractor.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do usuário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static" >{{$contractor->id}}</p>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static" >{{$contractor->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">CNPJ</label>
                                    <p class="form-control-static" >{{$contractor->cnpj}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Endereço completo</label>
                                    <p class="form-control-static" >{{$contractor->address}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Coordenadas</label>
                                    <p class="form-control-static" >{{$contractor->lat}}, {{$contractor->lng}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Telefone 1</label>
                                    <p class="form-control-static" >{{$contractor->phone1}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Telefone 2</label>
                                    <p class="form-control-static" >{{$contractor->phone2}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">E-mail</label>
                                    <p class="form-control-static" >{{$contractor->email}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Site</label>
                                    <p class="form-control-static" >{{$contractor->site}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Visível</label>
                                    <p class="form-control-static" >{{$contractor->visibility()}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <p class="form-control-static" >{{$contractor->status()}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="client_limit">Limite de clientes</label>
                                    <p class="form-control-static">{{$contractor->client_limit}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="total_client">Total de clientes</label>
                                    <p class="form-control-static">{{$contractor->clients->count()}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Pendência financeira com Central System</label>
                                    <p class="form-control-static" >{{$contractor->financialPendency()}}</p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cs_checkbox" type="checkbox" id="inlineCheckbox1" name="send_sms" value=1 @if($contractor->send_sms == 1) checked @endif disabled>
                                        <label class="form-check-label" for="inlineCheckbox1">Enviar SMS</label>
                                    </div>
                                    </div>
                                    </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cs_checkbox" type="checkbox" id="inlineCheckbox2" name="send_mail" value=1 @if($contractor->send_mail == 1) checked @endif disabled>
                                        <label class="form-check-label" for="inlineCheckbox2">Enviar e-mail</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-check-label" for="">Enviar copia e-mail</label>
                                    <p class="form-control-static" >{{$contractor->getBbc()}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Icone</label>
                                    <p class="form-control-static" >
                                        <div class="col-md-4"><img style="display: block; max-width: 100%; height:auto;" src="{{$contractor->icon}}" class="cs_contractor_icon_48"></div>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Logo do cabeçalho</label>
                                    <p class="form-control-static" >
                                        <div class="col-md-4"><img style="display: block; max-width: 100%; height:auto;" src="{{$contractor->logo_cabecalho}}"></div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between">
                                <div class="">
                                    <h4>Configurações de e-mail</h4>
                                </div>
                                <a class="btn btn-info ml-1" href="#" id="test-mail">Testar envio de e-mail</a>
                            </div>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Driver</label>
                                    <p class="form-control-static" >{{$contractor->mail_driver}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Host</label>
                                    <p class="form-control-static" >{{$contractor->mail_host}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Porta</label>
                                    <p class="form-control-static" >{{$contractor->mail_port}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Endereço de envio</label>
                                    <p class="form-control-static" >{{$contractor->mail_from_address}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Endereço de envio - Nome</label>
                                    <p class="form-control-static" >{{$contractor->mail_from_name}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Criptografia</label>
                                    <p class="form-control-static" >{{$contractor->mail_encryption}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Usuário/E-mail</label>
                                    <p class="form-control-static" >{{$contractor->mail_username}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Senha</label>
                                    <p class="form-control-static" >{{$contractor->mail_password}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/sweetalert.js"></script>
    <script>
        $("#test-mail").click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Informe o e-mail para teste:',
                inputPlaceholder: 'E-mail',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off',
                    required: 'on',
                },
                showCancelButton: true,
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                inputValidator: (mail) => {
                    if(!mail){
                        return 'O campo E-mail está em branco'
                    }
                },
                preConfirm: (mail) => {
                    return fetch(
                        '{{route("mails.test_envio_email",$contractor->uuid)}}',
                        {
                            method: 'POST',
                            credentials: "same-origin",
                            cache: 'default',
                            body: JSON.stringify({
                                to: mail
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                "Accept": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                                'X-CSRF-Token': '{{ csrf_token() }}'
                            }
                        }
                    )
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Falha na requisição: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: result.value.mensagem
                    })
                }
            })

        });
    </script>
@endsection
