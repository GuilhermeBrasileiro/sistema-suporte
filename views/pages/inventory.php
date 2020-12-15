<?php
    session_start();
    if(!isset($_SESSION["userid"])) {
        header("location: ../login");
        exit;
    }
?>
<?php
    if(isset($_POST['adicionar'])){
        $patrimonio = $_POST["patrimonio"];
        $tipo = $_POST["tipo"];
        $subtipo = $_POST["subtipo"];
        $fabricante = $_POST["fabricante"];
        $modelo = $_POST["modelo"];
        $processador = $_POST["processador"];
        $memoria = $_POST["memoria"];
        $sist_licenciado = $_POST["sistema_licenciado"];
        $sist_instalado = $_POST["sistema_instalado"];
        $licenca_windows = $_POST["licenca_windows"];
        $pacote_office = $_POST["pacote_office"];
        $licenca_office = $_POST["licenca_office"];
        $numero_serie = $_POST["numero_serie"];
        $service_tag = $_POST["service_tag"];
        $imei = $_POST["imei"];
        $data_compra = $_POST["data_compra"];
        $numero_nf = $_POST["nf"];
        $status = $_POST["status"];
        $usuario_responsavel = $_POST["usuario"];
        $observacoes = $_POST["observacoes"];
        $sql = \MySql::conectar()->prepare('INSERT INTO inventario VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $sql->execute(array($patrimonio,$tipo,$subtipo,$fabricante,$modelo,$processador,$memoria,$sist_licenciado,$sist_instalado,$licenca_windows,$pacote_office,$licenca_office,$numero_serie,$service_tag,$imei,$data_compra,$numero_nf,$status,$usuario_responsavel,$observacoes));
        header('location: inventario');
        die();
    }
    if(isset($_POST['editar'])){
        $id = $_POST["id"];
        $patrimonio = $_POST["patrimonio"];
        $tipo = $_POST["tipo"];
        $subtipo = $_POST["subtipo"];
        $fabricante = $_POST["fabricante"];
        $modelo = $_POST["modelo"];
        $processador = $_POST["processador"];
        $memoria = $_POST["memoria"];
        $sist_licenciado = $_POST["sist_licenciado"];
        $sist_instalado = $_POST["sist_instalado"];
        $licenca_windows = $_POST["licenca_windows"];
        $pacote_office = $_POST["pacote_office"];
        $licenca_office = $_POST["licenca_office"];
        $numero_serie = $_POST["numero_serie"];
        $service_tag = $_POST["service_tag"];
        $imei = $_POST["imei"];
        $data_compra = $_POST["data_compra"];
        $numero_nf = $_POST["numero_nf"];
        $status = $_POST["status"];
        $usuario_responsavel = $_POST["usuario_responsavel"];
        $observacoes = $_POST["observacoes"];
        $sql = \MySql::conectar()->prepare('UPDATE inventario SET patrimonio = (?), tipo = (?), subtipo = (?), fabricante = (?), modelo = (?), processador = (?), memoria = (?), sist_licenciado = (?), sist_instalado = (?), licenca_windows = (?), pacote_office = (?), licenca_office = (?), numero_serie = (?), service_tag = (?), imei = (?), data_compra = (?), numero_nf = (?), usuario_responsavel = (?), observacoes = (?) WHERE id = (?)');
        $sql->execute(array($patrimonio,$tipo,$subtipo,$fabricante,$modelo,$processador,$memoria,$sist_licenciado,$sist_instalado,$licenca_windows,$pacote_office,$licenca_office,$numero_serie,$service_tag,$imei,$data_compra,$numero_nf,$usuario_responsavel,$observacoes,$id));
        header('location: inventario');
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
                            <li class="breadcrumb-item active">Inventário</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="fas fa-boxes"></i> Inventário
                                </div>
                                <div>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-add">
                                        <i class="fas fa-plus text-primary"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap table-sm" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Patrimônio</th>
                                                <th>Tipo</th>
                                                <th>Subtipo</th>
                                                <th>Fabricante</th>
                                                <th>Modelo</th>
                                                <th>Processador</th>
                                                <th>Memória</th>
                                                <th>Sist Operacional Lic</th>
                                                <th>Sist Operacional Inst</th>
                                                <th>Licença Windows</th>
                                                <th>Pacote Office</th>
                                                <th>Licença Office</th>
                                                <th>Número de série</th>
                                                <th>Service tag</th>
                                                <th>IMEI</th>
                                                <th>Data da compra</th>
                                                <th>Número da NF</th>
                                                <th>Status</th>
                                                <th>Usuário responsável</th>
                                                <th>Observações</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Patrimônio</th>
                                                <th>Tipo</th>
                                                <th>Subtipo</th>
                                                <th>Fabricante</th>
                                                <th>Modelo</th>
                                                <th>Processador</th>
                                                <th>Memória</th>
                                                <th>Sist Operacional Lic</th>
                                                <th>Sist Operacional Inst</th>
                                                <th>Licença Windows</th>
                                                <th>Pacote Office</th>
                                                <th>Licença Office</th>
                                                <th>Número de série</th>
                                                <th>Service tag</th>
                                                <th>IMEI</th>
                                                <th>Data da compra</th>
                                                <th>Número da NF</th>
                                                <th>Status</th>
                                                <th>Usuário responsável</th>
                                                <th>Observações</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                $pegarinventario = \MySql::conectar()->prepare("SELECT * FROM inventario ORDER BY id ASC");
                                                $pegarinventario->execute();
                                                $pegarinventario = $pegarinventario->fetchAll();
                                                foreach ($pegarinventario as $key => $value){
                                            ?>
                                            <tr>
                                                <div class="btn-group" role="group">
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn text-primary edit_button" data-toggle="modal" data-target="#modal-edit" 
                                                                data-id="<?php echo $value['id']; ?>"
                                                                data-patrimonio="<?php echo $value['patrimonio']; ?>"
                                                                data-tipo="<?php echo $value['tipo']; ?>"
                                                                data-subtipo="<?php echo $value['subtipo']; ?>"
                                                                data-fabricante="<?php echo $value['fabricante']; ?>"
                                                                data-modelo="<?php echo $value['modelo']; ?>"
                                                                data-processador="<?php echo $value['processador']; ?>"
                                                                data-memoria="<?php echo $value['memoria']; ?>"
                                                                data-sist_licenciado="<?php echo $value['sist_licenciado']; ?>"
                                                                data-sist_instalado="<?php echo $value['sist_instalado']; ?>"
                                                                data-licenca_windows="<?php echo $value['licenca_windows']; ?>"
                                                                data-pacote_office="<?php echo $value['pacote_office']; ?>"
                                                                data-licenca_office="<?php echo $value['licenca_office']; ?>"
                                                                data-numero_serie="<?php echo $value['numero_serie']; ?>"
                                                                data-service_tag="<?php echo $value['service_tag']; ?>"
                                                                data-imei="<?php echo $value['imei']; ?>"
                                                                data-data_compra="<?php echo $value['data_compra']; ?>"
                                                                data-numero_nf="<?php echo $value['numero_nf']; ?>"
                                                                data-status="<?php echo $value['status']; ?>"
                                                                data-usuario_responsavel="<?php echo $value['usuario_responsavel']; ?>"
                                                                data-observacoes="<?php echo $value['observacoes']; ?>"
                                                                onclick="$('#patrimonio').val($(this).data('patrimonio'));
                                                                        $('#tipo').val($(this).data('tipo'));
                                                                        $('#subtipo').val($(this).data('subtipo'));
                                                                        $('#fabricante').val($(this).data('fabricante'));
                                                                        $('#modelo').val($(this).data('modelo'));
                                                                        $('#processador').val($(this).data('processador'));
                                                                        $('#memoria').val($(this).data('memoria'));
                                                                        $('#sist_licenciado').val($(this).data('sist_licenciado'));
                                                                        $('#sist_instalado').val($(this).data('sist_instalado'));
                                                                        $('#licenca_windows').val($(this).data('licenca_windows'));
                                                                        $('#pacote_office').val($(this).data('pacote_office'));
                                                                        $('#licenca_office').val($(this).data('licenca_office'));
                                                                        $('#numero_serie').val($(this).data('numero_serie'));
                                                                        $('#service_tag').val($(this).data('service_tag'));
                                                                        $('#imei').val($(this).data('imei'));
                                                                        $('#data_compra').val($(this).data('data_compra'));
                                                                        $('#numero_nf').val($(this).data('numero_nf'));
                                                                        $('#status').val($(this).data('status'));
                                                                        $('#usuario_responsavel').val($(this).data('usuario_responsavel'));
                                                                        $('#observacoes').val($(this).data('observacoes'));
                                                                        $('#id').val($(this).data('id'));">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn text-primary" ><a href="../scripts/deleteinventory.php?id=<?php echo $value['id']; ?>"><i class="far fa-trash-alt"></i></a></button>
                                                    </td>
                                                </div>
                                                <td class="align-middle text-center"><?php echo $value['patrimonio']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['tipo']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['subtipo']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['fabricante']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['modelo']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['processador']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['memoria']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['sist_licenciado']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['sist_instalado']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['licenca_windows']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['pacote_office']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['licenca_office']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['numero_serie']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['service_tag']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['imei']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['data_compra']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['numero_nf']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['status']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['usuario_responsavel']; ?></td>
                                                <td class="align-middle text-center"><?php echo $value['observacoes']; ?></td>
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
        <div class="modal fade" id="modal-add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar no inventário</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Patrimônio" name="patrimonio" maxlength="64">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Tipo" name="tipo" maxlength="64">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Subtipo" name="subtipo" maxlength="64">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Fabricante" name="fabricante" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Modelo" name="modelo" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Processador" name="processador" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Memória" name="memoria" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Sist Operacional Lic" name="sistema_licenciado" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Sist Operacional Inst" name="sistema_instalado" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Licença Windows" name="licenca_windows" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Pacote Office" name="pacote_office" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Licença Office" name="licenca_office" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Número de série" name="numero_serie" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Service tag" name="service_tag" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="IMEI" name="imei" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Data da compra" name="data_compra" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Número da NF" name="nf" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Status" name="status" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Usuário responsável" name="usuario" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Observações" style="resize: none;" name="observacoes" value="observacoes" maxlength="256"></textarea>
                                </div>
                            </div>
                            <hr>
                            <input type="hidden" name="id" value="id">
                            <input type="submit" class="btn btn-primary form-control" name="adicionar" value="Adicionar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Editar registro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Patrimônio" id="patrimonio" value="patrimonio" name="patrimonio" maxlength="64">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Tipo" id="tipo" value="tipo" name="tipo" maxlength="64">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Subtipo" id="subtipo" value="subtipo" name="subtipo" maxlength="64">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Fabricante" id="fabricante" value="fabricante" name="fabricante" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Modelo" id="modelo" value="modelo" name="modelo" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Processador" id="processador" value="processador" name="processador" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Memória" id="memoria" value="memoria" name="memoria" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Sist Operacional Lic" id="sist_licenciado" value="sist_licenciado" name="sist_licenciado" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Sist Operacional Inst" id="sist_instalado" value="sist_instalado" name="sist_instalado" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Licença Windows" id="licenca_windows" value="licenca_windows" name="licenca_windows" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Pacote Office" id="pacote_office" value="pacote_office" name="pacote_office" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Licença Office" id="licenca_office" value="licenca_office" name="licenca_office" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Número de série" id="numero_serie" value="numero_serie" name="numero_serie" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Service tag" id="service_tag" value="service_tag" name="service_tag" maxlength="64">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="IMEI" id="imei" value="imei" name="imei" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Data da compra" id="data_compra" value="data_compra" name="data_compra" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Número da NF" id="numero_nf" value="numero_nf" name="numero_nf" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Status" id="status" value="status" name="status" maxlength="64">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Usuário responsável" id="usuario_responsavel" value="usuario_responsavel" name="usuario_responsavel" maxlength="64">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Observações" style="resize: none;" id="observacoes" value="observacoes" name="observacoes" maxlength="256"></textarea>
                                </div>
                            </div>
                            <hr>
                            <input type="hidden" id="id" value="id" name="id">
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
    </body>
</html>
