#!/usr/bin/env node
'use strict'
/**
 * External dependencies
 */
const fs = require('fs-extra')
const { stdout } = require('process')

/**
 * Internal dependencies
 */

const {
	hasPackageProp,
	getPackageProp,
	hasArgInCLI,
} = require('@wordpress/scripts/utils')

const {
	getChangelogFile,
} = require('./webpack-helpers')



const version = getPackageProp('version')

const changelogFile = getChangelogFile()

// 2. Read and find the changelog entry for the current version.
const changelog = fs.readFileSync(changelogFile, 'utf8')
const lines = changelog.split('\n')
const changelogEntry = []
let inSection = false
const versionString = `version ${version}`
const dateRegex = /^\d{4}-\d{2}-\d{2}/

for (const line of lines) {
	if (inSection) {
		if (dateRegex.test(line) && !line.includes(versionString)) {
			break
		}
		changelogEntry.push(line)
	} else if (line.includes(versionString)) {
		inSection = true
		// continue
		// changelogEntry.push(line)
	}
}

if (changelogEntry.length === 0) {
	changelogEntry.push(`- No changelog entry for version ${version}.\n\n`)
}

// 3. Prepare the final output string
const finalOutput = changelogEntry.join('\n').trim()

// 4. Check if running in GitHub Actions environment
/*if (process.env.GITHUB_OUTPUT) {
	// If yes, write to the GITHUB_OUTPUT file to set an output variable
	// The format `key<<DELIMITER` is used for multiline strings
	fs.appendFileSync(process.env.GITHUB_OUTPUT, `changelog_body<<EOF\n${finalOutput}\nEOF\n`)
} else {
	stdout.write(`${finalOutput}\n`)
}*/

stdout.write(`## What's Changed\n\n`)
stdout.write(`${finalOutput}\n`)


