<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/x-icon" href="icon.png"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <body>
    <div class="container">
         <h1>Bienvenido "<?php echo $_SESSION['username']; ?>"</h1><br>
    <a href="logout.php" class="btn btn-outline-danger logout">Cerrar Sesión</a>

    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Data">
        Ingresar datos
    </button> <br><br>


        <div class="card">
            <div class="card-body">
                <h2 class="card-title">MOSTRAR DATOS</h2>
                <table id="usersTable" class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>NSS</th>
                            <th>RFC</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Email</th>
                            <th>Puntos Acumulados</th>
                        </tr>
                    <tr>
                    
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    <div class="modal fade" id="Data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Datos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="DataForm" autocomplete="off">
                        <div class="mb-3">
                            <label for="text" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="text" name="Nombre Completo" required>
                            <label for="number" class="form-label">NSS</label>
                            <input type="number" class="form-control" id="number" name="NSS" required>
                            <label for="text" class="form-label">RFC</label>
                            <input type="text" class="form-control" id="text" name="RFC" required>
                            <label for="date" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="date" name="Fecha de Nacimiento" required>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-success">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>