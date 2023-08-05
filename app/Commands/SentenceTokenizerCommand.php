<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use Rubix\ML\Tokenizers\Sentence;
use LaravelZero\Framework\Commands\Command;

class SentenceTokenizerCommand extends Command
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
    protected $description = 'This tokenizer matches sentences starting with a letter and ending with a punctuation mark.';

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
