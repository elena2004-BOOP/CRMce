<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];

    $stmt = $conn->prepare("SELECT usuario FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result(); 
    $stmt->bind_result($usuario);

    if ($stmt->num_rows > 0 && $stmt->fetch()) {
        $stmt->close();

        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar token
        $stmt2 = $conn->prepare("INSERT INTO recuperaciones (correo, token, expira) VALUES (?, ?, ?)");
        $stmt2->bind_param("sss", $correo, $token, $expira);
        $stmt2->execute();
        $stmt2->close();

        // Enviar correo
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'crm.consultoriacapacitacion@gmail.com';
            $mail->Password = 'puyhbskuznyezgcg'; // Sin espacios
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('crm.consultoriacapacitacion@gmail.com', 'CRM Olivia');
            $mail->addAddress($correo);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperar contraseña - CRM Olivia';
            $mail->Body = "Hola <strong>$usuario</strong>,<br><br>
            Da clic en el siguiente enlace para restablecer tu contraseña:<br><br>
            <a href='http://localhost/crm/restablecer_contrasena.php?token=$token'>Restablecer contraseña</a><br><br>
            Este enlace expirará en 1 hora.";

            $mail->send();
            echo "✅ Correo enviado correctamente. Revisa tu bandeja.";
        } catch (Exception $e) {
            echo "❌ Error al enviar el correo: " . $mail->ErrorInfo;
        }

    } else {
        $stmt->close();
        echo "❌ No se encontró ese correo en la base de datos.";
    }
}
