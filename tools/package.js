#!/usr/bin/env node
'use strict';
/**
 * External dependencies
 */
const AdmZip = require('adm-zip');
const { sync: glob } = require('fast-glob');
const { dirname } = require('path');
const { stdout } = require('process');
const fs = require('fs-extra');
/**
 * Internal dependencies
 */

const {
	hasPackageProp,
	getPackageProp,
	hasArgInCLI,
} = require('@wordpress/scripts/utils');

const npm_package_name = getPackageProp('name');
const npm_package_version = getPackageProp('version');

stdout.write(`Creating package for \`${npm_package_name}\` plugin... 🎁\n\n`);
const zip = new AdmZip();
const isZip = hasArgInCLI('--zip');

let files = [];

if (hasPackageProp('files')) {
	stdout.write(
		'Using the `files` field from `package.json` to detect files:\n\n'
	);

	files = glob(getPackageProp('files'), {
		caseSensitiveMatch: false,
	});
} else {
	stdout.write('Using Plugin Handbook best practices to discover files:\n\n');
	// See https://developer.wordpress.org/plugins/plugin-basics/best-practices/#file-organization.
	files = glob(
		[
			'admin/**',
			'build/**',
			'includes/**',
			'languages/**',
			'public/**',
			`${npm_package_name}.php`,
			'uninstall.php',
			'block.json',
			'changelog.*',
			'license.*',
			'readme.*',
		],
		{
			caseSensitiveMatch: false,
		}
	);
}

if (isZip) {
	stdout.write(
		`Creating archive for \`${npm_package_name}\` plugin... 🎁\n\n`
	);
	files.forEach((file) => {
		stdout.write(`  🥳 Adding \`${file}\`.\n`);
		const zipDirectory = dirname(file);
		zip.addLocalFile(file, zipDirectory !== '.' ? zipDirectory : '');
	});

	zip.writeZip(`./${npm_package_name}.zip`);
	stdout.write(`\nDone. \`${npm_package_name}.zip\` is ready! 🎉\n`);
} else {
	fs.remove(npm_package_name).then(() => {
		fs.ensureDir(npm_package_name, () => {
			stdout.write(
				`Creating directory for \`${npm_package_name}\` plugin... 🎁\n\n`
			);

			files.forEach((file) => {
				const to = `${npm_package_name}/${file}`;
				stdout.write(`  🥳 Adding \`${file}\`.\n`);
				fs.copy(file, to);
			});

			stdout.write(
				`\n\nDone. \`${npm_package_name}\` directory is ready! 🎉\n`
			);
		});
	});
}
