# Marquee Block

![Marquee Block](https://raw.githubusercontent.com/EmranAhmed/marquee-block/master/.wp-org/assets/banner-1544x500.png)
[![Active Installs](https://img.shields.io/wordpress/plugin/installs/marquee-block?logo=wordpress&logoColor=%23fff&label=Active%20Installs&labelColor=%2323282D&color=%2323282D)](https://wordpress.org/plugins/marquee-block/)
[![Playground Demo Link](https://img.shields.io/wordpress/plugin/v/marquee-block?logo=wordpress&logoColor=%23fff&label=Playground%20Demo&labelColor=%233858e9&color=%233858e9)](https://playground.wordpress.net/?mode=seamless&blueprint-url=https://raw.githubusercontent.com/EmranAhmed/marquee-block/master/.wp-playground/blueprint-github.json)

[Marquee Block](https://wordpress.org/plugins/marquee-block/) adds a touch of movement and interactivity to your site and help to capture attention and engage your site visitors in a unique way. 

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
