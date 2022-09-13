<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\Article;
use app\models\SearchArticle;
use app\models\Coment;

class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],  
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchArticle();
        $dataProvider = $searchModel->search($this->request->queryParams);
		$dataProvider->setSort(['defaultOrder' => ['updated_at' => SORT_DESC]]);
		$dataProvider->pagination->pageSize = 3;
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $coment = new Coment([
			'id_article' => $id,
			'status' => 0,
		]);
		if ($this->request->isPost && $coment->load($this->request->post())) {
            if($coment->save()){
				Yii::$app->session->setFlash('success', 'Ваш коментарий отправлен на модерацию');
				return $this->refresh();
			}
        }
		return $this->render('view', [
            'model' => $this->findModel($id),
			'coment' => $coment,
        ]);
    } 
	
	/**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
		if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
