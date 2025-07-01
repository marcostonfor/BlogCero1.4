

console.log('¿marked está definido?', typeof marked);

const parser = {
    render: (markdown) => marked.parse(markdown)
};

marked.setOptions({
    highlight: function (code, lang) {
        if (Prism.languages[lang]) {
            return Prism.highlight(code, Prism.languages[lang], lang);
        }
        return code; // Fallback sin resaltar
    },
    langPrefix: 'language-', // para que Prism detecte bien la clase
});
Prism.highlightAll();
// Resalta el código
;

const contenidosArray = [
    `### Ejemplo del uso de \`SELECT\` en SQL

#### La instrucción \`SELECT\` se utiliza para recuperar datos de una o más tablas.

\`\`\`sql
SELECT nombre, edad
FROM usuarios
WHERE edad >= 18;
\`\`\`
`,
    `### Ejemplo del uso de \`FROM\` en SQL

#### La instrucción \`FROM\` especifica la tabla o tablas de las cuales se extraen los datos.

\`\`\`sql
SELECT producto, precio
FROM inventario
WHERE precio > 100;
\`\`\`
`,


];

const celdas = document.querySelectorAll('.palabras_reservadas table td');

celdas.forEach((td, index) => {
    td.classList.add('myBtn');
    td.style.cursor = 'pointer';

    const modal = document.createElement('div');
    modal.className = 'myModal';
    Object.assign(modal.style, {
        display: 'none',
        position: 'fixed',
        zIndex: '1000',
        left: '0',
        top: '0',
        width: '40vw',
        height: 'auto',
        overflow: 'auto',
        transform: 'translate(50%, 50%)'
    });

    const modalContent = document.createElement('div');
    Object.assign(modalContent.style, {
        borderRadius: '0.4vw',
        boxShadow: '0 0 2px 10px #808080',
        margin: '10% auto',
        padding: '20px',
        border: '1px solid #888',
        width: '80%',
        position: 'relative',
    });
    modalContent.classList.add('markdown-body');

    const span = document.createElement('span');
    span.className = 'close';
    span.innerHTML = '&times;';
    Object.assign(span.style, {
        position: 'absolute',
        top: '10px',
        right: '25px',
        color: '#aaa',
        fontSize: '28px',
        fontWeight: 'bold',
        cursor: 'pointer'
    });

    span.onclick = () => modal.style.display = 'none';

    modalContent.appendChild(span);
    modal.appendChild(modalContent);
    document.body.appendChild(modal);

    td.addEventListener('click', () => {
        const contenido = contenidosArray[index] || 'Contenido no disponible.';
        const html = typeof marked !== 'undefined' ? parser.render(contenido) : contenido;

        while (modalContent.childNodes.length > 1) {
            modalContent.removeChild(modalContent.lastChild);
        }

        const div = document.createElement('div');
        div.innerHTML = html;
        modalContent.appendChild(div);

        // 🔥 Aquí se aplica el resaltado
        Prism.highlightAll();

        modal.style.display = 'block';
    });

    /* td.addEventListener('click', () => {
        const contenido = contenidosArray[index] || 'Contenido no disponible.';
        const html = typeof marked !== 'undefined' ? parser.render(contenido) : contenido;

        while (modalContent.childNodes.length > 1) {
            modalContent.removeChild(modalContent.lastChild);
        }

        const div = document.createElement('div');
        div.innerHTML = html;
        modalContent.appendChild(div);

        modal.style.display = 'block';
    }); */

    modal.addEventListener('click', e => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});