<?php

declare(strict_types=1);

namespace App\Persisters;

use Rubix\ML\Learner;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Persister;
use Rubix\ML\Serializers\Serializer;

class ModelLoader
{
    public function load(Persister $persister, ?Serializer $serializer = null): Learner
    {
        return PersistentModel::load($persister, $serializer);
    }
}
