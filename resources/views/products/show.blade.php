@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Produto / Exibir #{{$product->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Produto</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('products.destroy', $product->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('product_category.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('products.edit', $product->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('product_category.destroy')
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
                    <h3 class="box-title">Dados do produto</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static" >{{$product->id}}</p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static" >{{$product->name}}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <p class="form-control-static" >{{$product->description}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="value">Valor</label>
                                    <p class="form-control-static" >{{number_format($product->value, 2, ',', '')}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="amount">Quantidade</label>
                                    <p class="form-control-static" >{{$product->amount}}</p>
                                </div>
                            </div>
                            @if((Auth::user()->name) == "Superuser")
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="type">Empreiteira</label>
                                    <p class="form-control-static" >{{$product->contractor->name}}</p>
                                </div>
                            </div>
                            @endif
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <p class="form-control-static" >{{$product->status()}}</p>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Categorias</label>
                                    @if($product->categories->count())
                                        @foreach ($product->categories as $category)
                                        <p class="form-control-static" >{{$category->name}}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
