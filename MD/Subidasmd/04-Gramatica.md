---
Title: Una posible gramatica
---

# ![icono](./images/iconitodocumento.jpg)  Gramatica

**`Markdown`**, aunque es más conocido como un lenguaje de marcado, también puede considerarse desde una perspectiva gramatical. Su `"gramática"` <mark><u>se refiere a las reglas y estructuras sintácticas que determinan cómo se debe escribir el texto</u></mark> en **`Markdown`** para que sea <u>**`interpretado`**</u> correctamente por los motores de renderizado.

### `Gramática de Markdown`

La `gramática` de **`Markdown`** se basa en una estructura simple y directa:

a. **`Tokens`:** Son las unidades básicas que **`Markdown`** reconoce, como `#`, `*`, `[]`, `()`, etc. Estos `tokens` indican el inicio y el final de elementos como ***encabezados, listas, énfasis, enlaces, etc***.

b. **`Reglas de Producción`:** Estas reglas determinan cómo los `tokens` se combinan para formar estructuras más complejas. Por ejemplo, un encabezado se produce cuando un `#` es seguido de un espacio y luego del texto del encabezado.

c. **`Contexto Libre`:** **`Markdown`** <mark>se considera un lenguaje de marcado de contexto libre</mark>, <u>lo que significa que las reglas de `sintaxis` se aplican de la misma manera en cualquier parte del documento, sin importar su contexto</u>.

d. **`Jerarquía de Elementos`:** Algunos elementos en **`Markdown`** tienen una <u>jerarquía</u>. Por ejemplo, los encabezados tienen diferentes niveles, y dentro de una lista, puedes tener sublistas.

### *Ejemplo de Análisis Gramatical*

`Considera el siguiente fragmento de` **`Markdown`**:

```markdown
# Título Principal

Este es un párrafo con *cursiva* y **negrita**.

- Elemento 1
- Elemento 2
  - Subelemento 1
  - Subelemento 2

[Enlace a Google](https://www.google.com)
```

#### *Desglose Gramatical:*

1. **Encabezado:** `# Título Principal`
   - **Token:** `#` (indica un encabezado de nivel 1)
   - **Texto:** "Título Principal"

2. **Párrafo:** `Este es un párrafo con *cursiva* y **negrita**.`
   - **Token de inicio:** (ninguno, Markdown asume texto plano)
   - **Tokens de énfasis:** `*` para cursiva, `**` para negrita
   - **Contenido:** Texto con elementos de énfasis

3. **Lista:** 
   - **Token de lista:** `-` (indica un elemento de lista)
   - **Sublista:** Otro `-` con indentación, crea una sublista

4. **Enlace:** `[Enlace a Google](https://www.google.com)`
   - **Token de enlace:** `[]` para el texto del enlace, `()` para la URL

***

---

### **`Orientación Gramatical`**

- **`Markdown`** ___se___  <mark><u>orienta a la estructura jerárquica y lineal de un documento</u></mark>:

   - **`Jerárquico`:** Los encabezados y listas crean una estructura jerárquica, como un árbol de secciones y subsecciones.
   - **`Lineal`:** El texto y los elementos siguen un flujo lineal, donde el orden en que se escriben determina el orden en que se renderizan.

### **`Posibles Orientaciones Gramaticales`**

- **`Markdown`** <q>podría</q> <mark><u>orientarse a diferentes aplicaciones según cómo se interpreten sus reglas</u></mark>:

    - **`Orientado a Documentos`:** Ideal para la creación de documentos estructurados, como informes, manuales y libros.
    - **`Orientado a Código`:** Al incluir bloques de código con resaltado de sintaxis, es útil en la documentación técnica y educativa.
    - **`Orientado a Contenido Web`:** Su capacidad de crear HTML lo hace útil para blogs, páginas de aterrizaje y artículos en línea.
    - **`Orientado a Presentaciones`:** Con extensiones como Reveal.js, Markdown puede usarse para crear diapositivas y presentaciones interactivas.

___

> ###### FI

<nav>

[Gramatica de **`Markdown`**](MD/Sintaxis.md)

</nav>