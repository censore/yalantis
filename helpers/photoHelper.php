<?php
/**
 * Created by PhpStorm.
 * User: Grad
 * Date: 13.03.2016
 * Time: 14:29
 */

namespace app\helpers;

use app\models\History;
use Imagine\GD\Imagine;
use Yii;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;


/**
 * Class photoHelper
 * @package app\helpers
 */


class photoHelper {
    /**
     * @var string $savePath
     */
    public $savePath = '/web/uploads/';

    /**
     * @var string $webPath
     */
    public $webPath;

    /**
     * @var integer $h
     */
    public $h;

    /**
     * @var integer $w
     */
    public $w;

    /**
     * @var string $fileName
     */
    public $fileName;

    /**
     * @var integer $photoId
     */
    public $photoId;

    /**
     * @var array $allow
     */
    public $allow = [
        'image/gif' => 'gif',
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'image/png' => 'png'
    ];

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @return photoHelper|null
     */
    public static function init(){
        if(self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    /**
     * @return bool
     */
    public function upload(){
        if(is_null($_FILES)) return false;
        $file_tmp =$_FILES['image']['tmp_name'];

        // If PECL not installed on server where this code will be use. I use PECL some times.
        // And i can use Yii methods for this, but i want write personal code
        $type = mime_content_type($file_tmp);

        if(isset($this->allow[$type]))
            $name = self::generateName($this->allow[$type]);
            $this->setFileName(Yii::$app->basePath . $this->savePath . $name);
            $this->webPath = ($this->savePath . $name);
            $result = move_uploaded_file($file_tmp, $this->getFileName());
            $this->initImageSize();
            return $result;
    }

    /**
     * @param $ext
     * @return string
     */
    public static function generateName($ext){
        return md5( time() . rand( 11, time() ) ) . '.' . $ext;
    }

    /**
     * @return Gd\Image|\Imagine\Image\ImageInterface
     */
    public function resize(){
        $sourceFile = Yii::$app->basePath .  $this->fileName;
        $this->setFileName($this->savePath . self::generateName(
                $this->allow[
                mime_content_type( Yii::$app->basePath . $this->getFileName() )
                ]
            ));

        $destinationFile = Yii::$app->basePath .  $this->getFileName();

        $imagineObj = new Imagine();
        $imageObj = $imagineObj->open( $sourceFile );
        $imageObj->resize(
            $imageObj->getSize()
                ->widen( $this->w )
        )->save( $destinationFile, ['quality' => 100] );
        $this->initImageSize($destinationFile);

        return $imageObj;
    }

    /**
     * Unlink photo file
     * @return $this|bool
     */
    public function deletePhoto(){
        if(file_exists(Yii::$app->basePath . $this->getFileName())){
            if(unlink(Yii::$app->basePath . $this->getFileName())){
                return $this;
            }
        }
        return false;
    }

    /**
     * clearHistory clear current history for deleted photo
     */
    public function clearHistory(){
        History::deleteAll(['photo_id' => $this->getPhotoId()]);
    }

    /**
     * Set height and width properties
     */
    public function initImageSize(){

        list($this->w, $this->h) = getimagesize( Yii::$app->basePath . $this->getFileName());
    }

    /**
     * @return mixed
     */
    public function getH()
    {
        return $this->h;
    }

    /**
     * @return mixed
     */
    public function getW()
    {
        return $this->w;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return object
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return int
     */
    public function getPhotoId()
    {
        return $this->photoId;
    }

    /**
     * @param int $photoId
     */
    public function setPhotoId($photoId)
    {
        $this->photoId = $photoId;
        return $this;
    }


}