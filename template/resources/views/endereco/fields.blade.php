<div class="form-group">
    <label class="col-sm-2 control-label">Cep:</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control cep" id="cep" name="endereco[cep]" value="{{ $params['endereco']['cep'] or '' }}" placeholder="CEP" />
            <span class="input-group-btn">
                <button class="btn btn-primary" id="btnConsultarCorreios" type="button">Consultar</button>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Logradouro:</label>
    <div class="col-sm-10">
        <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-xs-6">
                <input type="text" class="form-control" id="logradouro" name="endereco[logradouro]" value="{{ $params['endereco']['logradouro'] or '' }}" placeholder="Logradouro" />
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" id="numero" name="endereco[numero]" value="{{ $params['endereco']['numero'] or '' }}" placeholder="Num." />
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" id="complemento" name="endereco[complemento]" value="{{ $params['endereco']['complemento'] or '' }}" placeholder="Compl" />
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Bairro:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="bairro" name="endereco[bairro]" value="{{ $params['endereco']['bairro'] or '' }}" placeholder="Bairro" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Cidade:</label>
    <div class="col-sm-10">

        <div class="form-group">
            <div class="col-sm-4">
                <select class="form-control" id="uf" name="endereco[uf]" default="{{ $params['endereco']['uf'] or '' }}"></select>
            </div>
            <div class="col-sm-8">
                <select class="form-control" id="cidade_id" name="endereco[cidade_id]" default="{{ $params['endereco']['cidade_id'] or '' }}"></select>
            </div>
        </div>

    </div>
</div>


<script>
    $(function(){

        $('#uf').ufs({
            onChange: function(uf){
                $('#cidade_id').cidades({uf: uf});
            }
        });

        $('#btnConsultarCorreios').getCep({
            cep: function(){
                return $('#cep').val();
            },
            onBefore: function(){
                $('#btnConsultarCorreios').html('Consultando..');
            },
            onAfter: function(){
                $('#btnConsultarCorreios').html('Consultar');
            },
            onSuccess: function(endereco){
                $('#logradouro').val(decodeEntities(endereco.logradouro));
                $('#numero').val(endereco.numero);
                $('#complemento').val(endereco.complemento);
                $('#bairro').val(decodeEntities(endereco.bairro));
                $('#cidade_id').attr('default', decodeEntities(endereco.cidade));
                $("#uf option").each(function() {
                    if ($(this).val() === endereco.uf) {
                        $(this).attr("selected", "true");
                        $(this).trigger("change");
                    }
                });
            },
            onError: function(message){
                console.log(message);
            }
        });

    });
</script>