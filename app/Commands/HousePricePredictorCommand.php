<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Loggers\Screen;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Regressors\GradientBoost;
use Rubix\ML\Regressors\RegressionTree;
use Rubix\ML\Transformers\MissingDataImputer;
use Rubix\ML\Transformers\NumericStringConverter;

use function Laravel\Prompts\confirm;

final class HousePricePredictorCommand extends Command
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
        $logger = new Screen();
        $extractor = new ColumnPicker(new CSV('tests\fixture\house-price-labeled.csv', true), [
            'MSSubClass', 'MSZoning', 'LotFrontage', 'LotArea', 'Street', 'Alley',
            'LotShape', 'LandContour', 'Utilities', 'LotConfig', 'LandSlope',
            'Neighborhood', 'Condition1', 'Condition2', 'BldgType', 'HouseStyle',
            'OverallQual', 'OverallCond', 'YearBuilt', 'YearRemodAdd', 'RoofStyle',
            'RoofMatl', 'Exterior1st', 'Exterior2nd', 'MasVnrType', 'MasVnrArea',
            'ExterQual', 'ExterCond', 'Foundation', 'BsmtQual', 'BsmtCond',
            'BsmtExposure', 'BsmtFinType1', 'BsmtFinSF1', 'BsmtFinType2', 'BsmtFinSF2',
            'BsmtUnfSF', 'TotalBsmtSF', 'Heating', 'HeatingQC', 'CentralAir',
            'Electrical', '1stFlrSF', '2ndFlrSF', 'LowQualFinSF', 'GrLivArea',
            'BsmtFullBath', 'BsmtHalfBath', 'FullBath', 'HalfBath', 'BedroomAbvGr',
            'KitchenAbvGr', 'KitchenQual', 'TotRmsAbvGrd', 'Functional', 'Fireplaces',
            'FireplaceQu', 'GarageType', 'GarageYrBlt', 'GarageFinish', 'GarageCars',
            'GarageArea', 'GarageQual', 'GarageCond', 'PavedDrive', 'WoodDeckSF',
            'OpenPorchSF', 'EnclosedPorch', '3SsnPorch', 'ScreenPorch', 'PoolArea',
            'PoolQC', 'Fence', 'MiscFeature', 'MiscVal', 'MoSold', 'YrSold',
            'SaleType', 'SaleCondition', 'SalePrice',
        ]);

        $dataset = Labeled::fromIterator($extractor);

        $dataset->apply(new NumericStringConverter())
            ->apply(new MissingDataImputer())
            ->transformLabels('intval');

        $estimator = new PersistentModel(
            new GradientBoost(new RegressionTree(4), 0.1),
            new Filesystem('housing.rbx', true)
        );

        $estimator->setLogger($logger);

        $estimator->train($dataset);

        $extractor = new CSV('progress.csv', true);

        $extractor->export($estimator->steps());

        $logger->info('Progress saved to progress.csv');

        if (confirm("Save this model?", default: false)) {
            $estimator->save();
        }
    }
}
