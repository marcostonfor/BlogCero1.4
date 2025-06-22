# BlogCero - Sistema de Blog con PHP y MySQL

BlogCero es un sistema de gestión de contenidos (CMS) ligero y personal, construido con PHP puro y orientado a objetos. Está diseñado para ser un blog personal donde un administrador puede escribir y publicar artículos usando Markdown, así como gestionar otros aspectos del sitio desde un panel de administración protegido.

## ✨ Características Principales

-   **Panel de Administración Seguro**: Sistema de login para acceder a las funciones de gestión.
-   **Editor de Artículos Markdown**: Crea y guarda borradores (`Drafts`) de artículos escritos en Markdown.
-   **Publicación de Contenidos**: Un sistema para "publicar" los borradores, haciéndolos visibles en la parte pública del blog.
-   **Gestión de Iconos Sociales**: Permite seleccionar y mostrar en el sitio los iconos de tus redes sociales.
-   **Paginación de Artículos**: Los artículos publicados se muestran en páginas para una mejor navegación.

## 🏛️ Arquitectura y Patrones de Diseño

El proyecto aspira a seguir principios de diseño de software sólidos para mantener un código limpio, organizado y escalable. Se utilizan (o se planea utilizar) los siguientes patrones y conceptos:

-   **Singleton**: Para garantizar una única instancia de conexión a la base de datos (`DatabaseSingleton`).
-   **Repository**: Para abstraer y centralizar el acceso a los datos (ej. `UserRepository`).
-   **Service Layer**: Para encapsular la lógica de negocio (ej. `AuthService`).
-   **Controller**: Para manejar las peticiones del usuario y coordinar la respuesta (ej. `LoginController`).
-   -**Factory**: Para crear objetos complejos de forma desacoplada.

---

## 🚀 Instalación

Sigue estos pasos para instalar y ejecutar el proyecto en tu servidor local (como XAMPP, WAMP, o un entorno LAMP en Linux).

### 1. Prerrequisitos

-   Servidor web (Apache o Nginx)
-   PHP (versión 8.0 o superior recomendada)
-   Base de datos MySQL o MariaDB
-   Git (opcional, para clonar el repositorio)

### 2. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/BlogCero1.2-estatic.git
cd BlogCero1.2-estatic
```

### 3. Configurar la Base de Datos

1.  Abre tu gestor de base de datos (como phpMyAdmin).
2.  Crea una nueva base de datos. Por ejemplo, `dbForBlogCero`.
3.  Selecciona la base de datos recién creada y ve a la pestaña **Importar**.
4.  Selecciona el archivo `database/schema.sql` del proyecto y ejecútalo. Esto creará todas las tablas necesarias.

### 4. Configurar la Conexión

El proyecto necesita un archivo `config.php` en la raíz para conectarse a la base de datos. Este archivo **no está en el repositorio** por seguridad (está en `.gitignore`). Debes crearlo tú mismo.

Crea un archivo llamado `config.php` en la raíz del proyecto con el siguiente contenido, reemplazando los valores con tus credenciales:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'dbForBlogCero');
define('DB_USER', 'root'); // Tu usuario de la base de datos
define('DB_PASS', 'asdfg2'); // Tu contraseña
define('DB_CHARSET', 'utf8mb4');
```

### 5. Configurar Permisos de Carpetas (¡Muy Importante!)

El servidor web (generalmente el usuario `www-data` en Linux) necesita permisos para escribir archivos en ciertas carpetas. Sin esto, funciones como guardar borradores de artículos fallarán.

Abre una terminal en tu servidor y ejecuta los siguientes comandos, reemplazando `/ruta/completa/a/tu/proyecto` con la ruta real a la carpeta `BlogCero1.2-estatic`.

```bash
# Dar propiedad de las carpetas clave al usuario del servidor web
sudo chown -R www-data:www-data /ruta/completa/a/tu/proyecto/admin/editorParaArticulos/Draft
sudo chown -R www-data:www-data /ruta/completa/a/tu/proyecto/admin/editorParaArticulos/posts

# Asegurar que el servidor tenga permisos de lectura, escritura y ejecución
sudo chmod -R 775 /ruta/completa/a/tu/proyecto/admin/editorParaArticulos/Draft
sudo chmod -R 775 /ruta/completa/a/tu/proyecto/admin/editorParaArticulos/posts
```

> **Nota:** Si estás en un entorno de desarrollo local como XAMPP en Windows, es posible que no necesites este paso, pero en un servidor Linux de producción es **esencial**.


## 📂 Estructura de Carpetas

```
/
├── admin/                # Panel de administración y lógica de gestión.
│   ├── editorParaArticulos/ # Editor de Markdown, borradores (Draft) y posts.
│   └── socialMedia/         # Gestión de iconos de redes sociales.
├── database/             # Archivos SQL para la estructura de la base de datos.
├── system_login/         # Lógica central del sistema de usuarios y autenticación.
│   └── dbSingleton/      # Patrón Singleton para la conexión a la BD.
├── .gitignore            # Archivos y carpetas ignorados por Git.
├── config.php            # (Local) Credenciales de la base de datos.
└── README.md             # Este archivo.
```