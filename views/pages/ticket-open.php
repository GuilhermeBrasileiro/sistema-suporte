<?php
    session_start();
    if(!isset($_SESSION["userid"])) {
        header("location:".BASE."login");
        exit;
    }
?>
<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $token = $_GET['token'];
    $openDate = $info['aberto'];
    $openDateFormatted = date("d/m/Y H:i:s", strtotime($openDate)-18000);
    $closeDate = $info['fechado'];
    $closeDateFormatted = date("d/m/Y H:i:s", strtotime($closeDate)-18000);
    if(isset($_POST['acao'])){
        $token = $_POST['token'];
        $id_chamado = $_POST['id_chamado'];
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $date = date("Y-m-d H:i:s");
        $mensagem = $_POST['mensagem'];
        $sql = \MySql::conectar()->prepare("INSERT INTO interacao_chamado VALUES (null,?,?,?,?,?,?)");
        $sql->execute(array($token,$id_chamado,$mensagem,1,$date,1));
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
            $mail->addAddress($email, '');
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->Subject = "Nova mensagem no chamado Nº $id_chamado | Sistema Suporte";
            $body = "Olá $nome, você recebeu uma resposta no seu chamado!<br>
                    Utilize o link abaixo para interagir:<br>
                    <a href=".BASE."chamado?token=".$token.">Acessar chamado!</a>";
            $mail->Body = $body;
            $mail->send();
            header("location: abrir?token=$token");
        } catch (Exception $e) {
            echo "Mensagem não pôde ser enviada.<br><br> Mailer Error: {$mail->ErrorInfo}";
        }
        die();
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
        <link href="../../<?php echo ROUTE_CSS; ?>" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed sb-sidenav-toggled">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="../../admin"><?php echo TITLE; ?></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../../scripts/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav" class="toggled">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="../../admin">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Painel Administrativo
                            </a>
                            <a class="nav-link" href="../chamados">
                                <div class="sb-nav-link-icon"><i class="fas fa-headset"></i></div>
                                Chamados
                            </a>
                            <a class="nav-link" href="../inventario">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Inventário
                            </a>
                            <?php
                                if($_SESSION['role'] == '1') {
                                    echo "<a class='nav-link' href='../usuarios'>
                                            <div class='sb-nav-link-icon'><i class='fas fa-users'></i></div>
                                            Usuários
                                        </a>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logado como:</div>
                        <?php echo $_SESSION["name"]; ?> | <?php echo $_SESSION["user"]; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../admin">Painel Administrativo</a></li>
                            <li class="breadcrumb-item"><a href="../chamados">Chamados</a></li>
                            <li class="breadcrumb-item active">Chamado Nº <?php echo $info['id']; ?></li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-headset"></i>
                                Chamado Nº <?php echo $info['id']; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="card-body ">
                                            <h3 class="card-title">
                                                <i class="far fa-id-badge"></i>
                                                <?php echo $info['nome']; ?> <?php echo $info['sobrenome']; ?>
                                            </h3>
                                            <p class="card-text">
                                                <i class="fas fa-inbox"></i>
                                                <?php echo $info['email']; ?>
                                            <br>
                                                <i class="fas fa-briefcase"></i>
                                                Departamento: <?php echo $info['departamento']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card-body">
                                            <?php
                                                if($info['fechado'] == null){
                                            ?>
                                                    <h3 class="text-center">Chamado em aberto</h3>
                                            <?php
                                                }else{
                                            ?>
                                                    <h3 class="text-center">Chamado concluido</h3>
                                            <?php
                                                }
                                            ?>
                                            <p>
                                                <i class="far fa-calendar-plus"></i>
                                                Data de abertura - <?php echo $openDateFormatted; ?>
                                            <br>
                                                <?php if($info['fechado'] == null){

                                                }else{?>
                                                    <i class="far fa-calendar-check"></i>
                                                    Data de fechamento - <?php echo $closeDateFormatted; ?>
                                                <?php
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <h4 class="col-sm-10 text-uppercase">PROBLEMA RELACIONADO A CATEGORIA: <?php echo $info['problema']; ?></h4>
                                    <h4 class="col-sm-2 text-center">
                                        <?php
                                            if($info['fechado'] == null){
                                        ?>
                                                <a href="../../scripts/closeticketinner.php?id=<?php echo $info['id']; ?>&token=<?php echo $info['token']; ?>&email=<?php echo $info['email']; ?>"><i class='fas fa-lock-open'></i></a>
                                        <?php
                                            }else{
                                        ?>
                                                <a href="../../scripts/openticketinner.php?id=<?php echo $info['id']; ?>&token=<?php echo $info['token']; ?>&email=<?php echo $info['email']; ?>"><i class="fas fa-lock"></i></a>
                                        <?php
                                            }
                                        ?>
                                    </h4>
                                    <textarea  class="col-sm-12" disabled style="height: 150px;resize: none;" maxlength="2500"><?php echo $info['descricao']; ?></textarea>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 bg-light">
                                        <br>
                                        <div class="container" style="overflow-y: auto;max-height: 300px;">
                                            <div class="col-md-auto">
                                                <?php
                                                    $pegarInteracoes = \MySql::conectar()->prepare("SELECT * FROM interacao_chamado WHERE id_chamado = '$token'");
                                                    $pegarInteracoes->execute();
                                                    $pegarInteracoes = $pegarInteracoes->fetchAll();
                                                    foreach ($pegarInteracoes as $key => $value){
                                                        if($value['remetente'] == 1){
                                                            $sendDate = $value['enviado'];
                                                            $sendDateFormatted = date("d/m/Y | H:i:s", strtotime($sendDate)-18000);
                                                            echo    "<div class='in-message rounded bg-dark text-white'>
                                                                        <p class='in-text'>".$value['mensagem']."</p>
                                                                        <p class='in-sender'><i class='fas fa-user-shield'></i> <b>".$_SESSION['name']."</b></p>
                                                                        <p class='in-time'>".$sendDateFormatted."</p>
                                                                    </div>
                                                                    <div class='clear'></div>";
                                                        }
                                                        if($value['remetente'] == 2){
                                                            $sendDate = $value['enviado'];
                                                            $sendDateFormatted = date("d/m/Y | H:i:s", strtotime($sendDate)-18000);
                                                            echo    "<div class='out-message rounded bg-secondary text-white'>
                                                                        <p class='out-text'>".$value['mensagem']."</p>
                                                                        <p class='out-sender'><i class='fas fa-user'></i> <b>".$info['nome']."</b></p>
                                                                        <p class='out-time'>".$sendDateFormatted."</p>
                                                                    </div>
                                                                    <div class='clear'></div>";
                                                        } 
                                                    } 
                                                ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                            <?php
                                                if($info['fechado'] == null){
                                            ?>
                                                    <form method="POST" class="text-center">
                                                        <textarea class="align-middle" style="resize: none;width: 90%;height: 50px;" name="mensagem" maxlength="1250" id="message"></textarea>
                                                        <input type="hidden" name="token" value="<?php echo $info['token']; ?>">
                                                        <input type="hidden" name="id_chamado" value="<?php echo $info['id']; ?>">
                                                        <input type="hidden" name="email" value="<?php echo $info['email']; ?>">
                                                        <input type="hidden" name="nome" value="<?php echo $info['nome']; ?>">
                                                        <input type="submit" value="Enviar" class="btn btn-primary" name="acao">
                                                    </form>
                                                    <small class="form-text text-muted text-center" id="charCount">1250 caracteres restantes</small>
                                            <?php
                                                }else{
                                                    echo '<h1 class="text-center"><span class="badge badge-primary">Chamado Concluído</span></h1>';
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"><?php echo COPYRIGHT; ?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../<?php echo ROUTE_JS; ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../../<?php echo ROUTE_ASSETS; ?>chart-area-demo.js"></script>
        <script src="../../<?php echo ROUTE_ASSETS; ?>chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../../<?php echo ROUTE_ASSETS; ?>datatables-demo.js"></script>
        <script>
            $(document).on("input", "#message", function () {
                var limit = 1250;
                var charCount = $(this).val().length;
                var charLeft = limit - charCount;

                $("#charCount").text(charLeft+" caracteres restantes");
            });
        </script>
    </body>
</html>
