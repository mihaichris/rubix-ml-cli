<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TokenizerCommandTest extends TestCase
{
    public function test_tokenize_sentence_with_file()
    {
        $this->artisan('tokenizer:sentence', ['file' => 'tests\fixture\en-tokenize-sentence.test'])
            ->expectsOutput(File::get('tests\fixture\en-tokenize-sentence.output'));
    }

    public function test_tokenize_sentence_with_no_file()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "file").');
        $this->artisan('tokenizer:sentence');
    }
}
