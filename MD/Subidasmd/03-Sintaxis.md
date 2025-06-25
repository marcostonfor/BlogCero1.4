---
Title: Sintaxis markdown
---

# ![icono](./images/iconitodocumento.jpg) Sintaxis

## Encabezados

Los encabezados en Markdown se crean utilizando el símbolo `#`. El número de `#` determina el nivel del encabezado, desde `#` para un encabezado de nivel 1 (el más importante) hasta `######` para un encabezado de nivel 6 (el menos importante).

```markdown
# Encabezado de nivel 1
## Encabezado de nivel 2
### Encabezado de nivel 3
#### Encabezado de nivel 4
##### Encabezado de nivel 5
###### Encabezado de nivel 6
```

### Énfasis (Cursiva y Negrita)

- **Cursiva:** Para escribir en cursiva, envuelve el texto con un asterisco (`*`) o guion bajo (`_`).
- **Negrita:** Para texto en negrita, utiliza dos asteriscos (`**`) o dos guiones bajos (`__`).

```markdown
*Texto en cursiva* o _Texto en cursiva_

**Texto en negrita** o __Texto en negrita__
```

### Listas

- **Listas no ordenadas (bullets):** Se crean utilizando un guion (`-`), un asterisco (`*`) o un signo más (`+`).
- **Listas ordenadas:** Se crean numerando los elementos de la lista con números seguidos de un punto (`1.`, `2.`, `3.`, etc.).

```markdown
- Elemento de lista no ordenada
* Otro elemento de lista no ordenada
+ Otro más

1. Elemento de lista ordenada
2. Segundo elemento
3. Tercer elemento
```

### Enlaces

Para crear un enlace, usa corchetes para el texto del enlace y paréntesis para la URL.

```markdown
[Texto del enlace](https://www.ejemplo.com)
```

### Imágenes

La sintaxis para incluir imágenes es similar a la de los enlaces, pero con un signo de exclamación (`!`) al principio.

```markdown
![Texto alternativo](https://www.ejemplo.com/imagen.jpg)
```

### Citas

Las citas se crean utilizando el símbolo de mayor que (`>`).

```markdown
> Esto es una cita.
```

### Código

- **En línea:** Para incluir código en línea, envuelve el texto con una sola comilla invertida (\`).
- **Bloques de código:** Para bloques de código más extensos, usa tres comillas invertidas (\`\`\`), especificando opcionalmente el lenguaje de programación para resaltar la sintaxis.

```markdown
Esto es `código en línea`.
```

```php
$bloque = "Esto es un bloque de código."
```

```python
# Bloque de código con resaltado de sintaxis
def hola():
    print("¡Hola, mundo!")
```

### Tablas

Las tablas se crean utilizando tuberías (`|`) para separar las columnas y guiones (`-`) para crear la línea que separa el encabezado del cuerpo de la tabla.

```markdown
| Columna 1 | Columna 2 | Columna 3 |
|-----------|-----------|-----------|
| Dato 1    | Dato 2    | Dato 3    |
| Dato 4    | Dato 5    | Dato 6    |
```

### Saltos de Línea y Párrafos

- **Salto de línea:** Se puede hacer añadiendo dos espacios al final de la línea.
- **Párrafo:** Para separar párrafos, simplemente deja una línea en blanco entre ellos.

```markdown
Este es el primer párrafo.

Este es el segundo párrafo.
```

### Separadores

Para crear una línea horizontal, utiliza tres o más asteriscos (`***`), guiones (`---`) o guiones bajos (`___`).

```markdown
---

***

___


### Comentarios

Aunque Markdown no tiene una sintaxis oficial para comentarios, puedes usar la sintaxis HTML para este propósito.

```markdown
<!-- Este es un comentario y no se mostrará en el documento renderizado -->
```

Markdown es una herramienta flexible que permite crear documentos bien formateados con facilidad, siendo especialmente útil para desarrolladores y escritores que necesitan una manera sencilla de dar formato a su texto.

___

> ###### FI

<nav>

[Gramatica de _**`Markdown`**_](MD/Gramatica.md)

</nav>