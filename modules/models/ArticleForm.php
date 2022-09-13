<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;
use app\models\Category;
use app\models\Article;
use app\models\Alias;
use yii\web\UploadedFile;
/**
 * ParsePregmatch is the model.
 */
class ArticleForm extends Model
{
	public $id;
	public $category_id;
	public $title;
	public $announcement;
	public $content;
	public $image;
	public $seourl;
	public $delimg;
	public $status;
   
	/**
     * {@inheritdoc}
     */
	public function init()
	{
		$dir = Yii::getAlias('@app') .'/web/images';
		if(!is_dir($dir)) { mkdir($dir, 0777, true);}

		parent::init();
	}
	
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'announcement', 'content', 'seourl'], 'required'],
            [['content', 'delimg'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['announcement'], 'string', 'max' => 205],
            [['seourl'], 'string', 'max' => 500],
			[['seourl'], 'ValidUnique'],
			['status', 'in', 'range' => [Article::STATUS_ACTIVE, Article::STATUS_DELETED]],
			[['image'], 'image',
				'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
				'checkExtensionByMimeType' => true,
				'maxSize' => 512000, // 500 килобайт = 500 * 1024 байта = 512 000 байт
				'tooBig' => 'Максимальный размер 500 килобайт',
				'maxFiles' => 1
			 ],
        ];
    }
	
	/**
     * {@inheritdoc}
     */
	public function ValidUnique($attribute, $params)
	{
		$alias = Alias::findOne(['seourl' => $this->seourl]);
		if (Yii::$app->controller->action->id == 'create')
		{
			if($alias) $this->addError($attribute, 'Этот псевдоним уже занят');
		}
		else
		{
			 $news = Article::findOne(['id' => $this->id]);
			 if($alias && $news->seourl != $this->seourl)
			 {
				 $this->addError($attribute, 'Этот псевдоним уже занят');
			 }
		}
	}
	
	/**
     * @inheritdoc
     */
    public static function getStatusName()
    {
        return Article::getStatusName();
    }
	
	/**
     * Gets query for [[Article]].
	 * @return array
     */ 
	public static function getCategoryList()
	{
		return Article::getCategoryList();
	}
	
	/**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'announcement' => 'Анонс',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата',
            'content' => 'Полный текс',
            'image' => 'Изображение',
            'public_date' => 'Public Date',
            'ext_id' => 'Внешний ключ',
            'seourl' => 'Псевданим',
        ];
    }
	
	/**
     * {@inheritdoc}
     */
	public function Save()
	{
		if($this->getErrors())
		{
			foreach ($this->getErrors() as $key => $value) {
				\Yii::$app->session->setFlash('danger', 'Ошибка! '. $value[0]);
				break;
			}
			return false; 
		}
		
		$transaction = Yii::$app->db->beginTransaction();
		try {		
			if(count($this->image) > 0) {
				$image = $this->SaveFile();
				
			} 
			if(count($this->image) == 0 && $this->delimg) {
				$image = 'nofoto.jpg';
			} 

			
			if ($this->id)
			{
				$article = Article::findOne(['id' => $this->id]);
				if (!isset($image))  $image = $article->image;
				$alias = $article->alias;
			} else {
				$article = new Article();
				$alias = new Alias();
			}

			$article->attributes = $this->attributes;
			$article->image = $image;
			$article->save();
			
			$alias->seourl = $this->seourl;
			$alias->url = '/news/'. $this->seourl;
			$alias->safe = 'news/view?id='. $article->id;
			$alias->save();
			
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			\Yii::$app->session->setFlash('danger','Oшибка записи!');
			$transaction->rollBack();
			throw $e;
		} catch (\Throwable $e) {
			\Yii::$app->session->setFlash('danger','Oшибка записи!');
			$transaction->rollBack();
			throw $e;
		}		
		
	}
	
	/**
	 * Rename and Save file
	 * {@inheritdoc}
	 * @return array
     */ 
	protected function SaveFile()
	{		
		$dir = Yii::getAlias('@app') .'/web/images/';
		
		$file = $this->image[0];
		$filename = $this->randomFileName($file->extension);
		if($file->saveAs($dir . '/' . $filename)) return $filename;
			else return false;
	}
	
	/**
	 * rename file
	 * extension : string
	 * {@inheritdoc}
	 * @return string
     */ 
	private function randomFileName($extension = false)
	{
		$extension = $extension ? '.' . $extension : '';
		$name = date('U') . rand(0, 1000);
		$file = $name . $extension;
		return $file;
	}
	
	
	
	
}
