#!/bin/zsh
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
DIST_DIR="$ROOT_DIR/dist"
PACKAGE_NAME="coresuite-lite-release"
STAGE_DIR="$DIST_DIR/$PACKAGE_NAME"

mkdir -p "$DIST_DIR"
rm -rf "$STAGE_DIR"
mkdir -p "$STAGE_DIR"

rsync -a \
  --exclude-from="$ROOT_DIR/.distignore" \
  "$ROOT_DIR/" \
  "$STAGE_DIR/" \
  --exclude "dist" \
  --exclude ".git"

rm -rf \
  "$STAGE_DIR/.env" \
  "$STAGE_DIR/server.log" \
  "$STAGE_DIR/node_modules" \
  "$STAGE_DIR/storage/logs" \
  "$STAGE_DIR/storage/uploads" \
  "$STAGE_DIR/public/preview.html" \
  "$STAGE_DIR/public/dev_dashboard.php" \
  "$STAGE_DIR/app/Views/partials/sidebar.php.bak" \
  "$STAGE_DIR/.vscode" \
  "$STAGE_DIR/src" \
  "$STAGE_DIR/tools/screenshot.js" \
  "$STAGE_DIR/LITE.session.sql" \
  "$STAGE_DIR/seed.php"

mkdir -p "$STAGE_DIR/storage/uploads" "$STAGE_DIR/storage/logs"
touch "$STAGE_DIR/storage/uploads/.gitkeep" "$STAGE_DIR/storage/logs/.gitkeep"

echo "Release staged in: $STAGE_DIR"
