<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;

class PhotoController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'app\models\Photo';

    /**
     *
     * Переопределяем родительский метод, чтоб можно было юзать свои экшены
     *
     * @return array
     */
    public function actions(){
        $actions = parent::actions();

        $actions['create']=[
            'class' => 'app\components\createAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];

        $actions['update']=[
            'class' => 'app\components\updateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];
        $actions['delete']=[
            'class' => 'app\components\deleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

}
