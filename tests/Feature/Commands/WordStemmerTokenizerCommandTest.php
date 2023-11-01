<?php

use Illuminate\Support\Facades\File;

test('tokenize command will return ok', function () {
    $this->artisan(
        'tokenizer:stemming',
        [
            'input-file' => 'tests\fixture\en-tokenize-stemming.input',
            'output-file' => 'tests\output\test_tokenize_command_will_return_ok.output'
        ]
    )->assertOk();
});

test('tokenize files', function () {
    $expected = File::get('tests\fixture\en-tokenize-stemming.output');
    $actual = File::get('tests\output\test_tokenize_command_will_return_ok.output');
    expect($actual)->toBe($expected);
})->depends('tokenize command will return ok');

test('tokenize without input file', function () {
    $this->expectExceptionMessage('Not enough arguments (missing: "input-file").');
    $this->artisan('tokenizer:stemming', ['output-file' => 'tests\output\en-tokenize-stemming.input']);
});

test('tokenize without output file', function () {
    $this->expectExceptionMessage('Not enough arguments (missing: "output-file").');
    $this->artisan('tokenizer:stemming', ['input-file' => 'tests\fixture\en-tokenize-stemming.input']);
});
