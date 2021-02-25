<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Vérification d'email</title>
    <link href="{{ asset('styles.css') }}" media="all" rel="stylesheet" type="text/css" />
</head>

<body>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        <h3>Salut, {{ $user->name }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Un compte a récemment été crée sur {{ env("APP_NAME") }} avec cette adresse mail.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Veuillez cliquer le bouton ci-dessous pour confirmer cette adresse mail.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block aligncenter">
                                        <a href={{ env("APP_URL").'register/verify/' . $confirmation_code }} class="btn btn-primary">Confimer</a>
                                    </td>
                                </tr>
                              </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">Follow <a href="#">@LAB2VIEW</a> on Twitter.</td>
                        </tr>
                    </table>
                </div></div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
