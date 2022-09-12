<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $category_id
 * @property string $title
 * @property string $announcement
 * @property int $created_at
 * @property int $updated_at
 * @property string $content
 * @property string|null $image
 * @property string|null $ext_id
 * @property string $seourl
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }
	
	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'announcement', 'content', 'seourl'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'category_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['announcement'], 'string', 'max' => 205],
            [['image', 'ext_id'], 'string', 'max' => 255],
            [['seourl'], 'string', 'max' => 500],
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
			 $news = self::findOne(['id' => $this->id]);
			 if($alias && $news->seourl != $this->seourl)
			 {
				 $this->addError($attribute, 'Этот псевдоним уже занят');
			 }
		}
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
     * Gets query for [[Category]].
	 * @return array
     */ 
	public static function getCategoryList()
	{
		$categories = Category::find()->select(['id', 'name'])->all();
		return ArrayHelper::map($categories, 'id', 'name');
	}
	
	/**
     * Gets query for [[Category]].
     * @return \yii\db\ActiveQuery
     */ 
	public function getCategory()
	{
		return $this->hasOne(Category::className(), ['id' => 'category_id']);
	}
	
	/**
     * Gets query for [[Category]].
     * @return \yii\db\ActiveQuery
     */ 
	public function getAlias()
	{
		return $this->hasOne(Alias::className(), ['seourl' => 'seourl']);
	}
}
