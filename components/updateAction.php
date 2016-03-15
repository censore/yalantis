<?php
/**
 * Created by PhpStorm.
 * User: Grad
 * Date: 13.03.2016
 * Time: 16:03
 */

namespace app\components;

use app\models\Photo;
use Yii;
use yii\base\Model;
use yii\web\ServerErrorHttpException;
use yii\rest;
use yii\rest\Action;
use app\helpers\photoHelper;
use app\components\addHistory as logger;

class UpdateAction extends Action
{
    /**
     * @var string
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * @var string
     */
    public $viewAction = 'view';


    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run($id,$w,$h)
    {
        $items = func_get_args(); // if ActiveController can't get data from url
        $id = $items[0];
        $w = $items[1];
        $h = $items[2];

        /* @var $model ActiveRecord */
        $model = $this->findModel($id);
        /* @var $helper instanceof photoHelper */
        $helper = $this->startResize($model, $w, $h);
        $model->updated_at =  date("Y-m-d H:i:s");
        if($model->save())
            return $this->savePhoto($helper, $id);
        else
            return false;
    }

    /**
     * @param $model
     * @param $w
     * @param $h
     * @return photoHelper|null
     */
    public function startResize($model, $w, $h){
        $helper = photoHelper::init();
        $helper->h = ( $h <= 0 ? $model->h : $h ); // set new height or get default one
        $helper->w = ( $w <= 0 ? $model->w : $w ); // set new width or get default one
        $helper->setFileName( $model->file );
        $helper->resize(); // start resizing
        return $helper;
    }

    /**
     *
     * @param photoHelper $helper
     * @param integer $id
     * @return ActiveRecord
     */
    public function savePhoto(photoHelper $helper, $id){
        /* @var $photo ActiveRecord */
        $photo = new Photo();
        $photo->h = $helper->h;
        $photo->w = $helper->w;
        $photo->q = 100;
        $photo->path = $helper->savePath;
        $photo->file = $helper->fileName;
        $photo->created_at = $photo->updated_at = date("Y-m-d H:i:s");

        $photo->save();    // Save photo

        logger::init()->log($photo, $id); // Run logger

        return $photo;
    }
}
