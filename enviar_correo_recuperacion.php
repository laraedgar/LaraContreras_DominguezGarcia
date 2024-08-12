<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Restablecimiento de Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #086A87;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<?php
include 'conexion.php'; // Conexión a la base de datos

$message = ""; // Variable para almacenar mensajes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    
    // Verificar que el correo esté registrado en la base de datos
    $query = "SELECT id, username FROM users WHERE email = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $username);
            $stmt->fetch();
            
            // Generar un token único para la recuperación de contraseña
            $token = bin2hex(random_bytes(50));
            $tokenQuery = "INSERT INTO password_resets (user_id, token) VALUES (?, ?)";
            
            if ($stmtToken = $conn->prepare($tokenQuery)) {
                $stmtToken->bind_param('is', $id, $token);
                $stmtToken->execute();
                $stmtToken->close();
                
                // Enviar el correo electrónico con el enlace de recuperación
                $to = $email;
                $subject = "Recuperación de contraseña";
                $message = "Hola $username,\n\n";
                $message .= "Para restablecer tu contraseña, haz clic en el siguiente enlace:\n";
                $message .= "http://tu-dominio.com/restablecer_password.php?token=$token\n\n";
                $message .= "Si no solicitaste este cambio, ignora este correo.";
                
                $headers = "From: no-reply@tu-dominio.com";
                
                if (mail($to, $subject, $message, $headers)) {
                    $message = "Se ha enviado un correo a tu dirección para restablecer la contraseña.";
                } else {
                    $message = "Hubo un problema al enviar el correo. Inténtalo más tarde.";
                }
            } else {
                $message = "Error al generar el token.";
            }
        } else {
            $message = "No se encontró una cuenta con ese correo electrónico.";
        }
        
        $stmt->close();
    } else {
        $message = "Error en la consulta.";
    }
}

$conn->close();
?>
<body>
    <div class="container">
        <h1>Hola [Grettel],</h1>
        <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta en [Infonavit]. Si no solicitaste este cambio, puedes ignorar este correo. Tu contraseña seguirá siendo la misma y tu cuenta no se verá afectada.</p>
        <p>Para restablecer tu contraseña, por favor, haz clic en el siguiente enlace:</p>
        <p><a href="restablecer_password.php" class="button">Restablecer mi contraseña</a></p>
        <p>Este enlace expirará en 30 minutos por razones de seguridad. Si el enlace ha expirado o no funciona, puedes solicitar un nuevo correo de restablecimiento de contraseña desde nuestra página de inicio de sesión.</p>
        <p>Recuerda: Si tienes alguna pregunta o necesitas ayuda adicional, no dudes en ponerte en contacto con nuestro equipo de soporte a través de <a href="gretteldominguez185@gmail.com">soprte_infonavit@gmail.com</a>.</p>
        <p>Gracias por utilizar [Infonavit].</p>
        <p class="footer">Atentamente,<br>El equipo de [Infonavit]</p>
    </div>
</body>
</html>
