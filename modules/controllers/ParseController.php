<?php

namespace app\modules\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

use app\models\User;
use app\modules\models\ParsePregmatch;

class ParseController extends Controller
{
     /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [ 
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [$this->action->id],
                        'allow' => true,
                        'roles' => ['@'],
						'matchCallback' => function ($rule, $action) {
							return User::isUserAdmin(Yii::$app->user->identity->username);
						}
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionTypepreg()
    {
        $model = new ParsePregmatch();
		if ($model->load(Yii::$app->request->post()))
		{
			$model->Parse();
		}
		return $this->render('preg', ['model' => $model]);
    }
	
	/**
     * Displays homepage.
     *
     * @return string
     */
    public function actionTypexml()
    {
        return $this->render('index');
    }


}
