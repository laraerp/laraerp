@extends('app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <form method="GET" class="form-inline">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="like" class="form-control" placeholder="Pesquisar por..." value="{{ Input::get('like') }}" />
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('produtos.form') }}" class="btn btn-success">
                            <i class="glyphicon glyphicon-plus"></i> Criar novo
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Lista de produtos
                    </div>
                    <div class="panel-body">
                        <form method="POST">

                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th><a href="{{ Order::url('id') }}">ID</a></th>
                                        <th><a href="{{ Order::url('tipo') }}">Tipo</a></th>
                                        <th><a href="{{ Order::url('codigo') }}">Código</a></th>
                                        <th><a href="{{ Order::url('descricao') }}">Descrição</a></th>
                                        <th width="65">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($produtos as $produto)
                                        <tr>
                                            <td>
                                                <a href="{{ route('produtos.ver', $produto->id) }}">#{{ Utils::highlighting($produto->id, Input::get('like')) }}</a>
                                            </td>
                                            <td>
                                                @if(is_null($produto->tipo))
                                                    <span class="label label-default">Entr</span>
                                                @endif
                                            </td>
                                            <td>{{ is_null($produto->codigo)?'-':Utils::highlighting($produto->codigo, Input::get('like')) }}</td>
                                            <td>{{ Utils::highlighting($produto->descricao, Input::get('like')) }}</td>
                                            <td>
                                                <a href="{{ route('produtos.ver', $produto->id) }}" class="btn btn-info btn-xs">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </a>
                                                <a href="{{ route('produtos.excluir', $produto->id) }}" class="btn btn-danger btn-xs">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Nenhum produto encontrado</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </form>

                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $produtos->appends(Input::query())->render() ?>
                            </div>
                            <div class="col-md-4">

                                <form method="GET" class="form-inline">
                                    <input type="hidden" name="like" value="{{Input::get('like')}}" />

                                    <div class="form-group pull-right">
                                        <div class="input-group">
                                            <input type="number" name="limit" class="form-control" placeholder="Qtd. registros" value="{{Input::get('limit')}}" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit">Exibir</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
