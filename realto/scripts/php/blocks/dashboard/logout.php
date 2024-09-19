<?php
session_start();

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Clear all cookies by setting their expiration time to the past
foreach ($_COOKIE as $cookie_name => $cookie_value) {
    setcookie($cookie_name, '', time() - 3600, '/');  // Expire each cookie
}

// Clear the session cookie by also expiring it
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to the home page
echo '<script>
        alert("Logged out successfully");
        location.href = "/realto/pages/home.php";
      </script>';
exit;
?>
