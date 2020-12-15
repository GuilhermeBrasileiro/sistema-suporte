<?php
    session_start();
    if(!isset($_SESSION["userid"])) {
        header("location:".BASE."login");
        exit;
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
                            <?php
                                if($_SESSION['role'] == '1') {
                                    echo "<a class='nav-link' href='usuarios'>
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
                            <li class="breadcrumb-item"><a href="../admin">Painel Administrativo</a></li>
                            <li class="breadcrumb-item active">Chamados</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-headset"></i>
                                Chamados
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nº</th>
                                                <th>Categoria</th>
                                                <th>Aberto por</th>
                                                <th>Data de abertura</th>
                                                <th>Data de fechamento</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Nº</th>
                                                <th>Categoria</th>
                                                <th>Aberto por</th>
                                                <th>Data de abertura</th>
                                                <th>Data de fechamento</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                $pegarchamados = \MySql::conectar()->prepare("SELECT * FROM chamados ORDER BY fechado ASC, id DESC");
                                                $pegarchamados->execute();
                                                $pegarchamados = $pegarchamados->fetchAll();
                                                foreach ($pegarchamados as $key => $value){
                                            ?>
                                            <?php
                                                if($value['fechado'] == true){
                                            ?>
                                                    <tr class="bg-light">
                                            <?php
                                                }else{
                                            ?>
                                                    <tr>
                                            <?php
                                                }
                                            ?>
                                                <td class="text-center align-middle">
                                                    <div class="btn-group" role="group">
                                                    <button type="button" class="btn text-primary" >
                                                        <a href="chamados/abrir?token=<?php echo $value['token']; ?>"><i class="fas fa-comment-dots"></i></a>
                                                    </button>
                                                <?php
                                                    if($value['fechado'] == null){
                                                ?>
                                                    <button type="button" class="btn text-primary" >
                                                        <a href="../scripts/closeticket.php?id=<?php echo $value['id']; ?>&token=<?php echo $value['token']; ?>&email=<?php echo $value['email']; ?>"><i class='fas fa-lock-open'></i></a>
                                                    </button>
                                                    </div>
                                                <?php
                                                    }else{
                                                ?>
                                                    <button type="button" class="btn text-primary" >
                                                        <a href="../scripts/openticket.php?id=<?php echo $value['id']; ?>&token=<?php echo $value['token']; ?>&email=<?php echo $value['email']; ?>"><i class="fas fa-lock"></i></a>
                                                    </button>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                                </td>
                                                <td class="text-center align-middle"><?php echo $value['id']; ?></td>
                                                <td class="text-uppercase align-middle"><?php echo $value['problema']; ?></td>
                                                <td class="align-middle"><?php echo $value['nome']; ?> <?php echo $value['sobrenome']; ?></td>
                                                <?php
                                                    $openDate = $value['aberto'];
                                                    $openDateFormatted = date("d/m/Y H:i:s", strtotime($openDate)-18000);
                                                    if($value['fechado'] == true){
                                                        $closeDate = $value['fechado'];
                                                        $closeDateFormatted = date("d/m/Y H:i:s", strtotime($closeDate)-18000);
                                                    }else{
                                                        $closeDateFormatted = false;
                                                    }
                                                ?>
                                                <td class="text-center align-middle"><?php echo $openDateFormatted; ?></td>
                                                <td class="text-center align-middle"><?php echo $closeDateFormatted; ?></td>
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../<?php echo ROUTE_JS; ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../<?php echo ROUTE_ASSETS; ?>chart-area-demo.js"></script>
        <script src="../<?php echo ROUTE_ASSETS; ?>chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../<?php echo ROUTE_ASSETS; ?>datatables-demo.js"></script>
    </body>
</html>
