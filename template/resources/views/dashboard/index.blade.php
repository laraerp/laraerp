@extends('app')

@section('content')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-7">

                <div class="panel panel-default">
                    <div class="panel-heading">Vendas x Compras</div>
                    <div class="panel-body">
                        <div id="vendasCompras" style="height: 288px;"></div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Receita x Despesa</div>
                    <div class="panel-body">
                        <div id="receitasDespesas" style="height: 288px;"></div>
                    </div>
                </div>

            </div>

            <div class="col-md-5">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Contas à pagar

                        <a href="{{ route('financeiro.contasPagar') }}" class="btn btn-xs btn-primary pull-right">
                            <i class="glyphicon glyphicon-plus"></i> Ver mais
                        </a>
                    </div>
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>Cód</th>
                                    <th>Vencimento</th>
                                    <th>Valor</th>
                                    <th width="100">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($contasPagar as $fatura)
                                    <tr>
                                        <td><a href="#">#{{ $fatura->id }}</a></td>
                                        <td>{{ $fatura->data->format('d/m/Y')}}</td>
                                        <td>{{ Utils::moeda($fatura->valor*-1) }}</td>
                                        <td>
                                            <?php $diff = Carbon\Carbon::now()->diffInDays($fatura->data, false); ?>

                                            @if($diff<0)
                                                <span class="label label-danger">Vencido à {{$diff*-1}} dia(s) </span>
                                            @endif

                                            @if($diff==0)
                                                <span class="label label-warning">Vence hoje</span>
                                            @endif

                                            @if($diff>0)
                                                <span class="label label-primary">Vence daqui {{$diff}} dia(s)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"><i>Nenhuma conta a pagar nos próximos dias</i></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Contas à receber

                        <a href="{{ route('financeiro.contasReceber') }}" class="btn btn-xs btn-primary pull-right">
                            <i class="glyphicon glyphicon-plus"></i> Ver mais
                        </a>
                    </div>
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>Cód</th>
                                    <th>Vencimento</th>
                                    <th>Valor</th>
                                    <th width="100">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($contasReceber as $fatura)
                                    <tr>
                                        <td><a href="#">#{{ $fatura->id }}</a></td>
                                        <td>{{ $fatura->data->format('d/m/Y')}}</td>
                                        <td>{{ Utils::moeda($fatura->valor) }}</td>
                                        <td>
                                            <?php $diff = Carbon\Carbon::now()->diffInDays($fatura->data, false); ?>

                                            @if($diff<0)
                                                <span class="label label-danger">Vencido à {{$diff*-1}} dia(s) </span>
                                            @endif

                                            @if($diff==0)
                                                <span class="label label-warning">Vence hoje</span>
                                            @endif

                                            @if($diff>0)
                                                <span class="label label-primary">Vence daqui {{$diff}} dia(s)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"><i>Nenhuma conta a receber nos próximos dias</i></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>


        </div>
    </div>


    <script>
        $(function(){

            Morris.Area({
                element: 'receitasDespesas',
                data: [
                        @foreach($receitas as $mes => $receita)
                    { mes: '{{ $mes }}', receita: {{ $receita }}, despesa: {{ $despesas[$mes] }} },
                    @endforeach
            ],
                behaveLikeLine: true,
                xkey: 'mes',
                ykeys: ['receita', 'despesa'],
                lineColors: ['#080', '#A00'],
                labels: ['Receitas', 'Despesas'],
                hideHover: 'auto',
                resize: true,

                xLabelFormat: function (x) {
                    return moment(x).format('MMM/YYYY');
                },

                yLabelFormat: function (y) {
                    return 'R$ ' + y.format(2, 3, '.', ',');
                }
            });


            Morris.Area({
                element: 'vendasCompras',
                data: [
                        @foreach($vendas as $mes => $venda)
                    { mes: '{{ $mes }}', venda: {{ $venda }}, compra: {{ $compras[$mes] }} },
                    @endforeach
            ],
                behaveLikeLine: true,
                xkey: 'mes',
                ykeys: ['venda', 'compra'],
                lineColors: ['#080', '#A00'],
                labels: ['Vendas', 'Compras'],
                hideHover: 'auto',
                resize: true,

                xLabelFormat: function (x) {
                    return moment(x).format('MMM/YYYY');
                },

                yLabelFormat: function (y) {
                    return 'R$ ' + y.format(2, 3, '.', ',');
                }
            });
        });
    </script>

@endsection