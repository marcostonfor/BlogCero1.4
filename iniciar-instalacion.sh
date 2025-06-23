#!/bin/bash

# Este script automatiza los primeros pasos de la instalación.
# 1. Ejecuta el script de permisos.
# 2. Abre el instalador web en el navegador por defecto.

echo "🚀 Iniciando la configuración de BlogCero..."
echo "--------------------------------------------------"

# Obtiene el directorio raíz del proyecto, asumiendo que este script está en la raíz.
PROJECT_ROOT=$(pwd)
PERMISSIONS_SCRIPT="$PROJECT_ROOT/shell/controlPermisos.sh"

# --- PASO 1: Ejecutar el script de permisos ---
echo "PASO 1: Configurando permisos de carpetas..."

if [ -f "$PERMISSIONS_SCRIPT" ]; then
    # Hacemos el script de permisos ejecutable por si no lo es
  sudo chmod 755 "$PERMISSIONS_SCRIPT"
    # Lo ejecutamos. El script original está diseñado para abrir su propia terminal y pausar.
    bash "$PERMISSIONS_SCRIPT"
else
    echo "❌ Error: No se encontró el script de permisos en: $PERMISSIONS_SCRIPT"
    exit 1
fi

# --- PASO 2: Abrir el instalador en el navegador ---
PROJECT_FOLDER_NAME=$(basename "$PROJECT_ROOT")
URL="http://localhost/$PROJECT_FOLDER_NAME/install.php"

echo ""
echo "PASO 2: Abriendo el instalador web..."
echo "Se intentará abrir la URL: $URL"
echo "Si no se abre automáticamente, por favor, copia y pégala en tu navegador."

# Comando para abrir URL según el sistema operativo
case "$(uname -s)" in
   Linux*)     xdg-open "$URL" 2>/dev/null || echo "No se pudo usar xdg-open. Por favor, abre la URL manualmente." ;;
   Darwin*)    open "$URL" ;;
   CYGWIN*|MINGW*|MSYS*) start "$URL" ;;
   *)          echo "No se pudo detectar el sistema operativo para abrir el navegador automáticamente." ;;
esac

echo "--------------------------------------------------"
echo "✅ Proceso finalizado."