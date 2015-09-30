@extends('app')

@section('content')

    <?php
    //Verificando se possui chave de nota fiscal para inabilitar a edição da compra
    $lock = !is_null($notafiscal->chave_nfe);
    ?>

    <div class="container-fluid">

        @if($lock)
            <div class="alert alert-warning" role="alert">
                <i class="glyphicon glyphicon-alert"></i> Os controles de edição dessa compra estão bloqueados pois existe uma nota fiscal eletrônica relacionada
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <h2>Compra #{{ $notafiscal->id }}</h2>
            </div>
            <div class="col-md-6">
                <div class="pull-right">

                    @if($lock)
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Nota fiscal eletrônica
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a target="_blank" href="{{ route('notafiscal.danfe', $notafiscal->id) }}">Ver DANFE</a></li>
                                <li><a target="_blank" href="{{ route('notafiscal.xml',  $notafiscal->id) }}">Ver XML</a></li>
                            </ul>
                        </div>
                    @endif

                    <a href="{{ route('compras.index') }}" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>

        <hr >

        <div class="row">
            <div class="col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Fornecedor

                        <a href="{{ route('fornecedores.ver', $notafiscal->fornecedor->id) }}" class="btn btn-xs btn-primary pull-right">
                            <i class="glyphicon glyphicon-eye-open"></i> Ver mais
                        </a>
                    </div>
                    <div class="panel-body">

                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nome:</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">{{ $notafiscal->fornecedor->pessoa->nome }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">CNPJ:</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">{{ Utils::mask($notafiscal->fornecedor->pessoa->documento, Mask::DOCUMENTO) }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dados da compra
                    </div>
                    <div class="panel-body">

                        <div class="form-horizontal">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data:</label>
                                <div class="col-sm-10">
                                    @if($lock)
                                        <p class="form-control-static">{{ $notafiscal->data->format('d/m/Y') }}</p>
                                    @else
                                        <input class="form-control datepicker" name="data" value="{{ $notafiscal->data->format('d/m/Y') }}" placeholder="dd/mm/aaaa">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nº NF:</label>
                                <div class="col-sm-10">
                                    @if($lock)
                                        <p class="form-control-static">{{ $notafiscal->numero }}</p>
                                    @else
                                        <input class="form-control" name="datepicker" value="{{ $notafiscal->numero }}" placeholder="Número da nota fiscal">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Observação:</label>
                                <div class="col-sm-10">
                                    @if($lock)
                                        <pre class="form-control-static">{{ $notafiscal->observacao or '-' }}</pre>
                                    @else
                                        <textarea class="form-control" name="observacao" rows="4" placeholder="Se desejar, descreva aqui alguma obervação">{{ $notafiscal->observacao }}</textarea>
                                    @endif
                                </div>
                            </div>

                            @if(!$lock)
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-md-10 col-md-offset-2">
                                        <button type="submit" class="btn btn-success">
                                            Salvar alteração
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Financeiro

                        <a href="#" class="btn btn-xs btn-success pull-right {{ !$lock?:'disabled' }}">
                            <i class="glyphicon glyphicon-plus"></i> Adicionar
                        </a>
                    </div>
                    <div class="panel-body">

                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Valor total:</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">{{ Utils::moeda($notafiscal->valor_total) }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Valor pago:</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">{{ Utils::moeda($notafiscal->valor_pago) }}</p>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Número</th>
                                    <th>Vencimento</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th>Valor pago</th>
                                    <th width="65">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($notafiscal->faturas as $fatura)
                                    <tr>
                                        <td><a href="#">#{{ $fatura->id }}</a></td>
                                        <td>{{ $fatura->numero }}</td>
                                        <td>{{ $fatura->data->format('d/m/Y') }}</td>
                                        <td>{{ $fatura->tipo or '-' }}</td>
                                        <td>{{ Utils::moeda($fatura->valor*-1) }}</td>
                                        <td>{{ Utils::moeda($fatura->valor_pago) }}</td>
                                        <td>
                                            <a href="" class="btn btn-success btn-xs {{ !$lock?:'disabled' }}">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-xs {{ !$lock?:'disabled' }}">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9"><i>Nenhuma fatura adicionada</i></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <h2>Itens da compra</h2>
        <hr />

        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Itens

                        <button type="button" id="adicionarItem" class="btn btn-xs btn-success pull-right {{ !$lock?:'disabled' }}">
                            <i class="glyphicon glyphicon-plus"></i> Adicionar
                        </button>
                    </div>
                    <div class="panel-body">

                        <!-- Modal -->
                        <div class="modal fade" id="modalItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Item de compra <span id="modalItem_span_id"></span></h4>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form-horizontal" role="form" method="post" action="">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" id="modalItem_id" name="id">

                                            <h4>Relacione a um produto cadastrado:</h4>
                                            <br />

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Produto:</label>
                                                <div class="col-sm-10">
                                                    <input type="hidden" id="produto_id" name="produto_id" />
                                                    <input type="text" class="form-control" id="modal_produto" name="produto" placeholder="Pesquisar produto .." />
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">*Código:</label>
                                                <div class="col-sm-10">
                                                    <input {{ !$lock?:'disabled' }} type="text" class="form-control" id="modalItem_codigo" name="codigo" value="{{ Input::old('codigo') }}" placeholder="Código" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">*Descrição:</label>
                                                <div class="col-sm-10">
                                                    <input {{ !$lock?:'disabled' }} type="text" class="form-control" id="modalItem_descricao" name="descricao" value="{{ Input::old('descricao') }}" placeholder="Descrição" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">*CFOP:</label>
                                                <div class="col-sm-10">
                                                    <input {{ !$lock?:'disabled' }} type="text" class="form-control" id="modalItem_cfop" name="cfop" value="{{ Input::old('cfop') }}" placeholder="Código Fiscal de Operação e Prestação" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">*NCM:</label>
                                                <div class="col-sm-10">
                                                    <input {{ !$lock?:'disabled' }} type="text" class="form-control" id="modalItem_ncm" name="ncm" value="{{ Input::old('ncm') }}" placeholder="Nomeclatura Comum do Mercosul" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">*Quantidade:</label>
                                                <div class="col-sm-3">
                                                    <select {{ !$lock?:'disabled' }} class="form-control" id="modalItem_unidade" name="unidade_medida_fator_id"></select>
                                                </div>
                                                <div class="col-sm-7">
                                                    <input {{ !$lock?:'disabled' }} type="text" class="form-control" id="modalItem_quantidade" name="quantidade" value="{{ Input::old('quantidade') }}" placeholder="Quantidade" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">*Valor un:</label>
                                                <div class="col-sm-10">
                                                    <input {{ !$lock?:'disabled' }} type="text" class="form-control" id="modalItem_valor_unitario" name="valor_unitario" value="{{ Input::old('valor_unitario') }}" placeholder="R$" />
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="pull-left" style="font-size: 20px;">Total: R$ <span id="modalItem_valor_total">0,00</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Modal -->

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Descrição</th>
                                    <th>CFOP</th>
                                    <th>NCM</th>
                                    <th>Qtd.</th>
                                    <th>Un.</th>
                                    <th>Valor Un.</th>
                                    <th>Total</th>
                                    <th>Produto</th>
                                    <th width="65">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($notafiscal->itens as $item)
                                    <tr itemscope="{{ json_encode($item) }}">
                                        <td><a href="#" class="editarItemLink">#{{ $item->id }}</a></td>
                                        <td>{{ $item->codigo }}</td>
                                        <td>{{ $item->descricao }}</td>
                                        <td>{{ $item->cfop }}</td>
                                        <td>{{ $item->ncm }}</td>
                                        <td>{{ $item->quantidade }}</td>
                                        <td>{{ $item->unidade }}</td>
                                        <td>{{ Utils::moeda($item->valor_unitario) }}</td>
                                        <td>{{ Utils::moeda($item->valor_total) }}</td>
                                        <td>
                                            @if(is_null($item->produto))
                                                <span class="label label-danger">Não relacionado</span>
                                            @else
                                                <a href="#">#{{ Util::highlighting($item->produto->id, Input::get('like')) }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs editarItem">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </button>
                                            <a href="#" class="btn btn-danger btn-xs {{ !$lock?:'disabled' }}">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11"><i>Nenhum item adicionado</i></td>
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

            $(".editarItem, a.editarItemLink").click(function(){

                var dados = $.parseJSON($(this).parent().parent().attr('itemscope'));

                $("#modalItem_span_id").html('#'+dados.id);
                $("#modalItem_id").val(dados.id);
                $("#modalItem_codigo").val(dados.codigo);
                $("#modalItem_descricao").val(dados.descricao);
                $("#modalItem_cfop").val(dados.cfop);
                $("#modalItem_ncm").val(dados.ncm);
                $("#modalItem_valor_total").html(dados.valor_total);

                $('#modalItem').modal('show');

            });

            @if(!$lock)
            $("#adicionarItem").click(function(){

                        $("#modalItem_span_id").html('');
                        $("#modalItem_id").val('');
                        $("#modalItem_codigo").val('');
                        $("#modalItem_descricao").val('');
                        $("#modalItem_cfop").val('');
                        $("#modalItem_ncm").val('');

                        $('#modalItem').modal('show');

                    });
            @endif

        });
    </script>
@endsection
