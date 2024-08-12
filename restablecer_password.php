<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = trim($_POST['new_password']);
    
    if (empty($new_password)) {
        echo "La contraseña no puede estar vacía.";
        exit();
    }

    // Verificar el token y actualizar la contraseña
    $query = "SELECT user_id FROM password_resets WHERE token = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            
            // Actualizar la contraseña
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
            
            if ($stmtUpdate = $conn->prepare($updateQuery)) {
                $stmtUpdate->bind_param('si', $new_password_hashed, $user_id);
                $stmtUpdate->execute();
                $stmtUpdate->close();
                
                // Eliminar el token
                $deleteTokenQuery = "DELETE FROM password_resets WHERE token = ?";
                if ($stmtDelete = $conn->prepare($deleteTokenQuery)) {
                    $stmtDelete->bind_param('s', $token);
                    $stmtDelete->execute();
                    $stmtDelete->close();
                }

                echo "Tu contraseña ha sido restablecida con éxito.";
            } else {
                echo "Error al actualizar la contraseña.";
            }
        } else {
            echo "Token inválido.";
        }
        
        $stmt->close();
    } else {
        echo "Error en la consulta.";
    }
}

$conn->close();
?>
