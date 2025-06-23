#!/bin/bash

# Este script configura los permisos de las carpetas necesarias para que el servidor web
# pueda escribir archivos (como borradores y artículos publicados).
# Sigue las buenas prácticas recomendadas en el README.md del proyecto.

# 1. Obtiene el directorio donde se encuentra este script para construir rutas absolutas.
#    Esto hace que el script funcione sin importar desde dónde se le llame.
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

# 2. Sube un nivel para apuntar a la raíz del proyecto.
PROJECT_ROOT=$(realpath "$SCRIPT_DIR/..")

# 3. Define las carpetas que necesitan permisos.
DRAFT_FOLDER="$PROJECT_ROOT/admin/editorParaArticulos/Draft"
PUBLISHED_FOLDER="$PROJECT_ROOT/admin/editorParaArticulos/Published"
SUBIDASMD_FOLDER="$PROJECT_ROOT/MD/Subidasmd"

# 4. Define el usuario del servidor web (comúnmente 'www-data' en sistemas Debian/Ubuntu).
WEB_USER="www-data"

# 5. Ejecuta los comandos directamente en la terminal actual.
#    - Se usa `sudo` para pedir privilegios de administrador.
echo "Se necesitará tu contraseña de administrador (sudo) para continuar."
echo '==================================================================='

sudo chown -vR $WEB_USER:$WEB_USER "$DRAFT_FOLDER" "$PUBLISHED_FOLDER" "$SUBIDASMD_FOLDER"
sudo chmod -vR 775 "$DRAFT_FOLDER" "$PUBLISHED_FOLDER" "$SUBIDASMD_FOLDER"

echo '==================================================================='
echo '✅ Permisos de escritura configurados correctamente.'
read -p "Presiona Enter para continuar..."
