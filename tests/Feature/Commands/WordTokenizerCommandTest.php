<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class WordTokenizerCommandTest extends TestCase
{
    public function test_tokenize_word_command_will_return_ok()
    {
        //TODO: Cleanup files after each test
        $this->artisan(
            'tokenizer:word',
            [
                'input-file' => 'tests\fixture\en-tokenize-word.input',
                'output-file' => 'test_tokenize_word_files.output'
            ]
        )->assertOk();
    }

    /** @depends test_tokenize_word_command_will_return_ok */
    public function test_tokenize_word_files()
    {
        $expected = File::get('tests\fixture\en-tokenize-word.output');
        $actual = File::get('test_tokenize_word_files.output');
        $this->assertSame($expected, $actual);
    }

    public function test_tokenize_word_without_input_file()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "input-file").');
        $this->artisan('tokenizer:word', ['output-file' => 'test_tokenize_word_with_file.output']);
    }

    public function test_tokenize_word_without_output_file()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "output-file").');
        $this->artisan('tokenizer:word', ['input-file' => 'tests\fixture\en-tokenize-word.input']);
    }
}
