<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SentenceTokenizerCommandTest extends TestCase
{
    public function test_tokenize_sentence_with_file()
    {
        $this->artisan('tokenizer:sentence', ['input-file' => 'tests\fixture\en-tokenize-sentence.test'])
            ->expectsOutput(File::get('tests\fixture\en-tokenize-sentence.output'));
    }

    public function test_tokenize_sentence_without_input_file()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "input-file").');
        $this->artisan('tokenizer:sentence');
    }

    public function test_tokenize_sentence_without_output_file()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "output-file").');
        $this->artisan('tokenizer:sentence');
    }
}
