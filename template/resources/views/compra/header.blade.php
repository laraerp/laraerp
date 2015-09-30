<!-- Modal -->
<div class="modal fade" id="modalCriarCompra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Criar nova compra</h4>
            </div>
            <form class="form-horizontal" role="form" method="post" action="{{ route('compras.salvar') }}">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <h4>Selecione um fornecedor cadastrado:</h4>
                    <br />

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Fornecedor:</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="fornecedor_id" name="fornecedor_id" />
                            <input type="text" class="form-control" id="modal_fornecedor" name="fornecedor" placeholder="Pesquisar fornecedor .." />
                        </div>
                    </div>

                    <br />
                    <h4>Ou crie um novo fornecedor</h4>
                    <hr />

                    @include('pessoa.fields')
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Criar nova compra</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal -->

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
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCriarCompra">
                    <i class="glyphicon glyphicon-plus"></i> Criar nova compra
                </button>
            </div>
        </form>
    </div>
</div>

<hr />

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