<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\NDJSON;
use Rubix\ML\Loggers\Screen;

final class IrisCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'train:iris';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Iris train command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $screen = new Screen();

        $screen->info('Loading data into memory');

        $labeled = Labeled::fromIterator(new NDJSON('tests\fixture\iris-dataset.ndjson'));

        $testing = $labeled->randomize()->take(10);

        $kNearestNeighbors = new KNearestNeighbors(5);

        $screen->info('Training');

        $kNearestNeighbors->train($labeled);

        $screen->info('Making predictions');

        $predictions = $kNearestNeighbors->predict($testing);

        $accuracy = new Accuracy();

        $score = $accuracy->score($predictions, $testing->labels());

        $screen->info(sprintf('Accuracy is %s', $score));
    }
}
