<?php


namespace common\models;
use yii\db\ActiveRecord;

class Posts extends ActiveRecord
{
    private $id;
    private $title;
    private $user_id;

    public function rules(){
        return [[['title', 'user_id'], 'required']];
    }

}

