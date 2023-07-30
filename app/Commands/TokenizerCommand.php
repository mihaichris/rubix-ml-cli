<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use Rubix\ML\Tokenizers\Sentence;
use LaravelZero\Framework\Commands\Command;

use function Termwind\render;

class TokenizerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'tokenizer:sentence {file : The file path (required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'The Rubix ML Tokenizers segment an input character sequence into tokens. Tokens are usually words, punctuation, numbers, etc.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $file = File::get($this->argument('file'));
        $estimator = new Sentence();
        $this->line(implode("\n", $estimator->tokenize($file)));
    }
}
