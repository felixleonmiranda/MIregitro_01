<?php
require_once __DIR__ . '/../modelo/Usuario.php';

class RegistroController {
    public function mostrarFormulario() {
        require __DIR__ . '/../vista/registro.php';
    }

    public function procesarRegistro() {
        // Validar los datos del formulario
        $errores = $this->validarDatos($_POST);

        if (empty($errores)) {
            try {
                $usuario = new Usuario();
                $usuario->nombre = $_POST['nombre'];
                $usuario->email = $_POST['email'];
                $usuario->passwordHash = Usuario::hashPassword($_POST['password']);

                if ($usuario->crear()) {
                    $this->mostrarExito($usuario);
                    return;
                }
            } catch (Exception $e) {
                $errores['general'] = $e->getMessage();
            }
        }

        // Mostrar formulario con errores
        $this->mostrarFormularioConErrores($errores);
    }

    private function validarDatos($datos) {
        $errores = [];

        // Validar nombre
        if (empty($datos['nombre'])) {
            $errores['nombre'] = 'El nombre es obligatorio';
        } elseif (strlen($datos['nombre']) > 100) {
            $errores['nombre'] = 'El nombre no puede exceder los 100 caracteres';
        }

        // Validar email
        if (empty($datos['email'])) {
            $errores['email'] = 'El email es obligatorio';
        } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es válido';
        } elseif (strlen($datos['email']) > 100) {
            $errores['email'] = 'El email no puede exceder los 100 caracteres';
        }

        // Validar contraseña
        if (empty($datos['password'])) {
            $errores['password'] = 'La contraseña es obligatoria';
        } elseif (strlen($datos['password']) < 6) {
            $errores['password'] = 'La contraseña debe tener al menos 6 caracteres';
        }

        // Validar confirmación de contraseña
        if ($datos['password'] !== $datos['confirm_password']) {
            $errores['confirm_password'] = 'Las contraseñas no coinciden';
        }

        // Validar términos
        if (empty($datos['terminos'])) {
            $errores['terminos'] = 'Debes aceptar los términos y condiciones';
        }

        return $errores;
    }

    private function mostrarFormularioConErrores($errores) {
        // Pasamos los errores a la vista
        require __DIR__ . '/../views/registro.php';
    }

    private function mostrarExito(Usuario $usuario) {
        echo "<h1>¡Registro exitoso!</h1>";
        echo "<p>Bienvenido/a, " . htmlspecialchars($usuario->nombre) . "</p>";
        echo "<p>Tu email registrado es: " . htmlspecialchars($usuario->email) . "</p>";
        echo "<p><a href='/registro'>Regresar</a></p>";
    }
}
?>