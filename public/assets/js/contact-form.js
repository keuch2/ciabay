// Contact Form Handler
(function() {
    'use strict';
    
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const formMessage = document.getElementById('formMessage');
    
    if (!contactForm) return;
    
    let isSubmitting = false;
    
    // Form submission handler
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Prevent duplicate submissions
        if (isSubmitting) {
            return;
        }
        
        // Validate required fields
        const requiredFields = contactForm.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });
        
        if (!isValid) {
            showMessage('Por favor complete todos los campos obligatorios', 'error');
            return;
        }
        
        // Validate email format
        const emailField = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            showMessage('Por favor ingrese un email válido', 'error');
            emailField.classList.add('error');
            return;
        }
        
        // Disable submit button and show loading state
        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enviando...';
        submitBtn.classList.add('loading');
        
        // Prepare form data
        const formData = new FormData(contactForm);
        
        // Send AJAX request
        fetch('/process-contact.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                showMessage(data.message, 'success');
                contactForm.reset();
                
                // Keep button disabled for 30 seconds to prevent spam
                setTimeout(function() {
                    isSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Enviar Mensaje';
                    submitBtn.classList.remove('loading');
                }, 30000);
            } else {
                showMessage(data.message, 'error');
                isSubmitting = false;
                submitBtn.disabled = false;
                submitBtn.textContent = 'Enviar Mensaje';
                submitBtn.classList.remove('loading');
            }
        })
        .catch(function(error) {
            showMessage('Error al enviar el mensaje. Por favor intente nuevamente.', 'error');
            isSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar Mensaje';
            submitBtn.classList.remove('loading');
        });
    });
    
    // Show message function
    function showMessage(message, type) {
        formMessage.textContent = message;
        formMessage.className = 'form-message ' + type;
        formMessage.style.display = 'block';
        
        // Scroll to message
        formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Auto-hide error messages after 5 seconds
        if (type === 'error') {
            setTimeout(function() {
                formMessage.style.display = 'none';
            }, 5000);
        }
    }
    
    // Remove error class on input
    const inputs = contactForm.querySelectorAll('input, textarea');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.classList.remove('error');
        });
    });
})();
