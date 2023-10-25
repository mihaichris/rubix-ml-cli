<?php

use Illuminate\Support\Facades\File;

test('tokenize command with default comma delimiter will return ok', function () {
    $this->artisan(
        'tokenizer:whitespace',
        [
            'input-file' => 'tests\fixture\en-tokenize-whitespace-comma-delimiter.input',
            'output-file' => 'tests\output\test_tokenize_command_with_default_comma_delimiter_will_return_ok.output'
        ]
    )->assertOk();
});

test('tokenize command with whitespace delimiter will return ok', function () {
    $this->artisan(
        'tokenizer:whitespace',
        [
            'input-file' => 'tests\fixture\en-tokenize-whitespace-space-delimiter.input',
            'output-file' => 'tests\output\test_tokenize_command_with_whitespace_delimiter_will_return_ok.output',
            '--delimiter' => ' '
        ],
    )->assertOk();
});

test('tokenize files with comma delimiter', function () {
    $expected = File::get('tests\fixture\en-tokenize-whitespace-comma-delimiter.output');
    $actual = File::get('tests\output\test_tokenize_command_with_default_comma_delimiter_will_return_ok.output');
    expect($actual)->toBe($expected);
})->depends('tokenize command with default comma delimiter will return ok');

test('tokenize files with whitespace', function () {
    $expected = File::get('tests\fixture\en-tokenize-whitespace-space-delimiter.output');
    $actual = File::get('tests\output\test_tokenize_command_with_whitespace_delimiter_will_return_ok.output');
    expect($actual)->toBe($expected);
})->depends('tokenize command with whitespace delimiter will return ok');

test('tokenize without input file', function () {
    $this->expectExceptionMessage('Not enough arguments (missing: "input-file").');
    $this->artisan('tokenizer:whitespace', ['output-file' => 'tests\output\test_tokenize_command_with_default_comma_delimiter_will_return_ok.output']);
});

test('tokenize without output file', function () {
    $this->expectExceptionMessage('Not enough arguments (missing: "output-file").');
    $this->artisan('tokenizer:whitespace', ['input-file' => 'tests\fixture\en-tokenize-whitespace-comma-delimiter.input']);
});
