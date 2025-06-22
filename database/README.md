# Mi Proyecto de Blog

Este es un proyecto de blog creado con PHP y MySQL.

## 🚀 Instalación

Sigue estos pasos para instalar y ejecutar el proyecto en tu máquina local.

### Prerrequisitos

-   Tener un servidor web local como [XAMPP](https://www.apachefriends.org/es/index.html), WAMP o MAMP instalado. Esto te proporcionará Apache, PHP y MySQL (o MariaDB).
-   Un gestor de bases de datos como phpMyAdmin (incluido en XAMPP).

### Pasos

1.  **Clona el repositorio:**
    ```sh
    git clone https://github.com/tu-usuario/tu-repositorio.git
    cd tu-repositorio
    ```

2.  **Crea la base de datos:**
    -   Abre phpMyAdmin en tu navegador (normalmente `http://localhost/phpmyadmin`).
    -   Crea una nueva base de datos. Puedes llamarla `mi_blog` o como prefieras.

3.  **Importa la estructura de la base de datos:**
    -   Selecciona la base de datos que acabas de crear.
    -   Ve a la pestaña "Importar".
    -   Selecciona el archivo `database/schema.sql` que se encuentra en el proyecto.
    -   Haz clic en "Continuar". Esto creará todas las tablas necesarias.

4.  **Configura la conexión:**
    -   Abre el proyecto en tu navegador (ej: `http://localhost/tu-repositorio/install.php`).
    -   Rellena el formulario con las credenciales de la base de datos que creaste.
    -   El asistente creará el archivo `config.php` por ti.

5.  **¡Listo!**
    -   Una vez finalizada la instalación, podrás acceder al proyecto.
    -   **Importante:** Por seguridad, elimina el archivo `install.php` después de la configuración.

