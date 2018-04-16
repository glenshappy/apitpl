<?php
namespace api\controllers;
use common\models\Adminuser;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use common\models\Article;
use yii\filters\auth\QueryParamAuth;
class ArticleController extends ActiveController{
    public $modelClass = 'common\models\Article';
//    public function behaviors(){
//        return ArrayHelper::merge(
//            parent::behaviors(),
//            [
//                'authenticatior' => [
//                    'class' => QueryParamAuth::className()
//                ]
//            ]
//        );
//    }
    public function behaviors(){
//        session_start();
//        print_r($_SESSION);
//        print_r($_COOKIE);
//        file_put_contents(\Yii::getAlias('@app').'/hehe.txt',var_export(\Yii::$app->session,true));
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'authenticatior' => [
                    'class' => HttpBasicAuth::className(),
                    'auth' => function ($username, $password) {
                        $user = Adminuser::find()->where(['username' => $username])->one();
                        if ($user->verifyPassword($password)) {
                            return $user;
                        }
                        return null;
                    },
                ],

            ]
        );
    }
    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }
    public function actionIndex(){
        $modelClass = $this->modelClass;
        return new ActiveDataProvider(
            [
                'query'=>$modelClass::find()->asArray(),
                'pagination'=>[
                    'pageSize'=>3
                ]
            ]
        );
    }

    public function actionSearch(){
        return Article::find()->where(['like','title',$_POST['keyword']])->all();
    }
}