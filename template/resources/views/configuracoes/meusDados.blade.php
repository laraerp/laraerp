@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Seja bem vindo!</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="post" action="{{route('setup.salvar')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <h4>Para começar a utilizar o sistema, informe os dados da sua empresa:</h4>
                            <hr />

                            @include('pessoa.fields', ['params' => old()])

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Insc. estadual:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="inscricao_estadual" value="{{ old('inscricao_estadual') }}" placeholder="Inscrição estadual">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Insc. municipal:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="inscricao_municipal" value="{{ old('inscricao_municipal') }}" placeholder="Inscrição municipal">
                                </div>
                            </div>

                            <h4>Informe o endereço:</h4>
                            <hr />

                            @include('endereco.fields', ['params' => old()])

                            <h4>Dados de contato:</h4>
                            <hr />

                            @include('contato.fields', ['params' => old()])


                            <div class="pull-right">
                                <button type="submit" class="btn btn-success btn-lg">Salvar configurações</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection