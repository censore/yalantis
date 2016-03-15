<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property integer $photo_id
 * @property integer $hsize
 * @property integer $wsize
 * @property integer $quality
 * @property integer $colored
 * @property string $result
 *
 * @property Photo $photo
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo_id', 'hsize', 'wsize', 'quality', 'colored'], 'integer'],
            [['result'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo_id' => 'Photo ID',
            'hsize' => 'Hsize',
            'wsize' => 'Wsize',
            'quality' => 'Quality',
            'colored' => 'Colored',
            'result' => 'Result',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(Photo::className(), ['id' => 'photo_id']);
    }
}
