@extends('app')

@section('content')

<!-- Bootstrap Select-->
<link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.3/css/bootstrap-select.min.css' rel='stylesheet' type='text/css'>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.3/js/bootstrap-select.min.js"></script>
<script src="/js/ajax-bootstrap-select.min.js"></script>


<style>

    @media all and (min-width: 768px) and (max-width: 1280px) {
        td:nth-child(6), th:nth-child(6){
            display: none;
        }
        td:nth-child(7), th:nth-child(7){
            display: none;
        }
        td:nth-child(8), th:nth-child(8){
            display: none;
        }
    }

    .select-picker > .btn{
        padding: 1px 10px 1px 10px !important;
    }

    .bootstrap-select .status {
        background: #f0f0f0;
        clear: both;
        color: #999;
        font-size: 11px;
        font-style: italic;
        font-weight: 500;
        line-height: 1;
        margin-bottom: -5px;
        padding: 10px 20px;
    }

    .bootstrap-select .btn-success, .btn-danger {
        font-size: 11px;
    }

</style>

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
                        <li><a href="{{ route('compras.index') }}">Notas fiscais</a></li>
                        <li class="active"><a href="#">Itens</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active">

                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th><a href="{{ Order::url('id') }}">ID</a></th>
                                        <th width="120"><a href="{{ Order::url('produto.descricao') }}">Produto</a></th>
                                        <th><a href="{{ Order::url('descricao') }}">Descrição</a></th>
                                        <th><a href="{{ Order::url('cfop') }}">CFOP</a></th>
                                        <th><a href="{{ Order::url('ncm') }}">NCM</a></th>
                                        <th><a href="{{ Order::url('quantidade') }}">Qtd.</a></th>
                                        <th><a href="{{ Order::url('unidade') }}">Un.</a></th>
                                        <th><a href="{{ Order::url('valor_unitario') }}">Valor Un.</a></th>
                                        <th><a href="{{ Order::url('valor_total') }}">Total</a></th>
                                        <th><a href="{{ Order::url('notaFiscal.id') }}">Compra</a></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($itens as $item)
                                        <tr>
                                            <td><a href="{{ route('compras.ver', $item->notaFiscal->id) }}">#{{ Utils::highlighting($item->id, Input::get('like')) }}</a></td>
                                            <td>
                                                <select data-style="{{ is_null($item->produto) ? 'btn-danger' : 'btn-success' }}" class="select-picker" title='{{ is_null($item->produto) ? 'Nenhum' : $item->produto->descricao }}' item_id="{{ $item->id }}"></select>
                                            </td>
                                            <td>{{ Utils::highlighting($item->descricao, Input::get('like')) }}</td>
                                            <td>{{ $item->cfop }}</td>
                                            <td>{{ $item->ncm }}</td>
                                            <td>{{ $item->quantidade }}</td>
                                            <td>{{ $item->unidade }}</td>
                                            <td>{{ Utils::moeda($item->valor_unitario) }}</td>
                                            <td>{{ Utils::moeda($item->valor_total) }}</td>
                                            <td><a href="{{ route('compras.ver', $item->notaFiscal->id) }}">#{{ Utils::highlighting($item->notaFiscal->id, Input::get('like')) }}</a></td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">Nenhum item compra encontrado</td>
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

<script>
    $(function(){


        $('.select-picker').selectpicker({liveSearch: true, showIcon: false}).ajaxSelectPicker({
            ajax: {
                url: '{{ route("util.produtos") }}',
                type: 'GET',
                data: {
                    like: '@{{{q}}}'
                }
            },
            locale: {
                emptyTitle: 'Pesquisar produto...'
            },
            preprocessData: function(data){
                var produtos = [];

                for(var i = 0; i < data.length; i++){
                    var curr = data[i];

                    produtos.push({
                        'value': curr.id,
                        'text': curr.descricao
                    });
                }

                if(produtos.length == 0){
                    produtos.push({
                        'value': this.plugin.query,
                        'text': '+ Adicionar "'+this.plugin.query+'"',
                        'data':{
                            'adicionar': true
                        }
                    });
                }

                return produtos;

            },
            preserveSelected: false
        });

        $(".select-picker").change(function(){
            var option = $(this).find("option:selected").first();
            var value = option.val();
            var item_id = $(this).attr('item_id');

            if(option.attr('data-adicionar')){
                option.html(value);
                $(this).attr('title', value);
                $(this).selectpicker('refresh');

                $.post('{{ route("compras.relacionarProdutoItem") }}', {produto_nome: value, nota_fiscal_item_id: item_id});
            }else{
                if(value > 0)
                    $.post('{{ route("compras.relacionarProdutoItem") }}', {produto_id: value, nota_fiscal_item_id: item_id});
            }
        });
    });
</script>
@endsection
