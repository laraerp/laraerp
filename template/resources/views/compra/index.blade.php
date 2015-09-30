@extends('app')

@section('content')


<div class="container-fluid">

    @include('compra.header')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Minhas compras
                </div>
                <div class="panel-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#">Notas fiscais</a></li>
                        <li><a href="{{ route('compras.itens') }}">Itens</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active">

                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th><a href="{{ Order::url('id') }}">ID</a></th>
                                        <th><a href="{{ Order::url('data') }}">Data</a></th>
                                        <th><a href="{{ Order::url('fornecedor.pessoa.nome') }}">Fornecedor</a></th>
                                        <th><a href="{{ Order::url('numero') }}">N&ordm; NF</a></th>
                                        <th><a href="{{ Order::url('valor_total') }}">Valor</a></th>
                                        <th><a href="{{ Order::url('valor_pago') }}">Valor pago</a></th>
                                        <th>Status</th>
                                        <th width="65">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($compras as $compra)
                                        <tr>
                                            <td><a href="{{ route('compras.ver', $compra->id) }}">#{{ Utils::highlighting($compra->id, Input::get('like')) }}</a></td>
                                            <td>{{ $compra->data->format('d/m/Y')}}</td>
                                            <td>{{ Utils::highlighting($compra->fornecedor->pessoa->nome, Input::get('like')) }}</td>
                                            <td>{{ Utils::highlighting($compra->numero, Input::get('like')) }}</td>
                                            <td>{{ Utils::moeda($compra->valor_total) }}</td>
                                            <td>{{ Utils::moeda($compra->valor_pago) }}</td>
                                            <td>
                                                @if($compra->valor_pago <= 0)
                                                    <span class="label label-danger">Aberto</span>

                                                @elseif($compra->valor_pago < $compra->valor_total)
                                                    <span class="label label-primary">Pago parcialmente</span>

                                                @elseif($compra->valor_pago >= $compra->valor_total)
                                                    <span class="label label-success">Pago</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('compras.ver', $compra->id) }}" class="btn btn-info btn-xs">
                                                    <i class="glyphicon glyphicon-eye-open"></i>
                                                </a>
                                                <a href="{{ route('compras.excluir', $compra->id) }}" class="btn btn-danger btn-xs">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">Nenhuma compra encontrada</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <?php echo $compras->appends(Input::query())->render() ?>
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


<script>
    $(function(){

        $("#modal_fornecedor").typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 2
                },
                {
                    name: 'fornecedores',
                    display: 'nome',
                    source: new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        prefetch: '/util/fornecedores',
                        remote: {
                            url: '/util/fornecedores?like=%QUERY',
                            wildcard: '%QUERY'
                        }
                    }),
                    updater: function(item) {
                        console.log(item);
                        $('#fornecedor_id').val(map[item].id);
                        return item;
                    }
                }
        ).on('typeahead:selected', function(event, data){
                    $('#fornecedor_id').val(data.id);
                });

    });
</script>


@endsection
