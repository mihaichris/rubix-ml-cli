<?php

namespace App\Commands;

use App\Datasets\TrainingSplitter;
use App\Persisters\ModelPersister;
use LaravelZero\Framework\Commands\Command;
use ReflectionClass;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\NumericStringConverter;

use function Laravel\Prompts\confirm;
use function Termwind\render;

final class TrainKNearestNeighborsCommand extends Command
{
    protected $signature = 'train:KNearestNeighbors
                            {dataset : Dataset file as CSV (required)}
                            {--k=5 : k The number of nearest neighbors to consider when making a prediction. (optional)}
                            {--weighted=false : Should we consider the distances of our nearest neighbors when making predictions? (optional)}
                            {--kernel=Euclidean : The distance kernel used to compute the distance between sample points. (optional)}';

    protected $description = 'A brute-force distance-based learning algorithm that locates the k nearest samples from the training set and predicts the class label that is most common. K Nearest Neighbors (KNN) is considered a lazy learner because it performs most of its computation at inference time.';

    public function handle(TrainingSplitter $trainingSplitter, ModelPersister $modelPersister): void
    {
        $labeled = Labeled::fromIterator(new CSV($this->argument('dataset'), true));
        [$training, $testing] = $trainingSplitter->trainTestSplit($labeled, 0.8);
        $training->apply(new NumericStringConverter());
        $testing->apply(new NumericStringConverter());
        $kernel = (new ReflectionClass('Rubix\ML\Kernels\Distance' . '\\' . $this->option('kernel')))->newInstance();
        $kNearestNeighbors = new KNearestNeighbors($this->option('k'), $this->option('weighted'), $kernel);
        $kNearestNeighbors->train($training);

        $predictions = $kNearestNeighbors->predict($testing);
        $accuracy = new Accuracy();
        $accuracyScore = $accuracy->score($predictions, $testing->labels());

        render(<<<HTML
            <div>
                <div class="px-1 bg-green-600">Metrics results</div>
                <em class="ml-1">Accuracy is {$accuracyScore}</em>
            </div>
        HTML);

        $confirmSaveModel = confirm(label: "Save model?", default: false, yes: "Yes", no: "No");
        if ($confirmSaveModel) {
            $modelPersister->persist($kNearestNeighbors);
        }
    }
}
