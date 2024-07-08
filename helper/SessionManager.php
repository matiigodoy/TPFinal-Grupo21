<?php
ini_set('session.cookie_httponly', 1); // Solo accesible por HTTP (no JavaScript)
ini_set('session.cookie_secure', 1);   // Solo se envía a través de HTTPS
ini_set('session.cookie_samesite', 'Strict'); // Restringir el envío de cookies a sitios cruzados
class SessionManager {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setUser($userID, $role) {
        $_SESSION['userID'] = $userID;
        $_SESSION['role'] = $role;
        $_SESSION['isAdmin'] = ($role === 'admin');
        $_SESSION['isEditor'] = ($role === 'editor');
        $_SESSION['isUser'] = ($role === 'user');
    }

    public function destroy() {
        session_unset();
        session_destroy();
    }
}
