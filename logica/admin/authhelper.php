<?php
// Logica/Admin/authHelper.php

class AuthHelper {
    
    public static function esAdministrador() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['usuario']['estado']) && $_SESSION['usuario']['estado'] === 'admin';
    }
    
    public static function requerirAdministrador() {
        if (!self::esAdministrador()) {
            header("Location: ../Usuario/dashboard.php?error=No tienes permisos de administrador");
            exit();
        }
    }
    
    public static function obtenerUsuario() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['usuario'] ?? null;
    }
}
?>