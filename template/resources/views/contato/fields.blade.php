<div class="form-group">
    <label class="col-sm-2 control-label">Responsável:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="responsavel" name="contato[responsavel]" value="{{ $params['contato']['responsavel'] or '' }}" placeholder="Responsavel" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Email:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="email" name="contato[email]" value="{{ $params['contato']['email'] or '' }}" placeholder="Email" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Telefone:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control telefone" id="telefone" name="contato[telefone]" value="{{ $params['contato']['telefone'] or '' }}" placeholder="Telefone" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Celular:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control telefone" id="celular" name="contato[celular]" value="{{ $params['contato']['celular'] or '' }}" placeholder="Celular" />
    </div>
</div>