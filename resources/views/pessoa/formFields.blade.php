<div class="form-group">
    <label class="col-sm-2 control-label">Tipo:</label>
    <div class="col-sm-10">
        <select name="tipo" class="form-control none tipoPessoa" inputDocumento="documento" labelRazaoApelido="labelRazaoApelido" labelNascimentoFundacao="labelNascimentoFundacao">
            <option value="CNPJ" {{ Input::old('tipo') == 'CNPJ' ? 'selected' : '' }}>Pessoa Jurídica</option>
            <option value="CPF" {{ Input::old('tipo') == 'CPF' ? 'selected' : '' }}>Pessoa Fisica</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Documento:</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control {{ strlen(Input::old('documento')) == 14 ? 'cpf' : 'cnpj' }}" id="documento" name="documento" value="{{ Input::old('documento') }}" placeholder="CPF ou CNPJ" />
            <span class="input-group-btn">
                <button class="btn btn-primary" id="btnConsultarReceita" type="button">Consultar Receita Federal</button>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Nome:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nome" name="nome" value="{{ Input::old('nome') }}" placeholder="Nome ou nome fantasia da empresa" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" id="labelRazaoApelido">{{ Input::old('tipo') == 'CPF' ? 'Apelido:' : 'Razão social:' }}</label>
    <div class="col-sm-10">
        <input class="form-control" id="razao_apelido" name="razao_apelido" value="{{{ Input::old('razao_apelido') }}}" placeholder="Apelido ou razão social da empresa">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" id="labelNascimentoFundacao">{{ Input::old('tipo') == 'CPF' ? 'Nascimento:' : 'Fundação:' }}</label>
    <div class="col-sm-10">
        <input class="form-control" name="nascimento_fundacao" id="nascimento_fundacao" value="{{ Input::old('nascimento_fundacao') }}" placeholder="dd/mm/aaaa">
    </div>
</div>