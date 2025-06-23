# Perfecto, aquí tienes una referencia de las tablas mínimas necesarias para cubrir esos requerimientos:

### 1. Artículos

**Tablas sugeridas:**
- `articulos`: Guarda la información principal del artículo (título, contenido, estado, fecha, autor, etc.).
- `articulos_draft`: Opcional, si quieres separar los borradores de los publicados, aunque puedes usar un campo `estado` en la tabla `articulos` para distinguir entre "borrador" y "publicado".
- `usuarios`: Para relacionar los artículos con el autor/editor (si no existe ya).

**Relaciones:**
- Un artículo pertenece a un usuario (autor).
- Un artículo puede estar en estado "borrador" o "publicado".

### 2. Páginas

**Tablas sugeridas:**
- `paginas`: Guarda la información de cada página (nombre, ruta del archivo `.md`, fecha de subida, usuario que la subió, etc.).
- `usuarios`: Para saber quién subió cada página (si no existe ya).

**Relaciones:**
- Una página pertenece a un usuario (quien la subió).
- Puedes guardar la ruta relativa dentro de la carpeta MD para saber su ubicación.

---

### Resumen de tablas mínimas

1. `articulos`
2. `paginas`
3. `usuarios` (si no existe ya)

**Opcional:**  
- Si quieres guardar historial de movimientos de archivos `.md`, podrías tener una tabla `paginas_movimientos`.

¿Te gustaría ver un ejemplo de estructura de estas tablas en SQL?