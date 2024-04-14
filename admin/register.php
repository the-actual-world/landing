<?php
include "../include/config.inc.php";

redirect($arrConfig['url_site'] . '/admin/login.php');

if (isset($_COOKIE['id']) && $_COOKIE['id'] != '' || isset($_SESSION['id']) && $_SESSION['id'] != '') {
    redirect($arrConfig['url_site'] . '/admin/index.php');
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registar - The Actual World</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 mb-2">
                                        Criar Conta
                                    </h3>
                                    <div class="d-flex flex-col justify-content-center align-items-center">
                                        <p class="badge bg-danger">
                                            <i class="fa fa-exclamation-circle"></i>
                                            Disponível temporariamente para testes
                                        </p>
                                    </div>
                                </div>
                                <?php
                                if (isset($_GET['error'])) {
                                    echo '
                                        <div class="card-header">
                                            <p style="color: red; margin-bottom: 0;">
                                                ' . $mapaErrors[$_GET['error']] . '
                                            </p>
                                        </div>
                                        ';
                                }
                                ?>
                                <div class="card-body">
                                    <form action="trata/registo.php" method="POST">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName"
                                                        name="inputFirstName" type="text" placeholder="Cristiano" />
                                                    <label for="inputFirstName">Primeiro Nome</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" name="inputLastName"
                                                        type="text" placeholder="Ronaldo" />
                                                    <label for="inputLastName">Último Nome</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="inputEmail" type="email"
                                                placeholder="eu@email.com" />
                                            <label for="inputEmail">Endereço de Email</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" name="inputPassword"
                                                        type="password" placeholder="Palavra-passe super secreta" />
                                                    <label for="inputPassword">Palavra-passe</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm"
                                                        name="inputPasswordConfirm" type="password"
                                                        placeholder="Confirmação da palavra-passe" />
                                                    <label for="inputPasswordConfirm">Confirmação da
                                                        palavra-passe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><input type="submit" class="btn btn-primary btn-block"
                                                    value="Criar conta"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Já tens conta? Entrar</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>