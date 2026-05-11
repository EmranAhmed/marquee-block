---
name: fix textdomain
description: Convert hardcoded English strings in PHP files to WordPress i18n functions. Read text domain from CLAUDE.md before starting.
---

## Setup

1. Read `CLAUDE.md` to find the plugin entry file
2. Read the `Text Domain:` header from that entry file
3. Use that text domain for all conversions

## What to Convert

**Convert** user-facing strings in: `echo`, `return`, `throw`, `wp_die()`, array values for labels/messages/descriptions, admin notices, JSON responses.

**Skip:** already i18n'd strings, empty strings, array keys, hook names (`do_action`, `apply_filters`, `add_action`, `add_filter`), `define()` constants, technical strings (DB tables, option keys, CSS classes, regex, SQL, URLs, file paths).

## Conversion Table

| Context                  | Function                                            |
|--------------------------|-----------------------------------------------------|
| General / escaped output | `esc_html__('Text', 'domain')`                      |
| HTML attributes          | `esc_attr__('Text', 'domain')`                      |
| Inside `echo`            | `echo esc_html__('Text', 'domain')`                 |
| Exceptions               | `throw new Exception(esc_html__('Text', 'domain'))` |
| `wp_die()`               | `wp_die(esc_html__('Text', 'domain'))`              |

## Special Cases

**Variables in strings** — replace interpolation with `sprintf` + placeholder:

```php
// Before
"Hello {$name}, welcome!"
// After
/* translators: %s: User name. */
sprintf(esc_html__('Hello %s, welcome!', 'domain'), esc_html($name))
```

**Strings with HTML** — separate HTML from translatable text:

```php
sprintf(
    /* translators: %s: Link HTML. */
    esc_html__('Click %s', 'domain'),
    '<a href="#">' . esc_html__('here', 'domain') . '</a>'
)
```

**Plurals** — use `_n()`:

```php
sprintf(
    /* translators: %d: Number of items. */
    _n('%d item', '%d items', $count, 'domain'),
    $count
)
```

## Rules

- Always add `/* translators: ... */` comments before strings with placeholders
- Preserve existing code formatting and indentation
- Do not introduce syntax errors
- Do not change any logic or non-string code
