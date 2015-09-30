@extends('app')

@section('content')
    <form class="form-horizontal" role="form" method="post" action="{{ route('produtos.salvar') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <h2>Criar novo produto</h2>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <a href="{{ route('produtos.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>

            <hr >

            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Dados do produto
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">*Código:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="codigo" value="{{ Input::old('codigo') }}" placeholder="Código">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">*Descrição:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="descricao" value="{{ Input::old('descricao') }}" placeholder="Descrição">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">*Unidade medida:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="unidade_medida_id">
                                        @foreach($unidadeMedidas as $unidadeMedida)
                                            <option value="{{ $unidadeMedida->id }}" {{ Input::old('unidade_medida_id') == $unidadeMedida->id ? 'selected' : '' }}>{{ $unidadeMedida->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-lg">Salvar produto</button>
            </div>


        </div>
    </form>

@endsection
