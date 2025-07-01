<?php
session_start();
session_unset();
session_destroy();
setcookie(session_name(), '', time() - 3600, '/');
echo "Sesión cerrada. <a href='../login/login.php'>Volver al login</a>";
