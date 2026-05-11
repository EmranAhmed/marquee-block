#!/usr/bin/env node
/* eslint-disable no-console */
/**
 * External dependencies
 */
const fs = require('fs')
const spawn = require('cross-spawn')

/**
 * Internal dependencies
 */
const {
		  getArgFromCLI,
	  } = require('@wordpress/scripts/utils')

/**
 * Constants
 */

const PACKAGES_PREFIX = ['@storepress/']

function readJSONFile (fileName) {
	const data = fs.readFileSync(fileName, 'utf8')
	return JSON.parse(data)
}

function getStorePressPackages ({ dependencies = {}, devDependencies = {} }) {
	return Object.keys(dependencies).concat(Object.keys(devDependencies)).filter((packageName) => {
		return PACKAGES_PREFIX.some((prefix) => packageName.startsWith(prefix))
	})
}

function getPackageVersionDiff (initialPackageJSON, finalPackageJSON) {
	const diff = ['dependencies', 'devDependencies'].reduce(
		(result, keyPackageJSON) => {
			return Object.keys(
				finalPackageJSON[keyPackageJSON] || {},
			).reduce((_result, dependency) => {
				const initial =
						  initialPackageJSON[keyPackageJSON][dependency]
				const final = finalPackageJSON[keyPackageJSON][dependency]
				if (initial !== final) {
					_result.push({ dependency, initial, final })
				}
				return _result
			}, result)
		},
		[],
	)
	return diff.sort((a, b) => a.dependency.localeCompare(b.dependency))
}

function updatePackagesToLatestVersion (packages) {
	const distTag = getArgFromCLI('--dist-tag') || 'latest'

	const packagesWithLatest = packages.map(
		(packageName) => `${packageName}@${distTag}`,
	)

	return spawn.sync('npm', ['install', ...packagesWithLatest, '--save'], {
		stdio: 'inherit',
	})
}

function outputPackageDiffReport (packageDiff) {
	console.log(
		[
			'The following package versions were changed:',
			...packageDiff.map(({ dependency, initial, final }) => {
				return `${dependency}: ${initial} -> ${final}`
			}),
		].join('\n'),
	)
}

function updatePackageJSON () {
	const initialPackageJSON = readJSONFile('package.json')
	const packages = getStorePressPackages(initialPackageJSON)

	const result = updatePackagesToLatestVersion(packages)

	const finalPackageJSON = readJSONFile('package.json')
	outputPackageDiffReport(
		getPackageVersionDiff(initialPackageJSON, finalPackageJSON),
	)
	process.exit(result.status)
}

updatePackageJSON()
/* eslint-enable no-console */
