<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="publico\css\styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="form-title">Registro de Usuario</h1>
            
            <?php if (isset($errores['general'])): ?>
                <div class="alert alert-danger show"><?= htmlspecialchars($errores['general']) ?></div>
            <?php endif; ?>
            
            <form id="registrationForm" action="/registro" method="POST" novalidate>
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control <?= isset($errores['nombre']) ? 'is-invalid' : '' ?>" 
                           id="nombre" name="nombre" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>" required>
                    <div class="error-message" id="nombreError" style="display: <?= isset($errores['nombre']) ? 'block' : 'none' ?>;">
                        <?= isset($errores['nombre']) ? htmlspecialchars($errores['nombre']) : '' ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control <?= isset($errores['email']) ? 'is-invalid' : '' ?>" 
                           id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                    <div class="error-message" id="emailError" style="display: <?= isset($errores['email']) ? 'block' : 'none' ?>;">
                        <?= isset($errores['email']) ? htmlspecialchars($errores['email']) : '' ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control <?= isset($errores['password']) ? 'is-invalid' : '' ?>" 
                           id="password" name="password" required minlength="6">
                    <div class="error-message" id="passwordError" style="display: <?= isset($errores['password']) ? 'block' : 'none' ?>;">
                        <?= isset($errores['password']) ? htmlspecialchars($errores['password']) : '' ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control <?= isset($errores['confirm_password']) ? 'is-invalid' : '' ?>" 
                           id="confirm_password" name="confirm_password" required>
                    <div class="error-message" id="confirmPasswordError" style="display: <?= isset($errores['confirm_password']) ? 'block' : 'none' ?>;">
                        <?= isset($errores['confirm_password']) ? htmlspecialchars($errores['confirm_password']) : '' ?>
                    </div>
                </div>
                
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input <?= isset($errores['terminos']) ? 'is-invalid' : '' ?>" 
                           id="terminos" name="terminos" <?= isset($_POST['terminos']) ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="terminos">Acepto los términos y condiciones</label>
                    <div class="error-message terms-error" style="display: <?= isset($errores['terminos']) ? 'block' : 'none' ?>;">
                        <?= isset($errores['terminos']) ? htmlspecialchars($errores['terminos']) : 'Debes aceptar los términos' ?>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </form>

            <div id="successMessage" class="alert alert-success mt-4 d-none">
                ¡Registro exitoso! Bienvenido/a <span id="successName"></span>.
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript personalizado -->
    <script src="publico\js\script.js"></script>
</body>
</html>