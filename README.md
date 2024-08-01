# Marquee Block

CSS Only marquee block. 

You can [test the block in your browser](https://playground.wordpress.net/?mode=seamless&blueprint-url=https://raw.githubusercontent.com/EmranAhmed/marquee-block/master/.wp-playground/blueprint.json) using Playground.

## Requirements

- WordPress 6.4+
- PHP 7.4+

## Initial

- `npm install`
- `npm run packages-update`

## Develop

- `npm start`

## Lint

- `npm run lint:js` - Lint Javascript
- `npm run lint:js:report` - Lint Javascript and will generate `lint-report.html`. From terminal `open lint-report.html`
- `npm run lint:css` - Lint CSS
- `npm run lint:css:report` - Lint CSS and will generate `scss-report.txt` file.
- `npm run lint:php` - PHP lint and will generate `phpcs-report.txt` file.

## Fix

- `npm run lint:js:fix` - Fix Javascript Lint Issue.
- `npm run lint:css:fix` - Fix SCSS Lint Issue.

## Format

- `npm run format:js` - Format Javascript
- `npm run format:css` - Format SCSS
- `npm run format:php` - Format PHP
- `npm run format` - Format `./src`

## Release

- `npm run plugin-zip` - make zip based on `package.json` `files` list.

## Provide your own translations

- `npm run language` - Make POT File
- Then follow this link to test
- [Check translation guide](https://developer.wordpress.org/block-editor/how-to-guides/internationalization/#provide-your-own-translations)
