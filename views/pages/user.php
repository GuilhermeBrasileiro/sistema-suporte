<?php
    session_start();
    if(!isset($_SESSION["userid"])) {
        header("location: ../login");
        exit;
    }
    if($_SESSION['role'] == '2') {
        header("location: ../admin");
        exit;
    }
?>
<?php
    if(isset($_POST['adicionar'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        if($cargo == null){
            header('location: usuarios');
            die();
        }
        $sql = \MySql::conectar()->prepare('INSERT INTO users VALUES (null,?,?,?,?)');
        $sql->execute(array($usuario,$senha,$nome,$cargo));
        header('location: usuarios');
        die();
    }
    if(isset($_POST['editar'])) {
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        if($cargo == null){
            header('location: usuarios');
            die();
        }
        $sql = \MySql::conectar()->prepare('UPDATE users SET usuario = (?), nome = (?), cargo = (?) WHERE id = (?)');
        $sql->execute(array($usuario,$nome,$cargo,$id));
        if($senha != null){
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $sql = \MySql::conectar()->prepare('UPDATE users SET senha = (?) WHERE id = (?)');
            $sql->execute(array($senha,$id));
        }
        header('location: usuarios');
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
        <link href="../<?php echo ROUTE_CSS; ?>" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed sb-sidenav-toggled">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="../admin"><?php echo TITLE; ?></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../scripts/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="../admin">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Painel Administrativo
                            </a>
                            <a class="nav-link" href="chamados">
                                <div class="sb-nav-link-icon"><i class="fas fa-headset"></i></div>
                                Chamados
                            </a>
                            <a class="nav-link" href="inventario">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Inventário
                            </a>
                            <a class="nav-link" href="usuarios">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Usuários
                            </a>
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
                            <li class="breadcrumb-item"><a href="../admin">Painel Administrativo</a></li>
                            <li class="breadcrumb-item active">Usuários</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="fas fa-users"></i> Usuários
                                </div>
                                <div>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-add-user">
                                        <i class="fas fa-plus text-primary"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordeless table-hover text-nowrap" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="align-middle text-center">ID</th>
                                                <th class="align-middle text-center">Usuário</th>
                                                <th class="align-middle text-center">Nome</th>
                                                <th class="align-middle text-center">Cargo</th>
                                                <th class="align-middle text-center"></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="align-middle text-center">ID</th>
                                                <th class="align-middle text-center">Nome</th>
                                                <th class="align-middle text-center">Usuário</th>
                                                <th class="align-middle text-center">Cargo</th>
                                                <th class="align-middle text-center"></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                $pegarusuarios = \MySql::conectar()->prepare("SELECT * FROM users ORDER BY id ASC");
                                                $pegarusuarios->execute();
                                                $pegarusuarios = $pegarusuarios->fetchAll();
                                                foreach ($pegarusuarios as $key => $value){
                                            ?>
                                            <tr>
                                                <td class="align-middle text-center"><?php echo $value['id']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['usuario']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['nome']; ?></td>
                                                <?php
                                                    if($value['cargo'] == '1'){
                                                        echo "<td class='align-middle text-center'><i class='fas fa-user-tie'></i> Administrador</td>";
                                                    }elseif($value['cargo'] == '2'){
                                                        echo "<td class='align-middle text-center'><i class='fas fa-user'></i> Técnico</td>";
                                                    }
                                                ?>
                                                <td class="align-middle text-center">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn text-primary" data-toggle="modal" data-target="#modal-edit-user" 
                                                                data-id="<?php echo $value['id']; ?>"
                                                                data-nome="<?php echo $value['nome']; ?>"
                                                                data-usuario="<?php echo $value['usuario']; ?>"
                                                                data-cargo="<?php echo $value['cargo']; ?>"
                                                                onclick="$('#id').val($(this).data('id'));
                                                                        $('#nome').val($(this).data('nome'));
                                                                        $('#usuario').val($(this).data('usuario'));
                                                                        $('#cargo').val($(this).data('cargo'));">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn text-primary" ><a href="../scripts/deleteuser.php?id=<?php echo $value['id']; ?>"><i class="far fa-trash-alt"></i></a></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
        <div class="modal fade" id="modal-add-user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Criar usuário</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Usuário" name="usuario" maxlength="64" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Senha" id="passwordAdd" name="senha" maxlength="32" required>
                                    <div class="input-group-append">
                                        <span class="btn btn-light btn-sm input-group-text" onclick="seePasswordAdd()">
                                            <i id="iconPasswordAdd" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Nome" name="nome" maxlength="64" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col">
                                    <select class="custom-select" name="cargo" required>
                                        <option disabled selected>Cargo</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Técnico</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-primary form-control" name="adicionar" value="Criar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit-user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Editar usuário</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Usuário" name="usuario" id="usuario" value="usuario" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Redefinir senha" id="passwordEdit" name="senha" maxlength="32">
                                    <div class="input-group-append">
                                        <span class="btn btn-light btn-sm input-group-text" onclick="seePasswordEdit()">
                                            <i id="iconPasswordEdit" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Nome" name="nome" id="nome" value="nome" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col">
                                    <select class="custom-select" name="cargo" id="cargo" value="cargo" required>
                                        <option disabled selected>Cargo</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Técnico</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <input type="hidden" name="id" value="id" id="id">
                            <input type="submit" class="btn btn-primary form-control" name="editar" value="Salvar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../<?php echo ROUTE_JS; ?>"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../<?php echo ROUTE_ASSETS; ?>datatables-demo.js"></script>
        <script>
            function seePasswordAdd() {
                var x = document.getElementById("passwordAdd");
                if (x.type === "password") {
                    x.type = "text";
                    $('#iconPasswordAdd').removeClass('fas fa-eye');
                    $('#iconPasswordAdd').addClass('fas fa-eye-slash');
                } else {
                    x.type = "password";
                    $('#iconPasswordAdd').removeClass('fas fa-eye-slash');
                    $('#iconPasswordAdd').addClass('fas fa-eye');
                }
            }
            function seePasswordEdit() {
                var x = document.getElementById("passwordEdit");
                if (x.type === "password") {
                    x.type = "text";
                    $('#iconPasswordEdit').removeClass('fas fa-eye');
                    $('#iconPasswordEdit').addClass('fas fa-eye-slash');
                } else {
                    x.type = "password";
                    $('#iconPasswordEdit').removeClass('fas fa-eye-slash');
                    $('#iconPasswordEdit').addClass('fas fa-eye');
                }
            }
        </script>
    </body>
</html>
