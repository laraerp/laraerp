@extends('app')

@section('content')
    <form class="form-horizontal" role="form" method="post" action="{{ route('produtos.salvar') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $produto->id }}">
        <input type="hidden" name="unidade_medida_id" value="{{ $produto->unidade_medida_id }}">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <h2>Produto #{{ $produto->id }}</h2>
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
                                    <input class="form-control" name="codigo" value="{{ $produto->codigo }}" placeholder="Código">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">*Descrição:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="descricao" value="{{ $produto->descricao }}" placeholder="Descrição">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Unidade medida:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $produto->unidadeMedida->descricao }}</p>
                                </div>
                            </div>

                            <br />
                            <h4>Outras informações:</h4>
                            <hr />

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Valor unitário:</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="unidade_medida_fator_id">
                                        <option value="">Selecione a unidade</option>
                                        @foreach($unidadeMedidaFatores as $unidadeMedidaFator)
                                            <option value="{{ $unidadeMedidaFator->id }}" {{ Input::old('unidade_medida_fator_id') == $unidadeMedidaFator->id ? 'selected' : '' }}>{{ $unidadeMedidaFator->simbolo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    <input class="form-control money" name="valor_unitario" value="{{ Input::old('valor_unitario') }}" placeholder="Valor">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Código de barras:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="codigo_ean" value="{{ $produto->codigo_ean }}" placeholder="Código de barras (EAN)">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tipo:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="tipo">
                                        <option>-</option>
                                        <option value="ENTRADA" {{ $produto->tipo == 'ENTRADA' ? 'selected' : '' }}>Somente entrada</option>
                                        <option value="SAÍDA" {{ $produto->tipo == 'SAIDA'  ? 'selected' : '' }}>Somente saída</option>
                                    </select>
                                </div>
                            </div>

                            <br />
                            <h4>Fiscal:</h4>
                            <hr />

                            <div class="form-group">
                                <label class="col-sm-3 control-label">CFOP:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="cfop" value="{{ $produto->cfop }}" placeholder="CFOP">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">NCM:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="ncm" value="{{ $produto->ncm }}" placeholder="NCM">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">
                                        Salvar alterações
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </form>

@endsection
