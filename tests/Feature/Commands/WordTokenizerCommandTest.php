<?php

use Illuminate\Support\Facades\File;

test('tokenize command will return ok', function () {
    $this->artisan(
        'tokenizer:word',
        [
            'input-file' => 'tests\fixture\en-tokenize-word.input',
            'output-file' => 'tests\output\test_tokenize_command_will_return_ok.output'
        ]
    )->assertOk();
});

test('tokenize files', function () {
    $expected = File::get('tests\fixture\en-tokenize-word.output');
    $actual = File::get('tests\output\test_tokenize_command_will_return_ok.output');
    expect($actual)->toBe($expected);
})->depends('tokenize command will return ok');

test('tokenize without input file', function () {
    $this->expectExceptionMessage('Not enough arguments (missing: "input-file").');
    $this->artisan('tokenizer:word', ['output-file' => 'test_tokenize_word_with_file.output']);
});

test('tokenize without output file', function () {
    $this->expectExceptionMessage('Not enough arguments (missing: "output-file").');
    $this->artisan('tokenizer:word', ['input-file' => 'tests\fixture\en-tokenize-word.input']);
});
