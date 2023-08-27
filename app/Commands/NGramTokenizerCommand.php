<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Tokenizers\NGram;

class NGramTokenizerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'tokenizer:ngram
                            {input-file : Input file (required)}
                            {output-file : Output file (required)}
                            {--min=2}
                            {--max=2}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'N-grams are sequences of n-words of a given string. The N-gram tokenizer outputs tokens of contiguous words ranging from min to max number of words per token.';

    private string $inputFileContent;

    /** @var list<string> */
    private array $words = [];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->task('Reading the input file 📖', function (): void {
            $this->inputFileContent = File::get($this->argument('input-file'));
        });
        $this->task('Decomposing sentences 🔨', function (): void {
            $tokenizer = new NGram($this->argument('min'), $this->argument('max'));
            $this->words = $tokenizer->tokenize($this->inputFileContent);
        }, 'Processing...');

        $this->task('Writing to the output file ✍️', function (): void {
            File::put($this->argument('output-file'), implode("\n", $this->words));
        });
    }
}
