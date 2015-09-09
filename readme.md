# Laraerp

[![MIT license](https://img.shields.io/dub/l/vibe-d.svg)](http://opensource.org/licenses/MIT)

Laraerp é uma aplicação web escrita sob o [Laravel Framework PHP](http://laravel.com).

# Instalação

Inicie uma aplicação Laraerp no [Heroku](https://www.heroku.com/) ou instale na sua máquina utilizando o [Composer](https://getcomposer.org/):

### Heroku

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy?template=https://github.com/laraerp/laraerp/tree/develop)

### Composer

```shell
$ composer create-project laraerp/laraerp
```

Acesse o diretório `laraerp` e configure as variáveis do banco de dados no arquivo `.env`. Feito isso, execute o comando para criar as tabelas:

```shell
$ php artisan migrate --seed
```

Você pode utilizar o [PHP Built-in web server](http://php.net/manual/en/features.commandline.webserver.php) para executar a aplicação:

```shell
$ php artisan serve
```

Por padrão, a aplicação irá executar na porta 8000

[http://localhost:8000](http://localhost:8000)

# Primeiro acesso

    Usuario: admin@admin.com
    Senha: admin

# License

The MIT License (MIT)

Copyright (c) 2015 Jansen Felipe

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
