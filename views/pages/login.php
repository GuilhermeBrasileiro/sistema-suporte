<?php
require ("scripts/session.php");
$message="";
if(isset($_POST['entrar'])) {
    $usuario = $_POST["inputUsername"];
    $senha = $_POST["inputPassword"];
    $auth_user = \MySql::conectar()->prepare("SELECT * FROM users WHERE usuario = ?");
    $auth_user->execute(array($usuario));
    $auth_user = $auth_user->fetch();
	if(password_verify($senha, $auth_user['senha'])) {
        $_SESSION["userid"] = $auth_user['id'];
        $_SESSION["user"] = $auth_user['usuario'];
        $_SESSION["name"] = $auth_user['nome'];
        $_SESSION["role"] = $auth_user['cargo'];
        header("location: ".BASE."admin");
	} else {
        $message = "Usuário ou senha incorreto!";
	}
}
?>
<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo TITLE; ?></title>
        <link href="<?php echo ROUTE_CSS; ?>" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-light">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Acesso Administrativo</h3></div>
                                    <div class="card-body">
                                        <form name="login-form" method="POST">
                                            <div class="message"><?php if($message!="") { echo "<div class='alert alert-danger text-center' role='alert'>
                                                                                                <strong>$message</strong>
                                                                                                </div>"; } ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Usuário</label>
                                                <input class="form-control py-4" id="inputUsername" name="inputUsername" type="text" placeholder="Digite seu usuário" maxlength="64" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Senha</label>
                                                <div class="input-group">
                                                    <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Digite sua senha" maxlength="32" required/>
                                                    <div class="input-group-append">
                                                        <span class="btn btn-light btn-sm input-group-text" onclick="seePassword()">
                                                            <i id="iconPassword" class="fa fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                                <input type="submit" name="entrar" class="btn btn-primary w-50" value="Entrar">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-dark mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-center small">
                            <div class="text-white"><?php echo COPYRIGHT; ?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo ROUTE_JS; ?>"></script>
        <script>
            function seePassword() {
                var x = document.getElementById("inputPassword");
                if (x.type === "password") {
                    x.type = "text";
                    $('#iconPassword').removeClass('fas fa-eye');
                    $('#iconPassword').addClass('fas fa-eye-slash');
                } else {
                    x.type = "password";
                    $('#iconPassword').removeClass('fas fa-eye-slash');
                    $('#iconPassword').addClass('fas fa-eye');
                }
            }
        </script>
    </body>
</html>