<div class="form-group">
    <label class="col-sm-2 control-label">Cep:</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control cep" id="cep" name="cep" value="{{ Input::old('cep') }}" placeholder="CEP" />
            <span class="input-group-btn">
                <button class="btn btn-primary" id="btnConsultarCorreios" type="button">Consultar Correios</button>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Logradouro:</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ Input::old('logradouro') }}" placeholder="Logradouro" />
    </div>
    <div class="col-sm-2">
        <input type="text" class="form-control" id="numero" name="numero" value="{{ Input::old('numero') }}" placeholder="Num." />
    </div>
    <div class="col-sm-2">
        <input type="text" class="form-control" id="complemento" name="complemento" value="{{ Input::old('complemento') }}" placeholder="Compl" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Bairro:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ Input::old('bairro') }}" placeholder="Bairro" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Cidade/UF:</label>
    <div class="col-sm-2">
        <select id="uf" class="form-control">
            <option value="">UF</option>
        </select>
    </div>
    <div class="col-sm-8">
        <select id="fk_cidade" name="fk_cidade" class="form-control" value="{{ Input::old('fk_cidade') }}">
            <option value="">Cidade</option>
        </select>
    </div>
</div>

@section('javascript')
@parent
<script type="text/javascript">
    loadUF($("#uf"), $("#fk_cidade"));
    
    $("#btnConsultarCorreios").consultaCep({
        cep: $("#cep"),
        logradouro: $("#logradouro"),
        bairro: $("#bairro"),
        fk_cidade: $("#fk_cidade"),
        uf: $("#uf")
    });
</script>
@stop