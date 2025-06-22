<?php

class DatabaseSingleton
{
    private static ?self $instance = null;
    private ?PDO $pdo;

    private function __construct()
    {
       
        // 1. Incluir el archivo de configuración para acceder a las constantes.
        // La ruta es relativa a la ubicación de este archivo.
        require_once __DIR__ . '/../../config.php';

        try {
            // 2. Usar las constantes de config.php para la conexión.
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // 3. Manejar errores de conexión de forma robusta.
            // En un entorno de producción, registrarías el error en lugar de mostrarlo.
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }


    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): ?PDO
    {
        return $this->pdo;
    }
}