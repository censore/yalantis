<?php
/**
 * Created by PhpStorm.
 * User: Grad
 * Date: 15.03.2016
 * Time: 11:52
 */

namespace app\components;

use Yii;

use yii\web\ServerErrorHttpException;
use yii\rest;
use yii\rest\Action;
use app\helpers\photoHelper;

class deleteAction extends Action{

    /**
     * Run deteting photo from model
     *
     * @param $id
     * @throws ServerErrorHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id){
        $model = $this->findModel($id);
        $result = photoHelper::init()
            ->setFileName($model->file)
            ->deletePhoto();
        if($result instanceof photoHelper){
            $result->setPhotoId($model->id)->clearHistory();
        }
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }
}