<?php
include "../include/config.inc.php";

if (isset($_COOKIE['id']) && $_COOKIE['id'] != '' || isset($_SESSION['id']) && $_SESSION['id'] != '') {
    redirect($arrConfig['url_site'] . '/admin/index.php');
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?>">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Entrar - The Actual World</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Entrar</h3>
                                </div>
                                <?php
                                if (isset($_GET['error'])) {
                                    echo '
                                        <div class="card-header">
                                            <p style="color: red; margin-bottom: 0;">
                                                ' . $errorMap[$_GET['error']] . '
                                            </p>
                                        </div>
                                        ';
                                }
                                ?>
                                <div class="card-body">
                                    <form action="trata/login.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="inputEmail" type="email"
                                                placeholder="eu@email.com" />
                                            <label for="inputEmail">Endereço de Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="inputPassword"
                                                type="password" placeholder="Palavra passe super secreta" />
                                            <label for="inputPassword">Palavra-passe</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" name="inputRememberPassword" />
                                            <label class="form-check-label" for="inputRememberPassword">Manter a sessão
                                                iniciada</label>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" class="btn btn-primary" value="Entrar" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.php">Ainda não tens uma conta? Criar conta</a>
                                    </div>
                                </div> -->
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