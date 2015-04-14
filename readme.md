![Logo LaraERP](https://github.com/laraerp/template/blob/master/src/public/images/icon.png "Logo LaraERP")

## LaraERP

LaraERP é uma aplicação web escrita sob o [Laravel Framework PHP](http://laravel.com).

A aplicação conta com diversos cadastros e ferramentas comuns em um [Sistema de Gestão Empresarial](http://pt.wikipedia.org/wiki/Sistema_integrado_de_gest%C3%A3o_empresarial)


### Composer

    $ composer create-project laraerp/laraerp DIRETORIO_SEU_PROJETO

Configure as variáveis de ambiente no arquivo .env

    $ vi .env

Criar tabelas no banco de dados

    $ php artisan migrate --seed

Acesse o diretório criado e inicie a aplicação
    
    $ php artisan serve

Por padrão, a aplicação irá executar na porta 8000
    
    http://localhost:8000

### Primeiro acesso

    Usuario: admin@admin.com
    Senha: admin

## Licença

LaraERP é um software de código aberto licenciado pelo [MIT](http://opensource.org/licenses/MIT)
