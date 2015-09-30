@extends('app')

@section('content')
    <form class="form-horizontal" role="form" method="post" action="{{ route('clientes.salvar') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <h2>Criar novo cliente</h2>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <a href="{{ route('clientes.index') }}" class="btn btn-primary">Voltar</a>
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

                            @include('pessoa.fields', ['params' => old()])

                            <div id="dadosComplementares" class="<?php echo (strlen(Utils::unmask(Input::old('documento'))) == 11) ? 'hide' : '' ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Insc. estadual:</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="inscricao_estadual" value="{{ Input::old('inscricao_estadual') }}" placeholder="Inscrição estadual">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Insc. municipal:</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="inscricao_municipal" value="{{ Input::old('inscricao_municipal') }}" placeholder="Inscrição municipal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Endereço
                        </div>
                        <div class="panel-body">
                            @include('endereco.fields', ['params' => old()])
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Contato
                        </div>
                        <div class="panel-body">
                            @include('contato.fields', ['params' => old()])
                        </div>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-lg">Salvar cliente</button>
            </div>


        </div>
    </form>

@endsection
