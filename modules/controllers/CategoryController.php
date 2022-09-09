<?php

namespace app\modules\controllers;

use app\models\Category;
use app\modules\models\SearchCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchCategory();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index', 'SearchCategory[id]' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index', 'SearchCategory[id]' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
	
	/**
	 * translete name 
     * @param string $data
     * @return string json
     */
	public function actionTranslate($data, $language = 'ru') {
		
		$translit = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e', 
			'ё' => 'yo',   'ж' => 'zh',  'з' => 'z', 
			'и' => 'i',   'й' => 'j',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u', 
			'ф' => 'f',   'х' => 'x',   'ц' => 'c', 
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh', 
			'ь' => '',  'ы' => 'y',   'ъ' => '',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		 
 
			'А' => 'a',   'Б' => 'b',   'В' => 'v',
			'Г' => 'g',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'J',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
			'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
			'Ь' => '',    'Ы' => 'Y',   'Ъ' => '', 
			'Э' => 'E',   'Ю' => 'YU',  'Я' => 'YA',
			
			' ' => '-', ',' => '', '(' => '', ')' => '',
			'#' => '', '@' => '', '!' => '', '%' => '', '?' => '',
			'*' => '-', '=' => '', '+' => '', '&' => '-', '^' => '',
			'`' => '', '~' => '', '"' => '', '№' => '', '$' => '',
			';' => '', ':' => ''
 
		);
		
		if($language == 'ru') {
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return mb_strtolower(strtr(trim($data), $translit), 'utf-8');
		} else {
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return mb_strtolower(strtr(trim($data), array_flip($translit)), 'utf-8');
		}
	}
	
	/**
     * Status an existing Category model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionStatus($id)
    {
        $model = $this->findModel($id);

        $model->status = ($model->status == 10) ? 0 : 10;
		
		if($model->save())
		{
			if( $model->status == 10) 
			{
				$json['icon'] = '<span class="glyphicon glyphicon-eye-open"></span>';
				$json['class'] = "";
			}
			else
			{
				$json['icon'] = '<span class="glyphicon glyphicon-eye-close"></span>';
				$json['class'] = " btn-disabled";
			}
		}
		else
		{
			$json['error'] = "Ошибка изменения статуса";
		}
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $json;
    }
	
}
