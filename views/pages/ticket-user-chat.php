<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $token = $_GET['token'];
    $id = $info['id'];
    $email = $info['email'];
    $nome = $info['nome'];
    $openDate = $info['aberto'];
    $openDateFormatted = date("d/m/Y H:i:s", strtotime($openDate)-18000);
    $closeDate = $info['fechado'];
    $closeDateFormatted = date("d/m/Y H:i:s", strtotime($closeDate)-18000);
    if(isset($_POST['acao'])){
        $token = $_POST['token'];
        $id_chamado = $_POST['id_chamado'];
        $date = date("Y-m-d H:i:s");
        $mensagem = $_POST['mensagem'];
        $sql = \MySql::conectar()->prepare("INSERT INTO interacao_chamado VALUES (null,?,?,?,?,?,?)");
        $sql->execute(array($token,$id_chamado,$mensagem,2,$date,1));
        header("location: chamado?token=$token");
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
        <link href="<?php echo ROUTE_CSS; ?>" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="abrir-chamado"><?php echo TITLE; ?></a>
        </nav>
                <main>
                    <div class="container-fluid">
                        <br>
                        <br>
                        <hr>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                <strong>Chamado Nº <?php echo $id ?></strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="card-body ">
                                            <h3 class="card-title">
                                                <i class="far fa-id-badge"></i>
                                                <?php echo $nome; ?> <?php echo $info['sobrenome']; ?>
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
                                                <h3 class="text-center">Chamado concluído</h3>
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
                                    <textarea  class="col-sm-12" disabled style="height: 150px;resize: none;"><?php echo $info['descricao']; ?></textarea>
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
                                                            echo    "<div class='in-message-user rounded bg-dark text-white'>
                                                                        <p class='in-text'>".$value['mensagem']."</p>
                                                                        <p class='in-sender'><i class='fas fa-user-shield'></i> <b>Administrador</b></p>
                                                                        <p class='in-time'>".$sendDateFormatted."</p>
                                                                    </div>
                                                                    <div class='clear'></div>";
                                                        }
                                                        if($value['remetente'] == 2){
                                                            $sendDate = $value['enviado'];
                                                            $sendDateFormatted = date("d/m/Y | H:i:s", strtotime($sendDate)-18000);
                                                            echo    "<div class='out-message-user rounded bg-secondary text-white'>
                                                                        <p class='out-text'>".$value['mensagem']."</p>
                                                                        <p class='out-sender'><i class='fas fa-user'></i> <b>Você</b></p>
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
                                                    $sql = \MySql::conectar()->prepare("SELECT * FROM interacao_chamado WHERE id_chamado = ? ORDER BY id DESC");
                                                    $sql->execute(array($token));
                                                    if($sql->rowCount() == 0){
                                                        echo '<h1 class="text-center"><span class="badge badge-secondary">Espere uma resposta do Administrador</span></h1>';
                                                    }else{
                                                        $info = $sql->fetchAll();
                                                        if($info[0]['remetente'] == 2){
                                                            echo '<h1 class="text-center"><span class="badge badge-secondary">Espere uma resposta do Administrador</span></h1>';
                                                        }else{
                                            ?>
                                                    <form method="POST" class="text-center">
                                                        <textarea class="align-middle" style="resize: none;width: 90%;height: 50px;" name="mensagem" maxlength="1250" id="message"></textarea>
                                                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                                                        <input type="hidden" name="id_chamado" value="<?php echo $id; ?>">
                                                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                                                        <input type="hidden" name="nome" value="<?php echo $nome; ?>">
                                                        <input type="submit" value="Enviar" class="btn btn-primary" name="acao">
                                                    </form>
                                                    <small class="form-text text-muted text-center" id="charCount">1250 caracteres restantes</small>
                                            <?php
                                                        }
                                                    }
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo ROUTE_JS; ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo ROUTE_ASSETS; ?>chart-area-demo.js"></script>
        <script src="<?php echo ROUTE_ASSETS; ?>chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo ROUTE_ASSETS; ?>datatables-demo.js"></script>
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
