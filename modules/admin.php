<?php

namespace app\modules;
use Yii;
use app\models\User;

/**
 * admin module definition class
 */
class admin extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\controllers';
	
	public function beforeAction($action){

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (User::isUserAdmin(Yii::$app->user->identity->username)){
		   return true;
        } else {
            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
