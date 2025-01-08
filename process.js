// validation.js
document.addEventListener('DOMContentLoaded', function () {
    //Get the form element
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(event) {
        let errors = [];
        
        // Validate username: only letters and white space allowed
        const username = document.getElementById('username').value;
        if (!/^[a-zA-Z-']*$/.test(username)) {
            errors.push("Only letters and white space are allowed in the Username field.");
        }

        // Validate email
        const email = document.getElementById('email').value;
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!emailPattern.test(email)) {
            errors.push("Invalid email format.");
        }

        // Validate password: minimum length of 8 characters
        const password = document.getElementById('password').value;
        if (password.length < 8) {
            errors.push("Password must be at least 8 characters long.");
        }

        // If there are validation errors, display them and prevent form submission
        if (errors.length > 0) {
            event.preventDefault();
            const errorContainer = document.createElement('div');
            errorContainer.classList.add('alert', 'alert-danger');
            errorContainer.innerHTML = "<ul>" + errors.map(error => `<li>${error}</li>`).join('') + "</ul>";
            form.prepend(errorContainer);
        }
    });
});
