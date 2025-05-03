<?php
// Conexión a la base de datos
include 'conexion.php';

// Iniciar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iniciar sesión
    if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
        $username = $_POST['login_username'];
        $password = $_POST['login_password'];

        // Buscar usuario en la tabla usuarios
        $query = "SELECT * FROM usuarios WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Verificar contraseña (aquí sería mejor con password_verify si está hasheada)
            if (password_verify($password, $user['password'])) {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: productos.php");
                exit();                
            } else {
                $login_error = "Contraseña incorrecta.";
            }
        } else {
            $login_error = "Usuario no encontrado.";
        }
    }

    // Registro de usuario
    if (isset($_POST['reg_username']) && isset($_POST['reg_email']) && isset($_POST['reg_password'])) {
        $reg_username = $_POST['reg_username'];
        $reg_email = $_POST['reg_email'];
        $reg_password = $_POST['reg_password'];

        // Encriptar contraseña
        $hashed_password = password_hash($reg_password, PASSWORD_DEFAULT);

        // Verificar que no exista usuario o email
        $check_query = "SELECT * FROM usuarios WHERE username = '$reg_username' OR email = '$reg_email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $register_error = "El nombre de usuario o correo ya está registrado.";
        } else {
            // Registrar usuario
            $insert_query = "INSERT INTO usuarios (username, email, password) 
                             VALUES ('$reg_username', '$reg_email', '$hashed_password')";

            if (mysqli_query($conn, $insert_query)) {
                $register_success = "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                $register_error = "Error al registrar usuario.";
            }
        }
    }
}
?>
