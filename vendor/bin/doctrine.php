#!/usr/bin/env sh
SRC_DIR="`pwd`"
cd "`dirname "$0"`"
cd "../doctrine/orm/bin"
BIN_TARGET="`pwd`/doctrine.php"
cd "$SRC_DIR"
"$BIN_TARGET" "$@"
