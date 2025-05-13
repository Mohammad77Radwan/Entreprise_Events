document.addEventListener('DOMContentLoaded', function() {
    // Activate Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle flash messages auto-dismiss
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var fadeOutEffect = setInterval(function () {
                if (!alert.style.opacity) {
                    alert.style.opacity = 1;
                }
                if (alert.style.opacity > 0) {
                    alert.style.opacity -= 0.1;
                } else {
                    clearInterval(fadeOutEffect);
                    alert.remove();
                }
            }, 100);
        });
    }, 3000);

    // Event date/time validation
    var startDateInput = document.getElementById('start_datetime');
    var endDateInput = document.getElementById('end_datetime');
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
            if (endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
        });
    }
});