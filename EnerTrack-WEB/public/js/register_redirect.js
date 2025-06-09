document.addEventListener('DOMContentLoaded', function() {
    // Only execute if a success message is present in the session (checked by PHP/Blade)
    // The Blade template will conditionally include this script.
    setTimeout(function() {
        window.location.href = '/login'; // Use direct path to login
    }, 3000); // Redirect after 3 seconds
}); 