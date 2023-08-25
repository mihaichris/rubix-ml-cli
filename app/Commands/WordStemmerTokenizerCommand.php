<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Tokenizers\WordStemmer;

final class WordStemmerTokenizerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'tokenizer:stemming
                            {input-file : Input file (required)}
                            {output-file : Output file (required)}
                            {--language=english}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Word Stemmer reduces inflected and derived words to their root form using the Snowball method. For example, the sentence "Majority voting is likely foolish" stems to "Major vote is like foolish."';

    private string $inputFileContent;

    /** @var list<string> */
    private array $words = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->task('Reading the input file 📖', function (): void {
            $this->inputFileContent = File::get($this->argument('input-file'));
        });
        $this->task('Stemming the text 🔨', function (): void {
            $word = new WordStemmer($this->option('language'));
            $this->words = $word->tokenize($this->inputFileContent);
        }, 'Processing...');
        $this->task('Writing to the output file ✍️', function (): void {
            File::put($this->argument('output-file'), implode("\n", $this->words));
        });
    }
}
