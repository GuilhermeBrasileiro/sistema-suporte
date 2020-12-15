<?php
    session_start();
    if(!isset($_SESSION["userid"])) {
        header("location:".BASE."login");
        exit;
    }
?>
<?php
    if(isset($_POST['adicionar'])){
        $usuario = $_POST['usuario'];
        $titulo = $_POST['titulo'];
        $slug = $_POST['slug'];
        $sql = \MySql::conectar()->prepare('INSERT INTO notes VALUES (null,?,?,?)');
        $sql->execute(array($usuario,$titulo,$slug));
        header('location: admin');
        die();
    }
    if(isset($_POST['editar'])){
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $slug = $_POST['slug'];
        $sql = \MySql::conectar()->prepare('UPDATE notes SET titulo = (?), slug = (?) WHERE id = (?)');
        $sql->execute(array($titulo,$slug,$id));
        header('location: admin');
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
            <a class="navbar-brand" href="admin"><?php echo TITLE; ?></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="scripts/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="admin">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Painel Administrativo
                            </a>
                            <a class="nav-link" href="admin/chamados">
                                <div class="sb-nav-link-icon"><i class="fas fa-headset"></i></div>
                                Chamados
                            </a>
                            <a class="nav-link" href="admin/inventario">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Inventário
                            </a>
                            <?php
                                if($_SESSION['role'] == '1') {
                                    echo "<a class='nav-link' href='admin/usuarios'>
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
                            <li class="breadcrumb-item active">Painel Administrativo</li>
                        </ol>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add-note">
                        Nova Anotação <i class="far fa-sticky-note"></i>
                        </button>
                        <div class="clear"></div>
                        <hr>
                        <div class="card-columns">
                        <?php
                            $pegarnotas = \MySql::conectar()->prepare("SELECT * FROM notes WHERE usuario = (?)");
                            $pegarnotas->execute(array($_SESSION['name']));
                            $pegarnotas = $pegarnotas->fetchAll();
                            foreach ($pegarnotas as $key => $value){
                        ?>
                            <div class="card mb-3 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $value['titulo']; ?></h5>
                                    <p class="card-text"><?php echo $value['slug']; ?></p>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modal-edit-note" 
                                            data-titulo="<?php echo $value['titulo']; ?>"
                                            data-slug="<?php echo $value['slug']; ?>"
                                            data-id="<?php echo $value['id']; ?>"
                                             onclick="$('#titulo').val($(this).data('titulo'));
                                                        $('#slug').val($(this).data('slug'));
                                                        $('#id').val($(this).data('id'));">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </div>
                                        <div class="col">
                                            <a href="scripts/deletenote.php?id=<?php echo $value['id']; ?>">
                                                <button class="btn btn-primary w-100">
                                                    <i class="fas fa-times text-light"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
        <div class="modal fade" id="modal-add-note" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-m" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nova anotação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" class="rounded">
                            <div class="form-group">
                                <input type="text" class="form-control rounded" name="titulo" placeholder="Titulo" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control rounded" name="slug" rows="4" maxlength="2000"></textarea>
                            </div>
                            <input type="hidden" name="usuario" value="<?php echo $_SESSION['name']; ?>" maxlength="64" required>
                            <input type="submit" class="btn btn-primary w-100 rounded" value="Adicionar" name="adicionar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit-note" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-m" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Editar anotação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" class="rounded">
                            <div class="form-group">
                                <input type="text" class="form-control rounded" id="titulo" value="titulo" name="titulo" placeholder="Titulo" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control rounded" id="slug" value="slug" name="slug" rows="4" maxlength="2000"></textarea>
                            </div>
                            <input type="hidden" name="id" value="id" id="id">
                            <input type="submit" class="btn btn-primary w-100 rounded" value="Salvar" name="editar">
                        </form>
                    </div>
                </div>
            </div>
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
    </body>
</html>
