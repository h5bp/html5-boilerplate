import gulp from 'gulp';
import path from 'path';
import fs from 'fs';
import glob from 'glob';
import archiver from 'archiver';
import runSequence from 'run-sequence';

import pkg from '../package.json';
const dirs = pkg['h5bp-configs'].directories;

gulp.task('archive:create_archive_dir', () => {
    fs.mkdirSync(path.resolve(`../${dirs.archive}`), '0755');
});

gulp.task('archive:zip', (done) => {

    const archiveName = path.resolve(`../${dirs.archive}`, `${pkg.name}_v${pkg.version}.zip`);
    const zip = archiver('zip');
    const files = glob.sync('**/*.*', {
        'cwd': `${dirs.dist}`,
        'dot': true // include hidden files
    });
    const output = fs.createWriteStream(archiveName);

    zip.on('error', (error) => {
        done();
        throw error;
    });

    output.on('close', done);

    files.forEach( (file) => {

        const filePath = path.resolve(`${dirs.dist}`, file);

        // `zip.bulk` does not maintain the file
        // permissions, so we need to add files individually
        zip.append(fs.createReadStream(filePath), {
            'name': file,
            'mode': fs.statSync(filePath).mode
        });

    });

    zip.pipe(output);
    zip.finalize();
});

gulp.task('archive', (done) => {
    runSequence(
        'build',
        'archive:create_archive_dir',
        'archive:zip',
    done)
});
