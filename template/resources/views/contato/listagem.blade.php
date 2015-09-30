<div id="addContato" class="panel-collapse collapse {{ isset($params['contato']) && count($params['contato'])?'in':'' }}" role="tabpanel">

    <form class="form-horizontal" method="POST" action="{{ route('contatos.salvar') }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="contato[pessoa_id]" value="{{ $pessoa->id }}">
        <input type="hidden" id="idContato" name="contato[id]" value="{{ Input::old('contato.id') }}">

        @include('contato.fields', ['params' => $params])

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>

    <hr />
</div>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
        <tr>
            <th>Responsável</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Celular</th>
            <th width="65">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @forelse($pessoa->contatos as $contato)
            <tr>
                <td>{{ $contato->responsavel }}</td>
                <td>{{ $contato->email }}</td>
                <td>{{ Utils::mask($contato->telefone, Mask::TELEFONE) }}</td>
                <td>{{ Utils::mask($contato->celular, Mask::TELEFONE) }}</td>
                <td>
                    <a class="btn btn-info btn-xs contatoCarregarDados" itemscope="{{ json_encode($contato->toArray()) }}">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    <a href="{{ route('contatos.excluir', $contato->id) }}" class="btn btn-danger btn-xs">
                        <i class="glyphicon glyphicon-remove"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Nenhum contato encontrado</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<script>
    $(function() {

        $(".contatoCarregarDados").click(function(){

            var dados = $.parseJSON( $(this).attr('itemscope') );

            $("#addContato").collapse();

            $("#idContato").val(dados.id);
            $('#responsavel').val(dados.responsavel);
            $('#email').val(dados.email);
            $('#telefone').val(dados.telefone);
            $('#celular').val(dados.celular);
        });

    });
</script>