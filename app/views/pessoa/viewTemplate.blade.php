@extends('template')

@section('content')

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        @yield("page-header")                
    </div>
</div>
<!-- /.row -->

@if (Session::get('erro'))
<div class="alert alert-error alert-danger">{{{ Session::get('erro') }}}</div>
@endif

@if (Session::get('alert'))
<div class="alert alert-error alert-warning">{{{ Session::get('alert') }}}</div>
@endif

<div class="row">
    <div class="col-lg-{{ trim($__env->yieldContent('custom'))?'7':'12' }}">

        <div class="panel panel-default">
            <div class="panel-heading">
                Dados principais:
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" >
                        <tbody> 
                            <tr>         
                                <td width="35%">CPF/CNPJ:</td>
                                <td width="65%">
                                    <a class="editable editable-click editPessoa" href="#" id="documento" data-type="text" data-title="Informe o documento">{{ $pessoa->getDocumento() }}</a>
                                </td>
                            </tr>
                            <tr>         
                                <td>Nome/Fantasia:</td>
                                <td>
                                    <a class="editable editable-click editPessoa" href="#" id="nome" data-type="text" data-title="Informe o nome">{{ $pessoa->nome }}</a>
                                </td>
                            </tr>  
                            <tr>         
                                <td>Razão/Apelido:</td>
                                <td>
                                    <a class="editable editable-click editPessoa" href="#" id="razao_apelido" data-type="text" data-title="Informe a razão social"> {{ $pessoa->razao_apelido }}</a>
                                </td>
                            </tr>  
                            <tr>         
                                <td>Nascimento/Fundação:</td>
                                <td>
                                    <a class="editable editable-click editPessoa" href="#" id="nascimento_fundacao" data-type="date" data-format="dd/mm/yyyy" data-clear="false" data-title="Informe">{{ $pessoa->getNascimentoFundacao() }}</a>
                                </td>
                            </tr>  
                            @yield("mais_dados_principais")  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Endereços:
                <a class="btn btn-success btn-xs pull-right" data-toggle="collapse" data-parent="#accordionEndereco" href="#collapseEnderecoOne">
                    <i class="fa fa-plus-circle"></i> Adicionar endereço
                </a>
            </div>
            <div class="panel-body">

                <div class="panel-group" id="accordionEndereco">
                    <div id="collapseEnderecoOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            {{ Form::open(array('action' => 'Laraerp\Endereco\Controllers\EnderecoController@postSave', 'class' => 'form-horizontal')) }}

                            <input type="hidden" name="fk_pessoa" value="{{ $pessoa->id }}" />
                            <input type="hidden" name="idEndereco" id="idEndereco" value="" />

                            @include('endereco.formFields')

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success">Salvar</button>
                                    <button type="reset" class="btn btn-danger">Limpar</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Principal</th>
                                <th>Endereço</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @forelse($pessoa->enderecos as $endereco)
                            <tr>
                                <td>
                                    <input type="checkbox" class="setEnderecoPrincipal" itemid="{{$endereco->id}}" data-size="mini" data-on-text="Sim" data-off-text="Não" {{ $pessoa->fk_endereco == $endereco->id  ? 'checked' : '' }} />
                                </td>
                                <td>
                                    {{ $endereco->enderecoCompleto() }}
                                </td>
                                <td>
                                    <button itemref='{{$endereco->toJson()}}' class="btn btn-xs btn-primary editEndereco">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="{{ action('Laraerp\Endereco\Controllers\EnderecoController@getDelete', $endereco->id) }}" class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">Nenhum endereço cadastrado</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                Contatos:
                <a class="btn btn-success btn-xs pull-right" data-toggle="collapse" data-parent="#accordionContato" href="#collapseContatoOne">
                    <i class="fa fa-plus-circle"></i> Adicionar contato
                </a>
            </div>
            <div class="panel-body">

                <div class="panel-group" id="accordionContato">
                    <div id="collapseContatoOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            {{ Form::open(array('action' => 'Laraerp\Contato\Controllers\ContatoController@postSave', 'class' => 'form-horizontal')) }}

                            <input type="hidden" name="fk_pessoa" value="{{ $pessoa->id }}" />
                            <input type="hidden" name="idContato" id="idContato" value="" />

                            @include('contato.formFields')

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success">Salvar</button>
                                    <button type="reset" class="btn btn-danger">Limpar</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Principal</th>
                                <th>Responsável</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Celular</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pessoa->contatos as $contato)
                            <tr>
                                <td>
                                    <input type="checkbox" class="setContatoPrincipal" itemid="{{$contato->id}}" data-size="mini" data-on-text="Sim" data-off-text="Não" {{ $pessoa->fk_contato == $contato->id  ? 'checked' : '' }} />
                                </td>
                                <td>
                                    {{ $contato->responsavel }}
                                </td>
                                <td>
                                    {{ $contato->email }}
                                </td>
                                <td>
                                    {{ Utils::mask($contato->telefone, Mask::TELEFONE) }}
                                </td>
                                <td>
                                    {{ Utils::mask($contato->celular, Mask::TELEFONE) }}
                                </td>
                                <td>
                                    <button itemref='{{$contato->toJson()}}' class="btn btn-xs btn-primary editContato">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="{{ action('Laraerp\Contato\Controllers\ContatoController@getDelete', $contato->id) }}" class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Nenhum contato cadastrado</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    @if (trim($__env->yieldContent('custom')))
    <div class="col-lg-5">
        @yield("custom")  
    </div>
    @endif

</div>
@stop

@section('javascript')
<script type="text/javascript">
    $(".editEndereco").click(function(){
    var json = jQuery.parseJSON($(this).attr('itemref'));
            $('#idEndereco').val(json.id);
            $('#logradouro').val(json.logradouro);
            $('#numero').val(json.numero);
            $('#complemento').val(json.complemento);
            $('#bairro').val(json.bairro);
            $('#cep').val(json.cep);
            $("#fk_cidade").attr('itemid', '');
            $("#fk_cidade").attr('itemname', json.cidade.nome);
            $("#uf option").each(function () {
    if ($(this).val() === json.cidade.uf) {
    $(this).attr("selected", "true");
            $(this).trigger("change");
    }
    });
            $('#collapseEnderecoOne').collapse('show');
    });
            $(".editContato").click(function(){
    var json = jQuery.parseJSON($(this).attr('itemref'));
            $('#idContato').val(json.id);
            $('#responsavel').val(json.responsavel);
            $('#email').val(json.email);
            $('#telefone').val(json.telefone);
            $('#celular').val(json.celular);
            $('#collapseContatoOne').collapse('show');
    });
            $(".setEnderecoPrincipal").bootstrapSwitch({
    onSwitchChange: function(event, state){
    var param = {pk: {{ $pessoa['id'] }}, name: 'fk_endereco'}

    if (state){
    param['value'] = $(this).attr('itemid');
    }

    $.post('/pessoa/update', param);
    }
    });
            $(".setContatoPrincipal").bootstrapSwitch({
    onSwitchChange: function(event, state){
    var param = {pk: {{ $pessoa['id'] }}, name: 'fk_contato'}

    if (state){
    param['value'] = $(this).attr('itemid');
    }

    $.post('/pessoa/update', param);
    }
    });
            $(".editPessoa").editable({
    pk: {{ $pessoa['id'] }},
            url: '/pessoa/update'
    });
</script>
@stop