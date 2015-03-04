@extends('app')

@section('content')
<form class="form-horizontal" role="form" method="post">



    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <input type="submit" class="btn btn-success" value="Cadastrar" />
                    <input type="reset" class="btn btn-danger" value="Limpar" />
                    <a href="/cliente" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>

        <hr >

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Cadastrar cliente
                    </div>
                    <div class="panel-body">

                        @include('pessoa.formFields')

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

                        <div class="form-group">       
                            <label class="col-sm-2 control-label">Retém ISS:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="retem_issqn" name="retem_issqn" data-size="mini" data-on-text="Sim" data-off-text="Não" {{ Input::old('retem_issqn') ? 'checked' : '' }} />
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
                        Cadastrar endereço
                    </div>
                    <div class="panel-body">
                        @include('endereco.formFields')
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Cadastrar contato
                    </div>
                    <div class="panel-body">
                        @include('contato.formFields')
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
