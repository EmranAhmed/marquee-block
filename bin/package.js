#!/usr/bin/env node
'use strict';
/**
 * External dependencies
 */
const AdmZip = require( 'adm-zip' );
const { sync: glob } = require( 'fast-glob' );
const { sync: packlist } = require( 'npm-packlist' );
const { stdout } = require( 'process' );
const fs = require( 'fs-extra' );

/**
 * Internal dependencies
 */
const {
	hasPackageProp,
	getPackageProp,
	hasArgInCLI,
} = require( '@wordpress/scripts/utils' );
const { dirname } = require( 'path' );

const zip = new AdmZip();
const name = getPackageProp( 'name' );

let files = [];
if ( hasPackageProp( 'files' ) ) {
	stdout.write(
		'Using the `files` field from `package.json` to detect files:\n\n'
	);
	files = packlist();
} else {
	stdout.write(
		'Using Plugin Handbook best practices to discover files:\n\n'
	);
	// See https://developer.wordpress.org/plugins/plugin-basics/best-practices/#file-organization.
	files = glob(
		[
			'vendor/**',
			'admin/**',
			'build/**',
			'assets/**',
			'images/**',
			'includes/**',
			'templates/**',
			'languages/**',
			'public/**',
			`${ name }.php`,
			'uninstall.php',
			'block.json',
			'changelog.*',
			'license.*',
			'readme.txt',
		],
		{
			caseSensitiveMatch: false,
		}
	);
}

const isZip = hasArgInCLI( '--zip' );

if ( isZip ) {
	stdout.write( `Creating archive for \`${ name }\` plugin... 🎁\n\n` );
	files.forEach( ( file ) => {
		stdout.write( `  🥳 Adding \`${ file }\`.\n` );
		const zipDirectory = dirname( file );
		zip.addLocalFile( file, zipDirectory !== '.' ? zipDirectory : '' );
	} );

	zip.writeZip( `./${ name }.zip` );
	stdout.write( `\nDone. \`${ name }.zip\` is ready! 🎉\n` );
} else {
	fs.remove( name ).then( () => {
		fs.ensureDir( name, () => {
			stdout.write(
				`Creating directory for \`${ name }\` plugin... 🎁\n\n`
			);

			files.forEach( ( file ) => {
				const to = `${ name }/${ file }`;
				stdout.write( `  🥳 Adding \`${ file }\`.\n` );
				fs.copy( file, to );
			} );

			stdout.write( `\n\nDone. \`${ name }\` directory is ready! 🎉\n` );
		} );
	} );
}
