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
	
	/**
     * {@inheritdoc}
     */
	public function beforeAction($action){

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->identity && User::isUserAdmin(Yii::$app->user->identity->username)){
		   return true;
        } else {
            Yii::$app->getResponse()->redirect(['/user/login']);
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
