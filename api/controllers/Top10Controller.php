<?php
namespace api\controllers;

use yii\db\Query;

use yii\rest\Controller;

class Top10Controller extends Controller{
    public $modelClass = 'common\models\Article';

    public function actionIndex(){
       $top10 =  (new Query())->from('article')
           ->select(['created_by','Count(id) as creatercount'])
           ->groupBy(['created_by'])
           ->orderBy('creatercount DESC')
           ->limit(10)
           ->all();
        return $top10;
    }
}