@extends('pessoa.createTemplate')

@section('page-header')
<h1 class="page-header">
    Cadastrar cliente
</h1>
@stop

@section('custom')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dados do cliente:
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">Insc. estadual:</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="inscricao_estadual" value="{{ Input::old('inscricao_estadual') }}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Insc. municipal:</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="inscricao_municipal" value="{{ Input::old('inscricao_municipal') }}" placeholder="">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop