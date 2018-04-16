<?php
namespace api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\models\ApiLoginForm;

class AdminuserController extends ActiveController
{
    public $modelClass = 'common\models\Adminuser';
    
    public function actionLogin()
    {
        $model = new ApiLoginForm();
        
        $model->username = $_POST['username'];
        $model->password = $_POST['password'];
        
        if ($model->login()) {
            return ['access_token' => $model->login()];
        }
        else {
            $model->validate();
            return $model;
        }
        
    }
    
    
}