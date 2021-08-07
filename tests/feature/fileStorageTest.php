<?php

use Khalyomede\Monad\Option;

function getFileContent(string $filePath): Option
{
    $content = file_get_contents($filePath);

    return false === $content ? Option::none() : Option::some($content);
}

test(
    'should store the file',
    function () {
        $filePath = tempnam(sys_get_temp_dir(), 'file');
        $expected = 'foo';

        if (false === $filePath) {
            throw new Exception('Could not create temp file.');
        }

        file_put_contents($filePath, $expected);

        $actual = getFileContent($filePath)->then(fn ($content) => $content)->catch(fn () => '');

        expect($actual)->toBe($expected);
    }
);
