---
name: write unittest
description: Write PHP UnitTest for WordPress Plugin.
---

## Rules

1. **Unit test directory** — `test/Unit`
2. **Test File name should add suffix** - `Test.php`

## Sample Example

Use this template as sample when creating new test files. It shows all conventions applied together:

```php
<?php
	/**
	 * Test cases for Common trait.
	 *
	 * @package StorePress/AdminUtils/Tests
	 */

	declare( strict_types=1 );

	use StorePress\AdminUtils\Traits\HelperMethodsTrait;
	use StorePress\AdminUtils\Traits\SingletonTrait;

	/**
	 * Common Trait Test Case.
	 */
class HelperMethodsTest extends WP_UnitTestCase {

	use SingletonTrait;
	use HelperMethodsTrait;

	private HelperMethodsTest $test_instance;

	/**
	 * Set up test fixtures.
	 */
	public function set_up(): void {
		parent::set_up();
		$this->test_instance = self::instance();
	}

	/**
	 * Tear down test fixtures.
	 */
	public function tear_down(): void {
		parent::tear_down();
		$_GET     = array();
		$_POST    = array();
		$_REQUEST = array();
	}

	// =========================================================================
	// Tests for get_var()
	// =========================================================================

	/**
	 * Test get_var returns variable value when set.
	 */
	public function test_get_var_returns_value_when_set(): void {
		$variable = 'test_value';
		$this->assertSame( 'test_value', $this->test_instance->get_var( $variable ) );
	}

	/**
	 * Test get_var returns default value when variable is not set.
	 */
	public function test_get_var_returns_default_when_not_set(): void {
		$variable = null;
		unset( $variable );
		$this->assertSame( 'default', $this->test_instance->get_var( $variable, 'default' ) );
	}

	/**
	 * Test get_var returns null as default when no default provided.
	 */
	public function test_get_var_returns_null_when_no_default(): void {
		$variable = null;
		unset( $variable );
		$this->assertNull( $this->test_instance->get_var( $variable ) );
	}
}
```
