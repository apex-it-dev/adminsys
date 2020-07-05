'use strict';

const fs    =      require('fs');
const path  =      require('path');

const workingDir    =   'jstoobf';
const rawPath       =   'rawjsfiles';
const fileslash     =   (process.platform).includes('win') ? '\\' : '/';
const directoryPath =   path.join(__dirname, rawPath);

scanFiles(`${directoryPath}`);

function scanFiles(dirpath){
    const files = fs.readdirSync(dirpath);
    files.forEach(file => {
        const fileRawPath = `${dirpath}${fileslash}${file}`;
        if(fs.lstatSync(fileRawPath).isDirectory()) {
            scanFiles(fileRawPath); // recurse
        } else if(path.extname(file) === '.js') {
            convertJS(fileRawPath);
        }
    });
}


/**
 * @function convertJS converts the JS file, start by transpiling with babel then obfuscate with javascript-obfuscate
 * @param {string} fileRawPath String representation of the raw js files
 */
function convertJS(fileRawPath) {
    const fileSavePath = fileRawPath.replace(`${fileslash}${workingDir}${fileslash}${rawPath}`, '');
    const fileRawMdate = fs.statSync(fileRawPath).mtime;
    const fileOutMdate = fs.existsSync(fileSavePath) ? fs.statSync(fileSavePath).mtime : fileRawMdate-1;
    const hasChanges = fileRawMdate > fileOutMdate;
    const fileTranspiledPath = `${fileRawPath}.transpiled`;
    let isForced = false;

    if(process.argv.length > 2) {
        if(process.argv[2] == '-f') isForced = true;
    }

    if(hasChanges || isForced) {
        const process = async () => {
            try {
                const transpile = await transpileCode(fileRawPath, fileTranspiledPath);
                // console.log('\x1b[36m%s\x1b[0m',fileSavePath, ':    ', transpile);

                const obfuscate = await obfuscateCode(fileTranspiledPath, fileSavePath);

                const today = new Date();
                const getFormattedDate = `${today.getHours()}:${today.getMinutes()}:${today.getSeconds()}`;

                console.log('\x1b[36m%s\x1b[0m', `[${getFormattedDate}] => ${fileSavePath}`, ':    ', obfuscate);
            } catch(e){
                console.log('\x1b[31m%s\x1b[0m', fileSavePath, ':   ', e);
            }
            fs.unlinkSync(fileTranspiledPath);
        };
        process();
    // } else {
        // console.log('\x1b[35m%s\x1b[0m', fileSavePath, ':    [no changes]');
    }

}

/**
 * @function transpileCode Traspiles the code using bable 
 * @param {string} file_raw file location of the raw js
 * @param {string} file_save file location of the output transpiled js
 * @returns {Promise<string>} result, failed or success
*/
function transpileCode(file_raw, file_save) {
    const babel = require('@babel/core');
    
    return new Promise((resolve, reject) => {
        try {
            const code = fs.readFileSync(file_raw, 'UTF-8',);
            const transpiledResult = babel.transform(code, {
                minified: true,
                compact: true,
                comments: false,
                presets: [
                    [
                      '@babel/preset-env', {
                            targets: {
                                esmodules: true,
                            }
                      },
                    ],
                ],
                plugins: ['remove-use-strict'],
            }).code;
            const writeResult = fs.writeFileSync(file_save, transpiledResult); 
            resolve('[transpile success]');
        } catch(e) {
            reject('[transpile failed]    -   ' + e);
        }
    });
}

/**
 * @function obfuscateCode Obfuscate the code using javascript-obfuscator 
 * @param {string} file_raw file location of the raw js
 * @param {string} file_save file location of the output final js
 * @returns {Promise<string>} result, failed or success
*/
function obfuscateCode(file_raw, file_save){
    const JavaScriptObfuscator = require('javascript-obfuscator');

    let dir_save = file_save.split(fileslash);
    dir_save.pop();
    dir_save = dir_save.join(fileslash);
    
    return new Promise((resolve, reject) => {
        try {
            const code = fs.readFileSync(file_raw, 'UTF-8');
            const obfuscationResult = JavaScriptObfuscator.obfuscate(code).getObfuscatedCode();
            if(!fs.existsSync(dir_save)) fs.mkdirSync(dir_save,{ recursive: true });
            const writeResult = fs.writeFileSync(file_save, obfuscationResult);
            resolve('[obfuscate success]');
        } catch(e) {
            reject('[obfuscate failed]    -   ' + e);
        }
    });
}