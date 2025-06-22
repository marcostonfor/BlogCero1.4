# ¡Claro! Te voy a dar una **guía paso a paso sencilla y segura** para que puedas implementar esta mejora poco a poco, sin riesgos, y con comprobaciones para no romper nada.

---

## Guía paso a paso para implementar el cambio de nombres de links del menú

---

### 1. **Haz un backup rápido**

Antes de tocar cualquier archivo, haz copia de seguridad de estos archivos importantes:

* `siteConfigIU.php` (UI para configuración)
* `siteConfig.php` (procesa el guardado)
* Archivo que genera el menú (ejemplo `header.php` o donde sea que generes la barra del menú)

Así podrás volver atrás si algo falla.

---

### 2. **Añadir campos para los textos del menú en el formulario de configuración**

* Abre tu archivo `siteConfigIU.php` donde está el formulario del título.
* Justo **debajo del campo del título**, copia y pega este código para añadir 3 nuevos campos para el menú:

```php
<?php
// Antes de <form> debes tener la conexión PDO y la lectura del título
// Ahora añade estas variables para leer el texto guardado de cada link:

$menu_items = [
    'menu_home' => 'Inicio',
    'menu_articles' => 'Artículos',
    'menu_contact' => 'Contacto'
];

foreach ($menu_items as $key => &$value) {
    try {
        $stmt = $pdo->prepare("SELECT config_value FROM site_config WHERE config_key = :key");
        $stmt->execute(['key' => $key]);
        $result = $stmt->fetchColumn();
        if ($result !== false) {
            $value = htmlspecialchars($result);
        }
    } catch (PDOException $e) {
        $value = 'Error';
    }
}
?>
```

Luego dentro del formulario justo después del input para título, añade:

```html
<label for="menu_home">Texto para "Inicio":</label>
<input type="text" id="menu_home" name="menu_home" value="<?php echo $menu_items['menu_home']; ?>"><br><br>

<label for="menu_articles">Texto para "Artículos":</label>
<input type="text" id="menu_articles" name="menu_articles" value="<?php echo $menu_items['menu_articles']; ?>"><br><br>

<label for="menu_contact">Texto para "Contacto":</label>
<input type="text" id="menu_contact" name="menu_contact" value="<?php echo $menu_items['menu_contact']; ?>"><br><br>
```

Guarda y revisa que la página del panel de configuración carga sin errores y muestra estos campos.

---

### 3. **Modificar el archivo que guarda la configuración (`siteConfig.php`)**

* Abre `siteConfig.php`.
* Justo después de guardar el título, añade un bloque para guardar los textos del menú:

```php
$menu_keys = ['menu_home', 'menu_articles', 'menu_contact'];
foreach ($menu_keys as $key) {
    if (isset($_POST[$key])) {
        $value = trim($_POST[$key]);
        $stmt = $pdo->prepare("
            INSERT INTO site_config (config_key, config_value) 
            VALUES (:key, :value) 
            ON DUPLICATE KEY UPDATE config_value = :value
        ");
        $stmt->execute(['key' => $key, 'value' => $value]);
    }
}
```

Guarda y prueba enviar el formulario con nuevos textos para el menú. Debería guardar sin errores y mostrar el mensaje de confirmación.

---

### 4. **Modificar el código que genera el menú para usar los textos de la base**

* Busca el archivo donde generas el menú principal (por ejemplo `header.php` o dentro del componente `FactoryForComponents` si ahí está).
* Cambia la parte donde defines los textos fijos como “Inicio”, “Artículos”, etc., por este código que lee desde base de datos:

```php
$menu = [
    'home' => 'Inicio',
    'articles' => 'Artículos',
    'contact' => 'Contacto'
];

foreach ($menu as $key => &$text) {
    $config_key = "menu_" . $key;
    $stmt = $pdo->prepare("SELECT config_value FROM site_config WHERE config_key = :key");
    $stmt->execute(['key' => $config_key]);
    $result = $stmt->fetchColumn();
    if ($result !== false) {
        $text = htmlspecialchars($result);
    }
}
```

* Luego usa `$menu['home']`, `$menu['articles']`, etc., para mostrar el texto en los enlaces.

Guarda y prueba cargando la web normal, los textos deben aparecer con los que hayas puesto en configuración.

---

### 5. **Prueba paso a paso**

* Cambia solo un archivo y prueba antes de seguir.
* Usa mensajes `echo` o `var_dump` para depurar si algo no funciona.
* Si algo falla, restaura el backup de ese archivo.

---

### 6. **Extras para más seguridad**

* Asegúrate que tu tabla `site_config` tenga `config_key` con **UNIQUE** para que el `INSERT ... ON DUPLICATE KEY UPDATE` funcione bien.
* Si no tienes esa restricción, añádela:

```sql
ALTER TABLE site_config ADD UNIQUE (config_key);
```

---

---

## Resumen

| Paso | Qué hacer                        | Archivo / lugar           |
| ---- | -------------------------------- | ------------------------- |
| 1    | Backup archivos                  | Varios                    |
| 2    | Añadir inputs menú en formulario | `siteConfigIU.php`        |
| 3    | Guardar inputs menú en DB        | `siteConfig.php`          |
| 4    | Leer textos menú desde DB        | `header.php` o donde esté |
| 5    | Probar y corregir errores        | ---                       |

---

Si quieres, puedo ayudarte paso a paso, enviando solo el código de cada parte que vayas a modificar para que no te agobies. ¿Quieres?
