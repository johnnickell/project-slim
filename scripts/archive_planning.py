#!/usr/bin/env python3
"""Fail closed until TASK-00002 implements new-schema planning archives."""

import sys


def main() -> int:
    print(
        "Planning archives are disabled pending TASK-00002. "
        "Only EPIC/TICKET/TASK will be supported; no legacy selectors or apply mode are available. "
        "No files were moved or rewritten.",
        file=sys.stderr,
    )
    return 2


if __name__ == "__main__":
    sys.exit(main())
