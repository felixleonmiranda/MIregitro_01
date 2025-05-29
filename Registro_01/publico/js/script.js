document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const inputs = document.querySelectorAll('.form-control');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const emailInput = document.getElementById('email');
    const nameInput = document.getElementById('name');
    const termsCheckbox = document.getElementById('terms');
    const successMessage = document.getElementById('successMessage');

    // Efecto hover en el formulario
    const formContainer = document.querySelector('form');
    if (formContainer) {
        formContainer.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.15)';
        });

        formContainer.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
        });
    }

    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            validateField(this);
        });

        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });

        input.addEventListener('blur', function() {
            if (this.value === '') {
                this.parentElement.classList.remove('input-focused');
            }
        });
    });

    // Validación del formulario al enviar
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });

            if (!termsCheckbox.checked) {
                termsCheckbox.classList.add('is-invalid');
                document.querySelector('.terms-error').style.display = 'block';
                isValid = false;
            } else {
                termsCheckbox.classList.remove('is-invalid');
                document.querySelector('.terms-error').style.display = 'none';
            }

            if (isValid) {
                // Simular envío exitoso (en un caso real sería una petición AJAX)
                showSuccessMessage();
                
                // Resetear después de 3 segundos
                setTimeout(() => {
                    form.reset();
                    inputs.forEach(input => {
                        input.classList.remove('is-valid');
                    });
                    successMessage.classList.add('d-none');
                }, 5000);
            } else {
                // Mostrar mensaje de error general
                showAlert('Por favor corrige los errores en el formulario', 'danger');
            }
        });
    }

    // Funciones de validación
    function validateField(field) {
        let isValid = true;
        const errorElement = document.getElementById(`${field.id}Error`);

        if (field.required && field.value.trim() === '') {
            markAsInvalid(field, errorElement, 'Este campo es obligatorio');
            isValid = false;
        } else {
            // Validaciones específicas por tipo de campo
            switch (field.id) {
                case 'email':
                    if (!validateEmail(field.value)) {
                        markAsInvalid(field, errorElement, 'Ingresa un correo electrónico válido');
                        isValid = false;
                    } else {
                        markAsValid(field, errorElement);
                    }
                    break;
                    
                case 'password':
                    if (field.value.length < 6) {
                        markAsInvalid(field, errorElement, 'La contraseña debe tener al menos 6 caracteres');
                        isValid = false;
                    } else {
                        markAsValid(field, errorElement);
                        
                        // Validar confirmación de contraseña si ya tiene valor
                        if (confirmPasswordInput.value !== '') {
                            validateField(confirmPasswordInput);
                        }
                    }
                    break;
                    
                case 'confirmPassword':
                    if (field.value !== passwordInput.value) {
                        markAsInvalid(field, errorElement, 'Las contraseñas no coinciden');
                        isValid = false;
                    } else {
                        markAsValid(field, errorElement);
                    }
                    break;
                    
                default:
                    markAsValid(field, errorElement);
            }
        }
        
        return isValid;
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    function markAsInvalid(field, errorElement, message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    function markAsValid(field, errorElement) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    // Mostrar mensajes
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} show`;
        alertDiv.textContent = message;
        
        const form = document.querySelector('form');
        if (form) {
            form.prepend(alertDiv);
            
            // Eliminar después de 5 segundos
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    }

    function showSuccessMessage() {
        if (successMessage) {
            successMessage.classList.remove('d-none');
            document.body.style.backgroundColor = '#e8f4fd';
            
            // Cambiar color de fondo temporalmente
            setTimeout(() => {
                document.body.style.backgroundColor = '#f8f9fa';
            }, 2000);
        }
    }

    // Efecto de carga para el botón
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.addEventListener('click', function() {
            if (form.checkValidity()) {
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';
                this.disabled = true;
            }
        });
    }
});