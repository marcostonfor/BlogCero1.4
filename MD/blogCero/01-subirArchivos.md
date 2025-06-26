---
Title: Subír páginas
---

# Módulo de Subida y Gestión de Archivos Markdown (`.md`)

Este módulo permite a los usuarios subir, visualizar y mover archivos Markdown (`.md`) dentro del panel de administración de blogCero. Está diseñado para facilitar la gestión de contenidos en formato Markdown, asegurando una experiencia intuitiva y segura.

## Funcionalidades principales

- **Subida de archivos `.md`**  
  Los usuarios pueden seleccionar y subir uno o varios archivos Markdown desde su dispositivo. El sistema valida que solo se acepten archivos con extensión `.md` y muestra mensajes claros en caso de error.

- **Visualización de archivos subidos**  
  Los archivos subidos se listan en una tabla, mostrando su nombre y tamaño. Cada nombre de archivo es interactivo: al hacer clic, se copia automáticamente al campo de texto del formulario de mover archivos, facilitando la selección sin errores de tipeo.

- **Mover archivos entre carpetas**  
  El panel incluye un formulario para mover archivos desde la carpeta de subidas (`Subidasmd/`) a cualquier subcarpeta dentro de `MD/`. El usuario puede seleccionar el archivo (haciendo clic en la lista) y especificar la ruta de destino.

- **Vista de la estructura de directorios**  
  Se muestra la estructura de carpetas de `MD/` en formato árbol, ayudando al usuario a elegir correctamente la ruta de destino al mover archivos.

## Experiencia de usuario

- **Interfaz clara y visual**:  
  El panel está dividido en secciones para subir archivos, ver los archivos existentes y moverlos. Los elementos interactivos (como los nombres de archivo) ofrecen retroalimentación visual al ser seleccionados.

- **Validaciones y seguridad**:  
  Solo se permiten archivos `.md`. El sistema valida el nombre y la extensión, y muestra mensajes de error o éxito según corresponda.

- **Facilidad para copiar nombres**:  
  Al hacer clic en un archivo de la lista, su nombre se copia automáticamente al formulario de mover archivos, minimizando errores y agilizando el proceso.

## Ejemplo de flujo de uso

1. **Subir archivos**:  
   Selecciona uno o varios archivos `.md` y súbelos usando el formulario.