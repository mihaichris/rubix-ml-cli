<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Tokenizers\Whitespace;

final class WhitespaceTokenizerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'tokenizer:whitespace
                            {input-file : Input file (required)}
                            {output-file : Output file (required)}
                            {--delimiter=,}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Tokens are delimited by a user-specified whitespace character.';

    private string $inputFileContent;

    /** @var list<string> */
    private array $words = [];

    /**
     * Execute the console command.
     *
     */
    public function handle(): void
    {
        $delimiter = $this->option('delimiter');
        $this->task('Reading the input file 📖', function (): void {
            $this->inputFileContent = File::get($this->argument('input-file'));
        });
        $this->task(sprintf('Splitting words by \'%s\' 🔨', $delimiter), function (): void {
            $whitespace = new Whitespace((string)$this->option('delimiter'));
            $this->words = $whitespace->tokenize($this->inputFileContent);
        }, 'Processing...');
        $this->task('Writing to the output file ✍️', function (): void {
            File::put($this->argument('output-file'), implode("\n", $this->words));
        });
    }
}
