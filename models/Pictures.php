<?php

namespace app\models;

use yii\helpers\Html;

class Pictures extends Advert
{
    public function fileList($id)
    {
        $list = scandir('img/page_' . $id);
        return $list;
    }

    public function imageAmount($id)
    {
        $img = 0;

        if (file_exists('img/page_' . $id)) {
            $img = count($this->fileList($id)) - 2;
        }

        return $img;
    }

    public function imgList($id)
    {
        $list = [];
        $fileList = $this->fileList($id);
        if (file_exists('img/page_' . $id)) {
            if (count($fileList) > 2) {
                $max = count($fileList) - 2;
                $names = array_splice($fileList, 2, $max);
                for ($i = 0; $i < $max; $i++) {
                    $list[$i] = '/web/img/page_' . $id . '/' . $names[$i];
                }
                return $list;
            }
        }
        return $list;
    }

    public function carouselItems($i, $id)
    {
        $items = [];
        $imgList = $this->imgList($id);
        $arr1 = array_splice($imgList, $i);
        $arr2 = array_splice($imgList, 0, $i);
        $array = array_merge($arr1, $arr2);

        for ($j = 0; $j < count($array); $j++) {
            $items[$j] =  Html::img($array[$j], [
                'style' => 'margin: 0 auto; height: 400px;',
                'class' => 'item',
                'id' => $i . $j,
            ]);
        }

        return $items;
    }
} 