<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\NDJSON;
use Rubix\ML\Loggers\Screen;

class IrisCommand extends Command
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
    public function handle()
    {
        $logger = new Screen();

        $logger->info('Loading data into memory');

        $training = Labeled::fromIterator(new NDJSON('tests\fixture\iris-dataset.ndjson'));

        $testing = $training->randomize()->take(10);

        $estimator = new KNearestNeighbors(5);

        $logger->info('Training');

        $estimator->train($training);

        $logger->info('Making predictions');

        $predictions = $estimator->predict($testing);

        $metric = new Accuracy();

        $score = $metric->score($predictions, $testing->labels());

        $logger->info("Accuracy is $score");
    }
}
