$(document).ready(function() {
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
    });

    $('.view-venue').on('click', function() {
    });

    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
    });
});

document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const fields = form.querySelectorAll('.field');
        
        function validateField(field) {
            const input = field.querySelector('.item');
            const errorText = field.querySelector('.error-text');
            
            if (input.value.trim() === '') {
                field.classList.add('error');
                return false;
            } else {
                field.classList.remove('error');
                return true;
            }
        }
        
        // Real-time validation
        fields.forEach(field => {
            const input = field.querySelector('.item');
            input.addEventListener('blur', () => validateField(field));
            input.addEventListener('input', () => {
                if (input.value.trim() !== '') {
                    field.classList.remove('error');
                }
            });
        });
        
        // Form submission
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            fields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    });