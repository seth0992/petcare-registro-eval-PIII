$(function() {
    // Animación para los mensajes de alerta
    $('.alert').fadeIn('slow').delay(5000).fadeOut('slow');

    // Validación del formulario
    $('#frm_registro').on('submit', function(e) {
        // Validar nombre
        const nombre = $('#txt_nombre').val().trim();
        if (nombre === '') {
            e.preventDefault();
            mostrarError('El nombre de la mascota es obligatorio');
            return false;
        }
        
        // Validar raza
        const raza = $('#txt_raza').val().trim();
        if (raza === '') {
            e.preventDefault();
            mostrarError('La raza es obligatoria');
            return false;
        }
        
        // Validar edad
        const edad = $('#txt_edad').val().trim();
        if (edad === '' || isNaN(edad) || parseInt(edad) < 0) {
            e.preventDefault();
            mostrarError('Ingrese una edad válida');
            return false;
        }
        
        // Validar propietario
        const propietario = $('#txt_propietario').val().trim();
        if (propietario === '') {
            e.preventDefault();
            mostrarError('El nombre del propietario es obligatorio');
            return false;
        }
        
        // Validar teléfono
        const telefono = $('#txt_telefono').val().trim();
        if (telefono === '' || !/^[0-9]+$/.test(telefono)) {
            e.preventDefault();
            mostrarError('Ingrese un número de teléfono válido (solo números)');
            return false;
        }
        
        return true;
    });
    
    // Validación en tiempo real del teléfono
    $('#txt_telefono').on('input', function() {
        // Eliminar cualquier carácter que no sea un número
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
    
    // Función para mostrar mensajes de error
    function mostrarError(mensaje) {
        // Eliminar alertas anteriores
        $('.alert').remove();
        
        // Crear y mostrar nueva alerta
        const alertDiv = $('<div></div>')
            .addClass('alert alert-danger')
            .text(mensaje);
        
        $('#registro_box').prepend(alertDiv);
        
        // Auto-eliminar después de 5 segundos
        alertDiv.fadeIn('slow').delay(5000).fadeOut('slow', function() {
            $(this).remove();
        });
        
        // Desplazarse al principio del formulario
        $('html, body').animate({
            scrollTop: $('#registro_box').offset().top - 20
        }, 500);
    }
});