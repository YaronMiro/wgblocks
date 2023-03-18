
const path = require('path');
const shell = require('shelljs');
const colors = require('colors');

// The blocks directory path.
const BLOCKS_DIRECTORY_PATH = path.resolve(__dirname, '../blocks');

// THE Example "Block" replacement texts.
const EXAMPLE_BLOCK_DIRECTORY_NAMESAPCE = 'ExampleBlock';
const EXAMPLE_BLOCK_NAME = 'example-block';
const EXAMPLE_BLOCK_TITLE = 'Example Block';

// The Example block git repo path.
const EXAMPLE_BLOCK_REPO_SSH_PATH = 'git@bitbucket.org:webpals/gutenberg-example-block.git';

const CABABCASE_REGEX_PATTERN = '^[a-z](?:[a-z]\-?)*[a-z]$';
const regex = new RegExp(CABABCASE_REGEX_PATTERN);


// Helper function to convert a "string" in the format of kabab-case into PascalCase format.
function kababCaseToPascalCase(str) {

	function clearAndUpper(text) {
		return text.replace(/-/, "").toUpperCase();
	}

	let cloneStr = str;

	return cloneStr.replace(/(^\w|-\w)/g, clearAndUpper);
}

// Helper function to convert "string" in the format of kabab-case into capitalize Words format.
function kababCaseToCapitalizeWords(str) {

	let cloneStr = str.replace(/-/, " ");

	return cloneStr.replace(/\w\S*/g, function (txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); });
}

// The final message to acknowledge asset build process.
function displaySuccessMessage(){

	const dev = `\`npm run start\``.brightCyan;
	const prod = '\`npm run build\`'.brightMagenta;

	shell.echo(`

--------------------------------------------------------------------------------------------------------------------

You need to generate the "${NEW_BLOCK_NAME}" block assets, by running either of the following commands:

Development mode: ${dev}

Production mode: ${prod}

--------------------------------------------------------------------------------------------------------------------
	`);
}

// Get the new block name from the arguments.
const [, , NEW_BLOCK_NAME] = process.argv;

//  Validate block name.
if (!regex.test(NEW_BLOCK_NAME) || typeof NEW_BLOCK_NAME === 'undefined') {

	const validName = 'my-block'.brightGreen;
	const blockName = NEW_BLOCK_NAME.brightRed;

	shell.echo(`
--------------------------------------------------------------------------------------------------------------------

Block name ${blockName} is in valid.

Block name must be in the format of kabab-case e.g. ${validName}

--------------------------------------------------------------------------------------------------------------------
	`);
	shell.exit(0);
}


// The new block directory path.
const BLOCK_DIRECTORY_NAME = kababCaseToPascalCase(NEW_BLOCK_NAME);
const NEW_BLOCK_DIRECTORY_PATH = `${BLOCKS_DIRECTORY_PATH}/${BLOCK_DIRECTORY_NAME}`;

// Navigate to the blocks directory.
shell.cd(`${BLOCKS_DIRECTORY_PATH}`);

// Clone the repo under the blocks directory.
shell.exec(`git clone ${EXAMPLE_BLOCK_REPO_SSH_PATH} ${NEW_BLOCK_DIRECTORY_PATH}`, (code, output) => {

	// bale early in case of an error.
	if (code) {
		shell.exit(0);
	}

	// Navigate & validate that we are inside the new block directory.
	const codeError = shell.cd(`${NEW_BLOCK_DIRECTORY_PATH}`).code;
	if (codeError) {
		shell.exit(0);
	}

	// Delete the internal ".git" directory.
	shell.rm('-rf', '.git');

	// Alter the "namespace" of the Block::class.
	shell.sed('-i', EXAMPLE_BLOCK_DIRECTORY_NAMESAPCE, BLOCK_DIRECTORY_NAME, `Block.php`);

	// Alter the block "names" on the "registerBlockType()" function.
	shell.sed('-i', EXAMPLE_BLOCK_NAME, NEW_BLOCK_NAME, `editor.js`);

	// Alter the block "title" on the "registerBlockType()" function.
	shell.sed('-i', EXAMPLE_BLOCK_TITLE, kababCaseToCapitalizeWords(NEW_BLOCK_NAME), `editor.js`);

	// Echo the final message
	displaySuccessMessage();

})
