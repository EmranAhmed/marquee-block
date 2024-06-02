# StorePress Base Plugin

## First

- `git clone https://github.com/EmranAhmed/marquee-block.git`
- Install https://wp-cli.org/ if not available
- `npm install`
- `npm run packages-update` - Update WordPress packages

## Where to change

- Open all files from `includes` directory and change namespace from `namespace StorePress\Base;` to `namespace Your_Company\Your_Plugin;`.
- Open `storepress-base-plugin.php` and change plugin header, text-domain, namespace, defined Constant `STOREPRESS_BASE_PLUGIN_FILE`, function name.
- Open `includes/Plugin.php` and change `STOREPRESS_BASE_PLUGIN_FILE` on `function get_plugin_file()` function.
- Open `storepress-base-plugin.php` to your plugin file name.
- Rename `storepress-base-plugin.php` to your plugin file name.
- Open `.eslintrc.js` and change `allowedTextDomain: ['storepress-base-plugin'],`
- Open `composer.json` and change `name`, `description`, `autoload`
- Open `package.json` and change `name` as plugin file name, `description`, `repository`, `languages/storepress-base-plugin.pot`
- Open `phpcs.xml` and change `<rule ref="WordPress.NamingConventions.PrefixAllGlobals">`, `<property name="text_domain" value="storepress-base-plugin"/>`
- Open `bin/package.js` and change `files = glob(...` for package files.

## Develop:

- `npm start`

### Create New Block(s)

- `npm run add [block name]` - To add dynamic block
- `npm run add-static [block name]` - To add static block

## Lint

- `npm run lint:js` - Lint Javascript
- `npm run lint:css` - Lint CSS
- `npm run lint:php` - PHP lint

- `composer run analyze [filename.php]` - statically analyzes PHP for bugs
- `composer run lint` - checks PHP for syntax errors
- `composer run standards:check` - checks PHP for standards errors according to WordPress coding standards
- `composer run standards:fix` - Attemps to automatically fix errors

## Release:

- `npm run package` - make package directory
- `npm run zip` - make zip
