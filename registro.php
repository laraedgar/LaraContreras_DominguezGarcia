<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar datos del formulario
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['psw']);
    $id_cargo = intval($_POST['id_cargo']); // Asegura que id_cargo sea un entero

    // Validaciones simples
    if (empty($username) || empty($email) || empty($password) || empty($id_cargo)) {
        echo "Por favor, complete todos los campos.";
        exit();
    }

    // Validar formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Dirección de correo electrónico no válida.";
        exit();
    }

    // Hash de la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Consulta SQL preparada para evitar inyecciones SQL
    $query = "INSERT INTO users (username, email, password, id_cargo) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('sssi', $username, $email, $hashedPassword, $id_cargo);

        if ($stmt->execute()) {
            echo "Usuario agregado exitosamente.";
        } else {
            echo "Error: No se pudo agregar el usuario. Intente de nuevo.";
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }

    $conn->close();
}
?>
