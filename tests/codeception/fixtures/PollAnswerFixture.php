<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace tests\codeception\fixtures;

use humhub\modules\polls\models\PollAnswer;
use yii\test\ActiveFixture;

class PollAnswerFixture extends ActiveFixture
{
    public $modelClass = PollAnswer::class;
    public $dataFile = '@polls/tests/codeception/fixtures/data/pollAnswer.php';

}
