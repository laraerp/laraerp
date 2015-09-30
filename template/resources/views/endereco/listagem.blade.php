<div id="addEndereco" class="panel-collapse collapse {{ isset($params['endereco']) && count($params['endereco'])?'in':'' }}" role="tabpanel">

    <form class="form-horizontal" method="POST" action="{{ route('enderecos.salvar') }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="endereco[pessoa_id]" value="{{ $pessoa->id }}">
        <input type="hidden" id="idEndereco" name="endereco[id]" value="{{ Input::old('endereco.id') }}">

        @include('endereco.fields', ['params' => $params])

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>

    <hr />
</div>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
        <tr>
            <th>Endereço</th>
            <th width="65">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @forelse($pessoa->enderecos as $endereco)
            <tr>
                <td>{{ $endereco->logradouro }}, {{ $endereco->numero }} {{ $endereco->complemento or '' }} {{ $endereco->bairro }} - {{ $endereco->cidade->nome }}/{{ $endereco->cidade->uf }}</td>
                <td>
                    <a class="btn btn-info btn-xs enderecoCarregarDados" itemscope="{{ json_encode($endereco->toArray()) }}">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    <a href="{{ route('enderecos.excluir', $endereco->id) }}" class="btn btn-danger btn-xs">
                        <i class="glyphicon glyphicon-remove"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2">Nenhum endereço encontrado</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<script>
    $(function() {

        $(".enderecoCarregarDados").click(function () {

            var dados = $.parseJSON($(this).attr('itemscope'));

            $("#addEndereco").collapse();

            $("#idEndereco").val(dados.id);
            $('#cep').val(dados.cep);

            $('#logradouro').val(dados.logradouro);
            $('#numero').val(dados.numero);
            $('#complemento').val(dados.complemento);
            $('#bairro').val(dados.bairro);
            $('#cidade_id').attr('default', dados.cidade.id);
            $('#uf').val(dados.cidade.uf);
            $('#uf').trigger('change');
        });

    });
</script>