@extends('pessoa.viewTemplate')

@section('page-header')
<h1 class="page-header">
    Cliente
</h1>
@stop

@section('mais_dados_principais')
<tr>         
    <td>Inscrição estadual:</td>
    <td>
        <a class="editable editable-click editCliente" href="#" id="inscricao_estadual" data-type="text"data-title="Informe">{{ $cliente->inscricao_estadual }}</a>
    </td>
</tr>  
<tr>         
    <td>Inscrição municipal:</td>
    <td>
        <a class="editable editable-click editCliente" href="#" id="inscricao_municipal" data-type="text" data-title="Informe">{{ $cliente->inscricao_municipal }}</a>
    </td>
</tr>   
<tr>         
    <td>Retém ISSQN:</td>
    <td>
        <input type="checkbox" id="retem_issqn" name="retem_issqn" data-size="mini" data-on-text="Sim" data-off-text="Não" {{ $cliente->retem_issqn ? 'checked' : '' }} />
    </td>
</tr>  
@stop

@section('javascript')
@parent
<script>
    $("#retem_issqn").bootstrapSwitch({
    onSwitchChange: function(event, state){
    $.post('/cliente/update', {pk: {{ $cliente['id'] }}, name: 'retem_issqn', value: state?1:0});
    }
    });
            $(".editCliente").editable({
    pk: {{ $cliente['id'] }},
            url: '/cliente/update'
    });
</script>
@stop
