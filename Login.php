<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Función para redirigir con parámetros de error
function redirectWithError($errorCode) {
    header("Location: login.html?error=$errorCode");
    exit();
}

// Obtener datos del formulario y limpiar entradas
$username = trim($_POST['username']);
$password = trim($_POST['psw']);

if (empty($username) || empty($password)) {
    redirectWithError('empty_fields');
}

// Preparar la consulta SQL para evitar inyecciones SQL
$query = "SELECT username, password, id_cargo FROM users WHERE username = ?";

// Preparar y ejecutar la declaración
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    
    // Verificar si el usuario existe
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($dbUsername, $dbPassword, $dbCargo);
        $stmt->fetch();
        
        // Verificar la contraseña
        if (password_verify($password, $dbPassword)) {
            // Iniciar sesión y redirigir según el rol del usuario
            $_SESSION['username'] = $dbUsername;
            $_SESSION['id_cargo'] = $dbCargo;
            
            if ($dbCargo == '1') {
                header('Location: Admin.php');
            } elseif ($dbCargo == '2') {
                header('Location: User.php');
            }
            exit();
        } else {
            redirectWithError('invalid_password');
        }
    } else {
        redirectWithError('user_not_found');
    }
    
    $stmt->close();
} else {
    redirectWithError('query_error');
}

$conn->close();
?>
