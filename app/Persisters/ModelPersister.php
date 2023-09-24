<?php

declare(strict_types=1);

namespace App\Persisters;

use Rubix\ML\Learner;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Serializers\RBX;

class ModelPersister
{
    public function persist(Learner $model): void
    {
        $estimator = new PersistentModel($model, new Filesystem('model.rbx'), new RBX());
        $estimator->save();
    }
}
