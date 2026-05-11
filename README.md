# Duplicate Variations for WooCommerce

- PHP Stan `npm run stan:php`
- PHP Lint `npm run lint:php`
- JS Lint `npm run lint:js`
- JS SCSS `npm run lint:css`
- Format `npm run format:php`
- Format `npm run format:js`
- Format `npm run format:css`
- Change Version On `package.json` and `composer.json`
- Run `npm run package`
- Run `git tag $(node -p "require('./package.json').version") && git push origin "$_"`

- To Delete Tag
- `git tag -d $(node -p "require('./package.json').version") && git push origin --delete "$_"`

## [Initialize the testing environment locally](https://make.wordpress.org/cli/handbook/how-to/plugin-unit-tests/)
