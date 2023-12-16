<?php

declare(strict_types=1);

namespace App\Persisters;

use Rubix\ML\Learner;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Serializers\RBX;

final class ModelPersister
{
    public function persist(Learner $learner): void
    {
        $persistentModel = new PersistentModel($learner, new Filesystem('model.rbx'), new RBX());
        $persistentModel->save();
    }
}
