---
name: write phpdocs
description: Write PHP DocBlocks with PHPStan support. DO NOT modify any code — only add/update documentation.
---

## Rules

1. **DO NOT change or modify any code** — only add DocBlocks, comments, and reorder methods.
2. **DO NOT Verbose docblocks** - Keep concise, one line is ideal

## File & Class Level

- File DocBlock (PSR-12): `@package`, `@since`, `@version`
- Class DocBlock: `@name`, description, `@phpstan-use`, `@method` — never use `@extend`
- Add `@example` with 1-2 usages example for `class`.

## Methods

- DocBlock with `@param`, `@return`, and `@since` with single line description
- Use `git log -S "method_name"` to find when it was introduced
- Add `@since` annotation with that version
- Add `@see` where methods relate to each other
- PHPStan annotations (`@template`, `@var`) must support IDE autocompletion (PHPStorm etc.)
- Name hook callback methods: `handle_{hook_name}`
- Add `@example` with 1-2 usages example for `public` methods.

## Hooks & Translations

- Inline comment for `add_action()` / `add_filter()` declarations
- Description of when the hook fires for `do_action()` / `apply_filters()`
- `@param` tags for each parameter passed to the hook
- Add `/* translators: ... */` comments before translation strings (`esc_html__`, `esc_html_e`) wrapped in `sprintf`/`printf`
- Use `git log -S "hook_name"` to find when it was introduced
- Add `@since` annotation with that version
-

## Method Organization

Group methods into logical sections with header comments like:

```php
// =====================================================================
// Service Lifecycle Methods
// =====================================================================

// =====================================================================
// Service Provider Registration Methods
// =====================================================================

// =====================================================================
// Setters
// =====================================================================

// =====================================================================
// ArrayAccess/Backwards Compatibility
// =====================================================================
```

## Code Standards

- PHP 7.4+ with strict types declared
- WordPress Coding Standards (WPCS) + WooCommerce sniffs
- PHPStan level 6
