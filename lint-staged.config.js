module.exports = {
	'./src/*.scss': [ 'npm run lint:css' ],
	'./src/*.{js,ts,tsx}': [ 'npm run lint:js' ],
	'./includes/**/*.php': [ 'npm run lint:php' ],
	'./includes/*.php': [ 'npm run lint:php' ],
	'./*.md': [ 'npm run lint:md:docs' ],
	'./package.json': [ 'npm run lint:pkg-json' ],
};
