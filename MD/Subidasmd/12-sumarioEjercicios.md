---
Title: Indice ejercicios
---

# Sumario de ejercicios 

Se compone de `15 ejercicios prácticos`
para aprender la **`sintáxis`** extendida que supone ___`pandoc`___.

### Ejercicio 1: Metadatos del Documento
**Objetivo**: Añadir metadatos al documento.
```markdown
---
title: "Mi Primer Documento"
author: "Tu Nombre"
date: "2024-08-21"
---
```
**Explicación**: Los metadatos se colocan al inicio del documento entre líneas de guiones (`---`). Esto permite definir el título, autor y fecha del documento.

### Ejercicio 2: Encabezados
**Objetivo**: Crear encabezados de diferentes niveles.
```markdown
# Encabezado 1
## Encabezado 2
### Encabezado 3
```
**Explicación**: Los encabezados se crean usando el símbolo `#`. Un `#` para un encabezado de nivel 1, `##` para nivel 2, y así sucesivamente.

### Ejercicio 3: Listas Ordenadas y Desordenadas
**Objetivo**: Crear listas ordenadas y desordenadas.
```markdown
1. Primer ítem
2. Segundo ítem
3. Tercer ítem

- Ítem A
- Ítem B
- Ítem C
```
**Explicación**: Las listas ordenadas usan números seguidos de un punto (`1.`), mientras que las listas desordenadas usan guiones (`-`).

### Ejercicio 4: Enlaces y Imágenes
**Objetivo**: Añadir enlaces e imágenes.
```markdown
[Enlace a Google](https://www.google.com)

![Imagen de ejemplo](https://via.placeholder.com/150)
```
**Explicación**: Los enlaces se crean con `[texto](URL)` y las imágenes con `![texto alternativo](URL de la imagen)`.

### Ejercicio 5: Texto en Negrita y Cursiva
**Objetivo**: Formatear texto en negrita y cursiva.
```markdown
**Este texto está en negrita**

*Este texto está en cursiva*
```
**Explicación**: El texto en negrita se encierra entre dos asteriscos (`**`) y el texto en cursiva entre un asterisco (`*`).

### Ejercicio 6: Notas al Pie
**Objetivo**: Añadir notas al pie.
```markdown
Este es un ejemplo de una nota al pie.

: Aquí está la nota al pie.
```
**Explicación**: Las notas al pie se crean con `[^n^]` en el texto y `[^n^]:` seguido de la nota al pie al final del documento.

### Ejercicio 7: Tablas
**Objetivo**: Crear una tabla simple.
```markdown
| Encabezado 1 | Encabezado 2 |
|--------------|--------------|
| Fila 1, Col 1| Fila 1, Col 2|
| Fila 2, Col 1| Fila 2, Col 2|
```
**Explicación**: Las tablas se crean usando tuberías (`|`) para separar columnas y guiones (`-`) para separar el encabezado del cuerpo.

### Ejercicio 8: Listas de Definiciones
**Objetivo**: Crear una lista de definiciones.
```markdown
Termo 1
: Definición 1

Termo 2
: Definición 2
```
**Explicación**: Las listas de definiciones usan `Termo` seguido de `:` y la definición en la línea siguiente.

### Ejercicio 9: Superíndice y Subíndice
**Objetivo**: Añadir superíndice y subíndice.
```markdown
Superíndice: H^2^O

Subíndice: CO~2~
```
**Explicación**: El superíndice se crea con `^` y el subíndice con `~`.

### Ejercicio 10: Texto Tachado
**Objetivo**: Añadir texto tachado.
```markdown
Este es un texto ~~tachado~~.
```
**Explicación**: El texto tachado se crea encerrándolo entre dos tildes (`~~`).

### Ejercicio 11: Bloques de Código Delimitados
**Objetivo**: Añadir un bloque de código con resaltado de sintaxis.
```markdown
```python
def hola_mundo():
    print("¡Hola, mundo!")
```
```
**Explicación**: Los bloques de código se crean con tres acentos graves (```) antes y después del código. Se puede especificar el lenguaje para el resaltado de sintaxis.

### Ejercicio 12: Citas Automáticas y Bibliografías
**Objetivo**: Añadir una cita automática.
```markdown
[@autor2024]
```
**Explicación**: Las citas automáticas se crean con `[@cita]` y se gestionan con un archivo de bibliografía.

### Ejercicio 13: Matemáticas en LaTeX
**Objetivo**: Añadir una fórmula matemática.
```markdown
La fórmula cuadrática es: \( ax^2 + bx + c = 0 \)
```
**Explicación**: Las fórmulas matemáticas se crean usando LaTeX entre `\( \)` para inline o `$$ $$` para bloques.

### Ejercicio 14: Conversión de Archivos
**Objetivo**: Convertir un archivo Markdown a HTML usando Pandoc.
```sh
pandoc -s -o output.html input.md
```
**Explicación**: El comando `pandoc -s -o output.html input.md` convierte un archivo Markdown (`input.md`) a HTML (`output.html`).

### Ejercicio 15: Creación de un Documento PDF
**Objetivo**: Convertir un archivo Markdown a PDF usando Pandoc.
```sh
pandoc -s -o output.pdf input.md
```
**Explicación**: El comando `pandoc -s -o output.pdf input.md` convierte un archivo Markdown (`input.md`) a PDF (`output.pdf`).
