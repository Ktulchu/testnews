<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;
use app\models\Category;
use app\models\Article;
use app\models\Alias;
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
   
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'announcement', 'content', 'seourl'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['announcement'], 'string', 'max' => 205],
            [['image'], 'string', 'max' => 255],
            [['seourl'], 'string', 'max' => 500],
			[['seourl'], 'ValidUnique'],
			[['images'], 'image',
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
		
	}
	
	
	
}
