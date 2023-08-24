<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Tokenizers\Word;

final class WordTokenizerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'tokenizer:word
                            {input-file : Input file (required)}
                            {output-file : Output file (required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'The Word tokenizer uses a regular expression to tokenize the words in a blob of text.';

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
        $this->task('Tokenizing the text 🔨', function (): void {
            $word = new Word();
            $this->words = $word->tokenize($this->inputFileContent);
        }, 'Processing...');
        $this->task('Writing to the output file ✍️', function (): void {
            File::put($this->argument('output-file'), implode("\n", $this->words));
        });
    }
}
