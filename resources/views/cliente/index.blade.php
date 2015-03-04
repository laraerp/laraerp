@extends('app')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <a href="/cliente/create" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i> Criar novo
                </a>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista de clientes
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Documento</th>
                                    <th>Nome</th>
                                    <th>Razão Social</th>
                                    <th width="65">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $cliente)
                                <tr>
                                    <th scope="row">{{ $cliente->id }}</th>
                                    <td>{{ $cliente->pessoa->documento }}</td>
                                    <td>{{ $cliente->pessoa->nome }}</td>
                                    <td>{{ $cliente->pessoa->razao_apelido }}</td>
                                    <td>
                                        <a href="/cliente/view/{{ $cliente->id }}" class="btn btn-info btn-xs">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="/cliente/delete/{{ $cliente->id }}" class="btn btn-danger btn-xs">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $clientes->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
