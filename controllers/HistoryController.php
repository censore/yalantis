<?php

namespace app\controllers;

class HistoryController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\History';

    public function actionIndex()
    {
        return null;
    }
}
