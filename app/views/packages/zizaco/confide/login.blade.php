<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>LaraERP</title>

        <!-- Bootstrap Core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">


                    <img src="/img/icon.png" class="center-block">

                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Login {{ getenv('LARAVEL_ENV') }}</h3>
                        </div>
                        <div class="panel-body">                            
                            <form role="form" method="POST" action="{{{ URL::to('/users/login') }}}" accept-charset="UTF-8">
                                <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="email">{{{ Lang::get('confide::confide.username_e_mail') }}}</label>
                                        <input class="form-control" tabindex="1" placeholder="{{{ Lang::get('confide::confide.username_e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">
                                            {{{ Lang::get('confide::confide.password') }}}
                                        </label>
                                        <input class="form-control" tabindex="2" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
                                        <p class="help-block">
                                            <a href="{{{ URL::to('/users/forgot_password') }}}">{{{ Lang::get('confide::confide.login.forgot_password') }}}</a>
                                        </p>
                                    </div>
                                    <div class="checkbox">
                                        <label for="remember">
                                            <input type="hidden" name="remember" value="0">
                                            <input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> {{{ Lang::get('confide::confide.login.remember') }}}
                                        </label>
                                    </div>
                                    @if (Session::get('error'))
                                    <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
                                    @endif

                                    @if (Session::get('notice'))
                                    <div class="alert">{{{ Session::get('notice') }}}</div>
                                    @endif
                                    <div class="form-group">
                                        <button tabindex="3" type="submit" class="btn btn-default">{{{ Lang::get('confide::confide.login.submit') }}}</button>
                                    </div>
                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/js/bootstrap.min.js"></script>


    </body>

</html>



