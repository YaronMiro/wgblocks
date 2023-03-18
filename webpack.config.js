const autoprefixer = require('autoprefixer');
const MiniCSSExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const webpack = require('webpack');
const path = require('path');
const glob = require('glob');
const dotenv = require('dotenv')
const dotenvExpand = require('dotenv-expand');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const colors = require('colors');
const shell = require('shelljs');

// Environment variables from file ".env" => will push them into "process.env".
let envConfig = dotenv.config({ path: path.resolve(__dirname, './.env')});
dotenvExpand(envConfig);

// Get all Blocks Config Files path.
const CURRENT_DIRECTORY_PATH = path.resolve(__dirname);
const BLOCKS_DIR = `${CURRENT_DIRECTORY_PATH}/blocks`;
const CONFIG_FILE_NAME = 'block.webpack.config.js';
const BLOCKS_CONFIGS = glob.sync(`${BLOCKS_DIR}/*/${CONFIG_FILE_NAME}`);
const BUILD_EXIT_MESSAGE = 'Build process exited, since no blocks config were found!, create a block and try again :)'.brightCyan;
let configObjects = [];


// Exit early in case we have no "Blocks" configs file.
if (!BLOCKS_CONFIGS.length) {
	shell.echo(`
-------------------------------------------------------------------------------------------

${BUILD_EXIT_MESSAGE}

-------------------------------------------------------------------------------------------
	`);

	return process.exit(0);
}

module.exports = (env, argv) => {

	function isDevelopment() {
		return process.env.ENVIRONMENT_TYPE === 'development';
	}

	const config = {
		mode: isDevelopment() ? 'development' : 'production',
		optimization: {
			minimizer: [
				new TerserPlugin({
					sourceMap: true
				}),
				new OptimizeCSSAssetsPlugin(
				{
					cssProcessorOptions: {
						map: {
							inline: false,
							annotation: true
						}
					}
				})
			]
		},
		plugins: [
			new DependencyExtractionWebpackPlugin({ injectPolyfill: true }),
			new webpack.DefinePlugin({
				'process.env.ENVIRONMENT_TYPE': JSON.stringify(process.env.ENVIRONMENT_TYPE)
			}),
			new MiniCSSExtractPlugin({
				chunkFilename: "[id].css",
				filename: chunkData => {
					return chunkData.chunk.name === 'script' ? 'style.css' : '[name].css'
				}
			})
		],
		devtool: isDevelopment() ? 'cheap-module-source-map' : 'source-map',
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /node_modules/,
					use: [
						{
							loader: 'babel-loader',
							options: {
								presets: [
									'@babel/preset-env',
									[
										'@babel/preset-react',
										{
											"pragma": "wp.element.createElement",
											"pragmaFrag": "wp.element.Fragment",
											"development": isDevelopment()
										}
									]
								]
							}
						},
						'eslint-loader'
					]
				},
				{
					test: /\.(sa|sc|c)ss$/,
					use: [
						MiniCSSExtractPlugin.loader,
						'css-loader',
						{
							loader: 'postcss-loader',
							options: {
								plugins: [
									autoprefixer()
								]
							}
						},
						'sass-loader'
					]
				},
			]
		},
		// 	externals are created programmatically to load WordPress dependencies.
		// 	In case there is need to manually add an external deceleration, Then validated that
		//  there is no conflict with the automated externals created by:
		// 	@see @wordpress/dependency-extraction-webpack-plugin.
		resolve: {
			alias: {
				"@Components": `${CURRENT_DIRECTORY_PATH}/common/components/`,
				"@Hooks": `${CURRENT_DIRECTORY_PATH}/common/hooks/`,
			}
		}
	};

	// Build config data.
	BLOCKS_CONFIGS.map(filePath => {
		configObjects.push({ ...config, ...require(filePath) });
	});

	return configObjects;

}
