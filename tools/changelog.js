#!/usr/bin/env node
'use strict';
/**
 * External dependencies
 */
const fs = require( 'fs' );

/**
 * WordPress dependencies
 */
const {
	getPackageProp,
	fromProjectRoot,
} = require( '@wordpress/scripts/utils' );

// Get Current Version.
const version = getPackageProp( 'version' );

// Get Changelog File.
const changelogFile = fromProjectRoot( 'changelog.txt' );

// Read and find the changelog entry for the current version.
const changelogContent = fs.readFileSync( changelogFile, 'utf8' );
const lines = changelogContent.split( '\n' );
const changelogEntry = [];
let inSection = false;

const commonPattern = `^\\d{4}-\\d{2}-\\d{2}|^\\d{2}-\\d{2}-\\d{4}\\s*-\\s*version`;
const currentPattern = `${ commonPattern }\\s*${ version }`;

const currentExp = new RegExp( currentPattern, 'i' );

const sectionExp = new RegExp( commonPattern, 'i' );

for ( const line of lines ) {
	// Reach current section.
	if ( currentExp.test( line ) ) {
		inSection = true;
		continue;
	}

	// We have to stop when we get another section.
	if ( inSection ) {
		if ( sectionExp.test( line ) ) {
			inSection = false;
			break;
		}

		changelogEntry.push( line );
	}
}

if ( changelogEntry.length === 0 ) {
	changelogEntry.push( `- No changelog entry for version ${ version }.\n\n` );
}

// Prepare the final output string
const finalOutput = changelogEntry.join( '\n' ).trim();

process.stdout.write( `## What's Changed\n\n` );
process.stdout.write( `${ finalOutput }\n` );
