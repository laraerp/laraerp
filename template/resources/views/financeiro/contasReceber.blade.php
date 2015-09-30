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
                            <i class="glyphicon glyphicon-plus"></i> Criar nova conta a receber
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
                        Contas a receber
                    </div>
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th><a href="{{ Order::url('id') }}">ID</a></th>
                                    <th><a href="{{ Order::url('data') }}">Vencimento</a></th>
                                    <th><a href="{{ Order::url('notaFiscal.id') }}">Venda</a></th>
                                    <th><a href="{{ Order::url('tipo') }}">Tipo</a></th>
                                    <th><a href="{{ Order::url('numero') }}">Número</a></th>
                                    <th><a href="{{ Order::url('descricao') }}">Descrição</a></th>
                                    <th><a href="{{ Order::url('valor') }}">Valor</a></th>
                                    <th><a href="{{ Order::url('valor_pago') }}">Valor pago</a></th>
                                    <th><a href="{{ Order::url('data_pagamento') }}">Data pagto.</a></th>
                                    <th>Status</th>
                                    <th width="65">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($faturas as $fatura)
                                    <tr>
                                        <td><a href="#">#{{ Utils::highlighting($fatura->id, Input::get('like')) }}</a></td>
                                        <td>{{ $fatura->data->format('d/m/Y') }}</td>
                                        <td>
                                            @if(!is_null($fatura->notaFiscal))
                                                <a href="#">#{{ $fatura->notaFiscal->id }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ is_null($fatura->tipo) ? '-' : Utils::highlighting($fatura->tipo, Input::get('like')) }}</td>
                                        <td>{{ is_null($fatura->numero) ? '-' : Utils::highlighting($fatura->numero, Input::get('like')) }}</td>
                                        <td>{{ is_null($fatura->descricao) ? '-' : Utils::highlighting($fatura->descricao, Input::get('like')) }}</td>
                                        <td>{{ Utils::moeda($fatura->valor) }}</td>
                                        <td>{{ Utils::moeda($fatura->valor_pago) }}</td>
                                        <td>
                                            @if(!is_null($fatura->data_pagamento))
                                                {{ $fatura->data_pagamento->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($fatura->valor_pago <= 0)
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
                                            @else

                                                @if($fatura->valor_pago < $fatura->valor)
                                                    <span class="label label-default">Pago parcialmente</span>
                                                @else
                                                    <span class="label label-success">Pago</span>
                                                @endif

                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-xs">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-xs">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12"><i>Nenhuma conta à receber nos próximos dias</i></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>


                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $faturas->appends(Input::query())->render() ?>
                            </div>
                            <div class="col-md-4">

                                <form method="GET" class="form-inline">
                                    <input type="hidden" name="like" value="{{Input::get('like')}}" />

                                    <div class="form-group pull-right">
                                        <div class="input-group">
                                            <input type="number" name="limit" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" placeholder="Qtd. registros" value="{{Input::get('limit')}}" />
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