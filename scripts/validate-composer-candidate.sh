#!/usr/bin/env sh
set -eu

# Temporary candidate-validation behavior: remove this allowlist when Fight Common 1.2 has a release tag.
output=$(mktemp)
trap 'rm -f "$output"' 0 HUP INT TERM

if ! composer validate >"$output" 2>&1; then
  cat "$output"
  exit 1
fi

expected='- The package "johnnickell/fight-common" is pointing to a commit-ref, this is bad practice and can cause unforeseen issues.'
warnings=$(grep '^- ' "$output" || true)

if [ "$warnings" != "$expected" ]; then
  cat "$output"
  printf '%s\n' 'Composer validation emitted an unexpected warning; only the pinned Fight Common candidate warning is allowed.' >&2
  exit 1
fi

cat "$output"
