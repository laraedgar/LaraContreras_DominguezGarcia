<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('Helpex.png');
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .form-group button:hover {
            background-color: #086A87;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <form id="resetForm" action="/reset-password" method="POST">
            <div class="form-group">
                <label for="code">Código enviado al correo</label>
                <input type="text" id="code" name="code" required>
            </div>
            <div class="form-group">
                <label for="newPassword">Nueva Contraseña</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <button type="submit">Restablecer Contraseña</button>
            </div>
            <div id="errorMessage" class="error"></div>
        </form>
    </div>
    <script>
        document.getElementById('resetForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const code = document.getElementById('code').value;
            const newPassword = document.getElementById('newPassword').value;
            const errorMessage = document.getElementById('errorMessage');

            // Validación básica
            if (code === '' || newPassword === '') {
                errorMessage.textContent = 'Por favor, completa todos los campos.';
                return;
            }

            // Aquí deberías añadir lógica para enviar los datos al servidor
            // Ejemplo de cómo podrías hacerlo con fetch (asegúrate de cambiar la URL y manejar el response)
            fetch('/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ code, newPassword }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirigir o mostrar un mensaje de éxito
                    window.location.href = '/login';
                } else {
                    errorMessage.textContent = data.message || 'Hubo un error al restablecer la contraseña.';
                }
            })
            .catch(error => {
                errorMessage.textContent = 'Hubo un error en la solicitud.';
            });
        });
    </script>
</body>
</html>