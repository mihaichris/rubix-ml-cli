<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class HousePricePredictorCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'train:house-price-predictor';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Housing Price Predictor';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
