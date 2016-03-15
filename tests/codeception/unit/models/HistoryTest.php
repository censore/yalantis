<?php
/**
 * Created by PhpStorm.
 * User: Grad
 * Date: 14.03.2016
 * Time: 16:45
 */

use app\models\History;
use yii\faker;

$faker = \Faker\Factory::create();

try{
    $model = new History();
}catch (\yii\base\Exception $e){
    echo $e->getMessage();
}

$model_photo = $faker->randomDigit();
$model_hsize = $faker->randomDigit();
$model_wsize = $faker->randomDigit();
$model_quali = $faker->randomDigit();
$model_result = $faker->md5() . '.jpg';


$model->photo_id = $model_photo;
$model->hsize = $model_hsize;
$model->wsize = $model_wsize;
$model->quality = $model_quali;
$model->result = $model_photo;

if(!$model->save()){
    throw new \yii\base\Exception('Can`t save model data: '. $model->errors);
}

