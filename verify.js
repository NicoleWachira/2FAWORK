document.addEventListener('DOMContentLoaded', function () {
    const otpInputs = document.querySelectorAll('.otp-digit');

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function () {
            // Move to the next input if a value is entered
            if (input.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            // Restrict to a single digit
            if (input.value.length > 1) {
                input.value = input.value.slice(0, 1);
            }
        });

        input.addEventListener('keydown', function (event) {
            // Handle backspace to move focus to the previous input
            if (event.key === 'Backspace' && !input.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        input.addEventListener('keypress', function (event) {
            // Prevent non-numeric input
            if (!/[0-9]/.test(event.key)) {
                event.preventDefault();
            }
        });
    });

    // Automatically focus on the first input when the page loads
    otpInputs[0].focus();
});
