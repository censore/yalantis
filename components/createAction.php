<?php
/**
 * Created by PhpStorm.
 * User: Grad
 * Date: 13.03.2016
 * Time: 16:03
 */

namespace app\components;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\rest;
use yii\rest\Action;
use app\helpers\photoHelper;
use app\components\addHistory as logger;

/**
 * CreateAction implements the API endpoint for creating a new model from the given data.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreateAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;
    /**
     * @var string the name of the view action. This property is need to create the URL when the model is successfully created.
     */
    public $viewAction = 'view';


    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);
        // We can use YII methods for saving uploaded image but i want standart methods. See photoHelper
        if (Yii::$app->request->isPost) {
            $photo = photoHelper::init();
            if(!$photo->upload()){
                return fasle;
            }

            $model->user_id = 0;
            $model->path = $photo->savePath;
            $model->file = $photo->webPath;
            $model->h = $photo->h;
            $model->w = $photo->w;
            $model->q = 100;
            $model->created_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                logger::init()->log($model);
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', array_values($model->getPrimaryKey(true)));
                $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }

        return $model;
    }
}
