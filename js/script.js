// Get registration form
const registerForm = document.getElementById("registerForm");

if (registerForm) {

    registerForm.addEventListener("submit", function(event) {

        // Get password values
        const password = document.getElementById("password").value;

        const confirmPassword =
            document.getElementById("confirm_password").value;

        // Check password length
        if (password.length < 6) {

            alert("Password must contain at least 6 characters.");

            event.preventDefault();

        }

        // Check matching passwords
        else if (password !== confirmPassword) {

            alert("Passwords do not match!");

            event.preventDefault();

        }

    });

}


// Login form validation
const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", function(event) {

        const email = loginForm.querySelector(
            'input[name="email"]'
        ).value;

        const password = loginForm.querySelector(
            'input[name="password"]'
        ).value;

        if (email.trim() === "" || password.trim() === "") {

            alert("Please fill in all fields.");

            event.preventDefault();

        }

    });

}