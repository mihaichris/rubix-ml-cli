<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use Rubix\ML\Tokenizers\Sentence;
use LaravelZero\Framework\Commands\Command;

final class SentenceTokenizerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'tokenizer:sentence
                            {input-file : Input file (required)}
                            {output-file : Output file (required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'This tokenizer matches sentences starting with a letter and ending with a punctuation mark.';

    private string $inputFileContent;

    /** @var list<string> */
    private array $sentences = [];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->task('Reading the input file 📖', function (): void {
            $this->inputFileContent = File::get($this->argument('input-file'));
        });
        $this->task('Decomposing sentences 🔨', function (): void {
            $sentence = new Sentence();
            $this->sentences = $sentence->tokenize($this->inputFileContent);
        }, 'Processing...');
        $this->task('Writing to the output file ✍️', function (): void {
            File::put($this->argument('output-file'), implode("\n", $this->sentences));
        });
    }
}
