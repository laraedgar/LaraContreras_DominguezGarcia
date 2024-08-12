<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['id'];

    // Consulta SQL para eliminar el usuario
    $query = "DELETE FROM users WHERE id='$userId'";

    if (mysqli_query($conn, $query)) {
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
