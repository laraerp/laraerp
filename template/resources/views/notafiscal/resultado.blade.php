@extends('app')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Importador de Notas fiscais eletrônicas</div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h2>Resultado da importação</h2>
                            </div>
                            <div class="col-md-6">
                                <div class="pull-right">
                                    <a href="{{ route('notafiscal.importar') }}" class="btn btn-primary">Voltar</a>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>Arquivo</th>
                                    <th>Mensagem</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($resultados as $resultado)
                                    <tr class="{{ $resultado['code'] == 0 ? 'success' : 'danger' }}">
                                        <td>{{ $resultado['filename']}}</td>
                                        <td>{{ $resultado['message'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
