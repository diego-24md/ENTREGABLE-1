<?php
// Conexión a la base de datos
include 'conexion.php';
?>

<?php
// Incluir el archivo de procesamiento de inicio de sesión y registro
include 'procesar_login_registro.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda de Ropa</title>
    <link rel="stylesheet" href="./CSS/index.css">
</head>
<body>

    <main>
        <div class="login-container">
            <!-- Formulario de inicio de sesión -->
            <div id="login-box" class="login-box">
                <h2>Iniciar sesión</h2>
                <form action="index.php" method="POST">
                    <div class="input-group">
                        <label for="login_username">Nombre de usuario:</label>
                        <input type="text" id="login_username" name="login_username" required>
                    </div>
                    <div class="input-group">
                        <label for="login_password">Contraseña:</label>
                        <input type="password" id="login_password" name="login_password" required>
                    </div>
                    <button type="submit" class="btn">Iniciar sesión</button>
                    <?php if (isset($login_error)) { echo "<p class='error'>$login_error</p>"; } ?>
                    <p>No tienes cuenta? <a href="#" id="show-register">Regístrate</a></p>
                </form>
            </div>

            <!-- Formulario de registro -->
            <div id="register-box" class="register-box">
                <h2>Registrarse</h2>
                <form action="index.php" method="POST">
                    <div class="input-group">
                        <label for="reg_username">Nombre de usuario:</label>
                        <input type="text" id="reg_username" name="reg_username" required>
                    </div>
                    <div class="input-group">
                        <label for="reg_email">Correo electrónico:</label>
                        <input type="email" id="reg_email" name="reg_email" required>
                    </div>
                    <div class="input-group">
                        <label for="reg_password">Contraseña:</label>
                        <input type="password" id="reg_password" name="reg_password" required>
                    </div>
                    <button type="submit" class="btn">Registrarse</button>
                    <?php if (isset($register_error)) { echo "<p class='error'>$register_error</p>"; } ?>
                    <?php if (isset($register_success)) { echo "<p class='success'>$register_success</p>"; } ?>
                    <p>¿Ya tienes cuenta? <a href="#" id="show-login">Inicia sesión</a></p>
                </form>
            </div>
        </div>
    </main>

    <script>
        const loginBox = document.getElementById('login-box');
        const registerBox = document.getElementById('register-box');
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');

        // Mostrar solo login al inicio
        registerBox.style.display = 'none';

        showRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginBox.style.opacity = '0';
            setTimeout(() => {
                loginBox.style.display = 'none';
                registerBox.style.display = 'block';
                setTimeout(() => registerBox.style.opacity = '1', 10);
            }, 300);
        });

        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            registerBox.style.opacity = '0';
            setTimeout(() => {
                registerBox.style.display = 'none';
                loginBox.style.display = 'block';
                setTimeout(() => loginBox.style.opacity = '1', 10);
            }, 300);
        });
    </script>

</body>
</html>
