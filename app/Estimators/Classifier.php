<?php

declare(strict_types=1);


namespace App\Estimators;


enum Classifier
{
    case KNearestNeighbors;
    case LogisticRegression;
}
