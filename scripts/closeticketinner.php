<?php
include('../index.php');
include('../MySql.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$token = $_GET['token'];
$idThis = $_GET['id'];
$email = $_GET['email'];
$date = date('Y-m-d H:i:s');
$sql = \MySql::conectar()->prepare("UPDATE chamados SET fechado = (?) WHERE id = $idThis");
$sql->execute(array($date));
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
            $mail->Subject = "Chamado Nº$idThis encerrado | Suporte Hypnobox";
            $body = "Utilize o link abaixo para acessar o histórico do chamado.<br><br>
                    <a href=".BASE."chamado?token=".$token.">Chamado Nº$idThis</a>";
            $mail->Body = $body;
            $mail->send();
        } catch (Exception $e) {
            echo "Mensagem não pôde ser enviada.<br><br> Mailer Error: {$mail->ErrorInfo}";
        }
header("location: ../admin/chamados/abrir?token=$token");
die();
?>