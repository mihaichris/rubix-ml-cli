<?php

declare(strict_types=1);

namespace App\Datasets;

use Rubix\ML\Datasets\Dataset;

class TrainingSplitter
{
    /**
     * @return array{Dataset, Dataset}
     * */
    public function trainTestSplit(Dataset $dataset, float $ratio = 0.5, bool $randomize = false): array
    {
        if ($randomize) {
            $dataset = $dataset->randomize();
        }
        return $dataset->split($ratio);
    }
}
