@extends('app')

@section('content')
    <style>
        .extrato{
            font-size: 11px;
        }

        .extrato .receita{
            color:#009900;
            text-align: right;
        }

        .extrato .despesa{
            color:#CC0000;
            text-align: right;
        }
    </style>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Entrada/Saída</div>
                    <div class="panel-body">

                        <form method="GET" class="form-inline">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" name="dias" class="form-control" placeholder="Ultimos dia(s)" value="{{Input::get('dias')}}" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">dia(s)</button>
                                    </span>
                                </div>
                            </div>
                        </form>

                        <hr />

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped extrato">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th><span class="pull-right">Valor</span></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>{{ $extrato['saldo_anterior']['data_corte']->format('d/m') }}</td>
                                    <td><strong>SALDO A {{$dias}} DIA(S) ATRÁS</strong></td>
                                    <td style="text-align: right;"><strong>{{ Utils::moeda($extrato['saldo_anterior']['total'], '') }}</strong></td>
                                </tr>

                                @foreach($extrato['ultimos_lancamentos'] as $mesAno => $info)
                                    <tr>
                                        <td colspan="3"><strong>{{ strtoupper($mesAno) }}</strong></td>
                                    </tr>

                                    @foreach($info['faturas'] as $fatura)
                                        <tr>
                                            <td>{{ $fatura->data_pagamento->format('d/m') }}</td>

                                            @if($fatura->valor>=0)
                                                <td>
                                                    {{ $fatura->descricao }}

                                                    @if(!is_null($fatura->notaFiscal))
                                                        VENDA <a href="{{ route('vendas.ver', $fatura->notaFiscal->id) }}">#{{ $fatura->notaFiscal->id }}</a> - {{ strtoupper($fatura->notaFiscal->cliente->pessoa->nome) }}
                                                    @endif
                                                </td>
                                                <td class="receita">{{ Utils::moeda($fatura->valor, '') }}</td>
                                            @else
                                                <td>
                                                    {{ $fatura->descricao }}

                                                    @if(!is_null($fatura->notaFiscal))
                                                        COMPRA <a href="{{ route('compras.ver', $fatura->notaFiscal->id) }}">#{{ $fatura->notaFiscal->id }}</a> - {{ strtoupper($fatura->notaFiscal->fornecedor->pessoa->nome) }}
                                                    @endif
                                                </td>
                                                <td class="despesa">{{ Utils::moeda($fatura->valor, '') }}</td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><strong>SALDO EM {{ strtoupper($fatura->data_pagamento->format('F')) }}</strong></td>
                                        <td style="text-align: right;"><strong>{{ Utils::moeda($info['total'], '') }}</strong></td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td>{{ date('d/m') }}</td>
                                    <td><strong>SALDO HOJE</strong></td>
                                    <td style="text-align: right;"><strong>{{ Utils::moeda($extrato['saldo_anterior']['total'] + $extrato['total'], '') }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Próximos lançamentos</div>
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped extrato">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th><span class="pull-right">Valor</span></th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($extrato['lancamentos_futuros'] as $fatura)
                                    <tr>
                                        <td>{{ $fatura->data->format('d/m') }}</td>

                                        @if($fatura->valor>=0)
                                            <td>
                                                {{ strtoupper(substr($fatura->descricao, 0, 10)) }}

                                                @if(!is_null($fatura->notaFiscal))
                                                    VENDA <a href="{{ route('vendas.ver', $fatura->notaFiscal->id) }}">#{{ $fatura->notaFiscal->id }}</a> - {{ strtoupper($fatura->notaFiscal->cliente->pessoa->nome) }}
                                                @endif
                                            </td>
                                            <td class="receita">{{ Utils::moeda($fatura->valor, '') }}</td>
                                        @else
                                            <td>
                                                {{ $fatura->descricao }}

                                                @if(!is_null($fatura->notaFiscal))
                                                    COMPRA <a href="{{ route('compras.ver', $fatura->notaFiscal->id) }}">#{{ $fatura->notaFiscal->id }}</a> - {{ strtoupper($fatura->notaFiscal->fornecedor->pessoa->nome) }}
                                                @endif
                                            </td>
                                            <td class="despesa">{{ Utils::moeda($fatura->valor, '') }}</td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"><i>Nenhum lançamento futuro encontrado</i></td>
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
@endsection