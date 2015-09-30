@extends('app')

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <form method="GET" class="form-inline">
                    <input type="hidden" name="limit" value="{{Input::get('limit')}}" />

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="like" class="form-control" placeholder="Pesquisar por..." value="{{Input::get('like')}}" />
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                        </div>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="btn btn-success">
                            <i class="glyphicon glyphicon-plus"></i> Criar nova venda
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Minhas vendas
                    </div>
                    <div class="panel-body">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#">Vendas</a></li>
                            <li><a href="{{ route('vendas.itens') }}">Itens</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active">

                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                        <tr>
                                            <th><a href="{{ Order::url('id') }}">ID</a></th>
                                            <th><a href="{{ Order::url('data') }}">Data</a></th>
                                            <th><a href="{{ Order::url('cliente.pessoa.nome') }}">Cliente</a></th>
                                            <th><a href="{{ Order::url('numero') }}">N&ordm; NF</a></th>
                                            <th><a href="{{ Order::url('valor_total') }}">Valor</a></th>
                                            <th><a href="{{ Order::url('valor_pago') }}">Valor pago</a></th>
                                            <th>Status</th>
                                            <th width="65">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($vendas as $venda)
                                            <tr>
                                                <td><a href="{{ route('vendas.ver', $venda->id) }}">#{{ Utils::highlighting($venda->id, Input::get('like')) }}</a></td>
                                                <td>{{ $venda->data->format('d/m/Y') }}</td>
                                                <td>{{ Utils::highlighting($venda->cliente->pessoa->nome, Input::get('like')) }}</td>
                                                <td>{{ Utils::highlighting($venda->numero, Input::get('like')) }}</td>
                                                <td>{{ Utils::moeda($venda->valor_total) }}</td>
                                                <td>{{ Utils::moeda($venda->valor_pago) }}</td>
                                                <td>
                                                    @if($venda->valor_pago <= 0)
                                                        <span class="label label-danger">Aberto</span>

                                                    @elseif($venda->valor_pago < $venda->valor_total)
                                                        <span class="label label-primary">Pago parcialmente</span>

                                                    @elseif($venda->valor_pago >= $venda->valor_total)
                                                        <span class="label label-success">Pago</span>

                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('vendas.ver', $venda->id) }}" class="btn btn-info btn-xs">
                                                        <i class="glyphicon glyphicon-eye-open"></i>
                                                    </a>
                                                    <a href="{{ route('vendas.excluir', $venda->id) }}" class="btn btn-danger btn-xs">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">Nenhuma venda encontrada</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $vendas->appends(Input::query())->render() ?>
                            </div>
                            <div class="col-md-4">

                                <form method="GET" class="form-inline">
                                    <input type="hidden" name="like" value="{{Input::get('like')}}" />

                                    <div class="form-group pagination pull-right">
                                        <div class="input-group">
                                            <input type="number" name="limit" class="form-control" placeholder="Qtd. registros" value="{{Input::get('limit')}}" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit">Exibir</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
