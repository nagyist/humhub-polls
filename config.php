<?php

use humhub\modules\user\models\User;
use humhub\commands\IntegrityController;
use humhub\modules\content\widgets\WallEntryControls;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'polls',
    'class' => 'humhub\modules\polls\Module',
    'namespace' => 'humhub\modules\polls',
    'events' => [
        ['class' => WallEntryControls::class, 'event' => WallEntryControls::EVENT_INIT, 'callback' => ['humhub\modules\polls\Events', 'onWallEntryControlsInit']],
        ['class' => User::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\polls\Events', 'onUserDelete']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => ['humhub\modules\polls\Events', 'onIntegrityCheck']],
        ['class' => 'humhub\modules\installer\controllers\ConfigController', 'event' => 'install_sample_data', 'callback' => ['humhub\modules\polls\Events', 'onSampleDataInstall']],
        ['class' => 'humhub\modules\rest\Module', 'event' => 'restApiAddRules', 'callback' => ['humhub\modules\polls\Events', 'onRestApiAddRules']],
    ],
];
