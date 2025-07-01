# BlogCero - Sistema de Blog con PHP y MySQL

BlogCero es un sistema de gestión de contenidos (CMS) ligero y personal, construido con PHP puro y orientado a objetos. Está diseñado para ser un blog personal donde un administrador puede escribir y publicar artículos usando Markdown, así como gestionar otros aspectos del sitio desde un panel de administración protegido.

## ✨ Características Principales

- **Panel de Administración Seguro**: Sistema de login para acceder a las funciones de gestión.
- **Editor de Artículos Markdown**: Crea y guarda borradores (`Drafts`) de artículos escritos en Markdown.
- **Publicación de Contenidos**: Un sistema para "publicar" los borradores, haciéndolos visibles en la parte pública del blog.
- **Gestión de Iconos Sociales**: Permite seleccionar y mostrar en el sitio los iconos de tus redes sociales.
- **Paginación de Artículos**: Los artículos publicados se muestran en páginas para una mejor navegación.

## 🏛️ Arquitectura y Patrones de Diseño

El proyecto aspira a seguir principios de diseño de software sólidos para mantener un código limpio, organizado y escalable. Se utilizan (o se planea utilizar) los siguientes patrones y conceptos:

- **Singleton**: Para garantizar una única instancia de conexión a la base de datos (`DatabaseSingleton`).
- **Repository**: Para abstraer y centralizar el acceso a los datos (ej. `UserRepository`).
- **Service Layer**: Para encapsular la lógica de negocio (ej. `AuthService`).
- **Controller**: Para manejar las peticiones del usuario y coordinar la respuesta (ej. `LoginController`).
- -**Factory**: Para crear objetos complejos de forma desacoplada.

---


---

## 🚀 Instalación

Sigue estos pasos para instalar y ejecutar el proyecto en tu servidor local (como XAMPP, WAMP, o un entorno LAMP en Linux).

### 1. Prerrequisitos

- Servidor web (Apache o Nginx, xampp, etc.)
- PHP versión 8.0 o (superior recomendada)
- Base de datos MySQL o MariaDB
- Git (opcional, para clonar el repositorio)

### 2. Clonar el Repositorio o descargar .zip


#### Una vez tengas descargado el proyecto

Cúando hayas clonado o descargado el repositorio, lo primero que deberás hacer es meter la carpeta con el nombre que quíeras darle en el directorio raíz del servidor de que dispongas y para que el instalador no falle y todo funcione bien durante su proceso y después, es:

> Si es posible debes clonar en el directorio raíz de tu servidor web la aplicacion, si no descarga el zip y descomprimelo en la misma ubicacíon indicada, la carpeta raíz del servidor web. 

##### Solo para ubuntu

> Luego con el explorador de archivos te desplazas hasta la carpeta del proyecto, ahí buscas el directorio en la raíz llamado instalador/, entras y copias los archivos `iniciador.desktop` y `terminal.txt` en el Escritorio/, después has de dar permisos de ejecucion y válidar un metadato.Puedes hacerlo por terminal usando las ordenes una después de la otra 

```bash
chmod +x Escritorio/iniciador.desktop

gio set Escritorio/iniciador.desktop metadata::trusted true
```

#### Esto debería poder hacer funcionar el iniciador 

Una vez corridos estos comandos cierras la terminal y desde el Escritorio, haz doble click sobre `Instalar Blog Cero` y disfrutalo todo lo que puedas.

##### En otros entornos

> Si estas en otros entornos que no sean ubuntu lo que debes hacer es, excepto en windows (no testeado)

```shell
## Obviamente hay que desplazarse a
## la raiz del servidor web para correr estos comandos.
## Si no hay que añadír la ruta al nombre de proyecto
# Ordenes que se deben ejecutar:


sudo chmod 750 BlogCero1.5
sudo chown -R $USER:www-data BlogCero1.5
#--
sudo find BlogCero1.5 -type d -exec chmod 750 {} \;
sudo find BlogCero1.5 -type f -exec chmod 770 {} \;
#--
sudo chmod g+w BlogCero1.5

# Una vez corridos estos comandos tal cual,
# debe insistirse en otra carpeta.
# Si no obtiene permisos de escritura el servidor
# sobre ella no funcionara el publicador de páginas.
# Esto debe ejecutarse desde la ráz del proyecto,
# lo anteríor desde la raíz del servidor, gracias.
sudo chmod -R g+w MD/
sudo chmod -R g+w admin/editorParaArticulos/Draft/
sudo chmod -R g+w admin/editorParaArticulos/Published/
```

> **Nota:** Si estás en un entorno de desarrollo local como XAMPP en Windows, es posible que no necesites este paso, pero en un servidor Linux de producción es **esencial**.

### 3. Configurar la Base de Datos

1. Abre tu gestor de base de datos (como phpMyAdmin).
2. Crea una nueva base de datos. Por ejemplo, `dbForTuBlog`.
    - > La base de datos debe peramanecer vacía y sin tablas,  
    las creará el instalador.

### 4. Configurar la Conexión

El proyecto necesita un archivo `config.php` en la raíz para conectarse a la base de datos. Este archivo **no está en el repositorio** por seguridad (está en `.gitignore`). El instalador lo crea y escribe en el lo necesario.

### 5. Lanza el instalador

En la barra del navegador escribe: `localhost/pryecto/install.php
debería renderizarse el instalador para la base de datos.
