<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="/"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>  

        <li>
            <a href="#" data-toggle="collapse" data-target="#cadastros"><i class="fa fa-fw fa-users"></i> Cadastros de Pessoas <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="cadastros" class="collapse">
                <li>
                    <a href="/cliente">Clientes</a>
                </li>
                <li>
                    <a href="/fornecedor">Fornecedor</a>
                </li>
                <li>
                    <a href="/funcionario">Funcionários</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" data-toggle="collapse" data-target="#financeiro"><i class="fa fa-fw fa-dollar"></i> Financeiro <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="financeiro" class="collapse">
                <li>
                    <a href="/notaFiscal">Notas fiscais</a>
                </li>
                <li>
                    <a href="/boleto">Boletos</a>
                </li>
                <li>
                    <a href="/sintegra">Sintegra</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" data-toggle="collapse" data-target="#outrosCadastros"><i class="fa fa-fw fa-gear"></i> Outros cadastros <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="outrosCadastros" class="collapse">
                <li>
                    <a href="/produto">Produtos</a>
                </li>
                <li>
                    <a href="/servico">Serviços</a>
                </li>
                <li>
                    <a href="/estoque">Estoque</a>
                </li> 
            </ul>
        </li>

        <li>
            <a href="#" data-toggle="collapse" data-target="#estoque"><i class="fa fa-fw fa-cubes"></i> Estoque<i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="estoque" class="collapse">
                <li>
                    <a href="/estoque/entrada">Entradas</a>
                </li>
                <li>
                    <a href="/estoque/saida">Saídas</a>
                </li>
            </ul>
        </li> 

        <li>
            <a href="/calendario"><i class="fa fa-fw fa-calendar"></i> Calendário</a>
        </li>  
    </ul>
</div>
<!-- /.navbar-collapse -->