<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
?>
<?php
    if(isset($_POST['acao'])){
        $firstName = $_POST['firstName']; 
        $lastName = $_POST['lastName']; 
        $email = $_POST['email']; 
        $department = $_POST['department']; 
        $problemType = $_POST['problemType']; 
        $description = $_POST['description'];
        $date = date("Y-m-d H:i:s");
        $token = md5(uniqid());
        if($problemType == null){
            header('location: abrir-chamado');
            die();
        }
        $sql = \MySql::conectar()->prepare('INSERT INTO chamados VALUES (null,?,?,?,?,?,?,?,null,?)');
        $sql->execute(array($firstName,$lastName,$email,$department,$problemType,$description,$date,$token));
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = EMAIL_SMTPSECURE;
            $mail->Username   = EMAIL_USERNAME;
            $mail->Password   = EMAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->setFrom(EMAIL_USERNAME, EMAIL_SENDER);
            $mail->addAddress($email, $firstName);
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->Subject = 'Seu chamado foi aberto | Sistema Suporte';
            $body = "Olá $firstName, seu chamado foi criado com sucesso!<br>
                    Utilize o link abaixo para interagir:<br>
                    <a href=".BASE."chamado?token=".$token.">Acessar chamado!</a>";
            $mail->Body = $body;
            $mail->send();
            header('location: abrir-chamado');
            die();
        } catch (Exception $e) {
            echo "Chamado não pôde ser aberto.<br><br> Mailer Error: {$mail->ErrorInfo}";
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
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <a class="navbar-brand text-white" href="#"><?php echo TITLE; ?></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link text-white" href="abrir-chamado">Suporte <span class="sr-only">(current)</span></a>
                </li>
              </ul>
        </nav>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Abrir chamado</h3></div>
                                    <div class="card-body">
                                        <form id="newTicket" method="POST">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="firstName">Nome</label>
                                                        <input class="form-control py-4" id="firstName" name="firstName" type="text" placeholder="Seu nome..." maxlength="50" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="lastName">Sobrenome</label>
                                                        <input class="form-control py-4" id="lastName" name="lastName" type="text" placeholder="Seu sobrenome..." maxlength="50" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control py-4" id="email" name="email" type="email" aria-describedby="emailHelp" placeholder="Seu email..." maxlength="255" required/>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="department">Departamento</label>
                                                        <input class="form-control py-4" id="department" name="department" type="text" placeholder="Seu departamento..." maxlength="50" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="problemType">Tipo de problema</label>
                                                        <select class="form-control" id="problemType" name="problemType" required>
                                                            <option disabled selected>Selecione o tipo de problema</option>
                                                            <option value="duvida">Dúvida</option>
                                                            <option value="hardware">Máquina</option>
                                                            <option value="software">Programa</option>
                                                            <option value="outros">Outros</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label class="small mb-1" for="description">Descreva o problema</label>
                                                    <textarea class="form-control" id="description" name="description" placeholder="Em que posso ajudar ?" maxlength="2500" required></textarea>
                                                    <small class="form-text text-muted text-right" id="charCount">2500 caracteres restantes</small>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0"><input type="submit" class="btn btn-primary btn-block" name="acao" value="Enviar"></div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login">Acesso administrativo</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <br>
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
            $(document).on("input", "#description", function () {
                var limit = 2500;
                var charCount = $(this).val().length;
                var charLeft = limit - charCount;

                $("#charCount").text(charLeft+" caracteres restantes");
            });
        </script>
    </body>
</html>
