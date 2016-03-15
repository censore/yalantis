<?php
/**
 * Created by PhpStorm.
 * User: Grad
 * Date: 14.03.2016
 * Time: 1:29
 */

namespace app\components;

use app\models\History;
class addHistory {
    private static $instance;
    public static function init(){
        if(self::$instance === null) self::$instance = new self();

        return self::$instance;
    }

    public function log($model, $id = null){

        $history = new History();

        $history->photo_id = ( $id === null? $model->id : $id );
        $history->hsize = $model->h;
        $history->wsize = $model->w;
        $history->quality = $model->q;
        $history->result = $model->file;

        return $history->save();
    }
}