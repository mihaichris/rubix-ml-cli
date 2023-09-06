<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Tokenizers\KSkipNGram;

final class KSkipNGramTokenizerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'tokenizer:nskipgram
                            {input-file : Input file (required)}
                            {output-file : Output file (required)}
                            {--min=2}
                            {--max=2}
                            {--skip=2}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'K-skip-n-grams are a technique similar to n-grams, whereby n-grams are formed but in addition to allowing adjacent sequences of words, the next k words will be skipped forming n-grams of the new forward looking sequences. The tokenizer outputs tokens ranging from min to max number of words per token.';

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
            $kSkipNGram = new KSkipNGram((int)$this->option('min'), (int)$this->option('max'), (int)$this->option('skip'));
            $this->words = $kSkipNGram->tokenize($this->inputFileContent);
        }, 'Processing...');
        $this->task('Writing to the output file ✍️', function (): void {
            File::put($this->argument('output-file'), implode("\n", $this->words));
        });
    }
}
