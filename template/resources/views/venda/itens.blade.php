@extends('app')

@section('content')

    <style>

        .tab-content {
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }

        .nav-tabs {
            margin-bottom: 0;
        }

    </style>

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
                            <i class="glyphicon glyphicon-plus"></i> Criar nova compra
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
                            <li><a href="{{ route('vendas.index') }}">Vendas</a></li>
                            <li class="active"><a href="#">Itens</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active">

                                <div class="alert alert-danger" role="alert">
                                    Existem 156 itens que não tem relação com produto.
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descrição</th>
                                            <th>CFOP</th>
                                            <th>NCM</th>
                                            <th>Qtd.</th>
                                            <th>Un.</th>
                                            <th>Valor Un.</th>
                                            <th>Total</th>
                                            <th>Venda</th>
                                            <th>Produto</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($itens as $item)
                                            <tr>
                                                <td><a href="{{ route('vendas.ver', $item->notaFiscal->id) }}">#{{ Utils::highlighting($item->id, Input::get('like')) }}</a></td>
                                                <td>{{ Utils::highlighting($item->descricao, Input::get('like')) }}</td>
                                                <td>{{ $item->cfop }}</td>
                                                <td>{{ $item->ncm }}</td>
                                                <td>{{ $item->quantidade }}</td>
                                                <td>{{ $item->unidade }}</td>
                                                <td>{{ Utils::moeda($item->valor_unitario) }}</td>
                                                <td>{{ Utils::moeda($item->valor_total) }}</td>
                                                <td><a href="{{ route('vendas.ver', $item->notaFiscal->id) }}">#{{ Utils::highlighting($item->notaFiscal->id, Input::get('like')) }}</a></td>
                                                <td>
                                                    @if(is_null($item->produto))
                                                        <span class="label label-danger">Não relacionado</span>
                                                    @else
                                                        <a href="#">#{{ Utils::highlighting($item->produto->id, Input::get('like')) }}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10">Nenhum item de venda encontrado</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $itens->appends(Input::query())->render() ?>
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
