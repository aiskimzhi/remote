<?php

namespace app\models;


use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    public $imageFiles;

    public function setName($id)
    {
        return 'img/page_'.$id .'/'. Yii::$app->security->generateRandomString(16) . '_';
    }

    public function rules()
    {
        return [
            [['imageFiles'], 'image', 'skipOnEmpty' => false,
                'extensions' => Yii::$app->params['extensions'],
                'maxFiles' => Yii::$app->params['maxFiles'],
                'checkExtensionByMimeType'=>false,
            ],
        ];
    }

    public function imageAmount($id)
    {
        $img = 0;

        if (file_exists('img/page_' . $id)) {
            $img = count(scandir('img/page_' . $id)) - 2;
        }

        return $img;
    }

    public function dirExist($id)
    {
        if (!file_exists('img/page_' . $id)) {
            return mkdir('img/page_' . $id);
        }

        return true;
    }

    public function upload($id) {
        if ($this->validate()) {
            if ($this->dirExist($id) && $this->imageAmount($id) < Yii::$app->params['maxFiles']) {
                foreach ($this->imageFiles as $file) {
                    $file->saveAs($this->setName($id) . '.' . $file->extension);
                }
                return true;
            }

            if ($this->imageAmount($id) >= Yii::$app->params['maxFiles']) {
                Yii::$app->session->setFlash('error', "You can't add more that 10 pictures");
                return false;
            }
        }

        Yii::$app->session->setFlash('error', "Can't upload pictures. Try later");
        return false;
    }
} 
