<?php 
session_start(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('https://www.example.com/background-image.jpg'); /* URL de una imagen de fondo */
            background-size: cover;
            background-attachment: fixed;
            color: #086A87;
        }
        .container {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco translúcido */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            margin-bottom: 40px;
        }
        .table-container h1 {
            margin-bottom: 20px;
            color: #086A87;
        }
        .table-dark {
            background-color: #086A87;
            color: #ffffff;
        }
        .table-dark th, .table-dark td {
            vertical-align: middle;
        }
        .btn-custom {
            color: #fff;
            background-color: #086A87;
            border-color: #086A87;
        }
        .btn-custom:hover {
            color: #fff;
            background-color: #086A87;
            border-color: #086A87;
        }
        .logout {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, "<?php echo htmlspecialchars($_SESSION['username']); ?>"</h1>
        <a href="logout.php" class="btn btn-outline-danger logout">Cerrar Sesión</a>
        
        <!-- TABLA QUE MUESTRA LOS USUARIOS -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Usuarios</h2>
                <table id="usersTable" class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Email</th>
                            <th>Tipo de Usuario</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'conexion.php'; // Conexión a la base de datos

                        $query = "SELECT id, username, password, email, id_cargo FROM users WHERE id_cargo != '1'";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['username']}</td>
                                    <td>{$row['password']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['id_cargo']}</td>
                                    <td>
                                        <button class='btn btn-custom delete-btn' data-id='{$row['id']}'>Eliminar</button>
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Roles</h2>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'conexion.php'; // Conexión a la base de datos

                        $query = "SELECT id, descripcion FROM cargo";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['descripcion']}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();

            // Manejar el clic en el botón de eliminación
            $('#usersTable').on('click', '.delete-btn', function() {
                const userId = $(this).data('id');
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás recuperar este usuario después de eliminarlo.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'delete_user.php',
                            method: 'POST',
                            data: { id: userId },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado!',
                                    'El usuario ha sido eliminado.',
                                    'success'
                                ).then(function() {
                                    location.reload(); // Recargar la página para actualizar la tabla
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al eliminar el usuario.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
