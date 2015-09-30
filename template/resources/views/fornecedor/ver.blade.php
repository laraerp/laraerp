@extends('app')

@section('content')

    <div class="container-fluid">

        <form class="form-horizontal" role="form" method="post" action="{{ route('fornecedores.salvar') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $fornecedor->id }}">

            <div class="row">
                <div class="col-md-6">
                    <h2>Fornecedor #{{ $fornecedor->id }}</h2>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <a href="{{ route('fornecedores.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>

            <hr >

            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Dados da pessoa
                        </div>
                        <div class="panel-body">

                            @include('pessoa.fields', ['params' => $fornecedor->pessoa->toArray()])

                            <div id="dadosClienteEmpresa" class="{{ strlen(Utils::unmask($fornecedor->pessoa->documento)) == 11 ? 'hide' : '' }}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Insc. estadual:</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="inscricao_estadual" value="{{ $fornecedor->inscricao_estadual }}" placeholder="Inscrição estadual">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Insc. municipal:</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="inscricao_municipal" value="{{ $fornecedor->inscricao_municipal }}" placeholder="Inscrição municipal">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-md-10 col-md-offset-2">
                                    <button type="submit" class="btn btn-success">
                                        Salvar alterações
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Endereços

                        <a class="collapsed btn btn-xs btn-success pull-right" data-toggle="collapse" href="#addEndereco" aria-expanded="false">
                            <i class="glyphicon glyphicon-plus"></i> Criar novo
                        </a>
                    </div>
                    <div class="panel-body">

                        @include('endereco.listagem', ['params' => Input::old(), 'pessoa' => $fornecedor->pessoa])

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Contatos

                        <a class="collapsed btn btn-xs btn-success pull-right" data-toggle="collapse" href="#addContato" aria-expanded="false">
                            <i class="glyphicon glyphicon-plus"></i> Criar novo
                        </a>
                    </div>
                    <div class="panel-body">

                        @include('contato.listagem', ['params' => Input::old(), 'pessoa' => $fornecedor->pessoa])

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
