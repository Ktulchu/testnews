<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $seourl
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Category extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
	
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
            [['name', 'seourl'], 'required'],
            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'parent_id'], 'integer'],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['name', 'seourl'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'seourl' => 'Seourl',
            'status' => 'Статус',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата редактирования',
			'parent_id'  => 'Родительская категория'
        ];
    }
	
	/**
     * @inheritdoc
     */
    public static function getStatusName()
    {
        return [
			self::STATUS_ACTIVE  => 'Включено',
			self::STATUS_DELETED => 'Отключено'
		];
    }
	
	/**
     * Gets query for [[Category]].
     * @return \yii\db\ActiveQuery
     */ 
	public function getParent()
	{
		return $this->hasOne(Category::className(), ['id' => 'parent_id']);
	}
	
	/**
     * {@inheritdoc}
	 * @return string
     */
	public function getParentName()
	{
		$parent = $this->parent;
		return $parent ? $parent->name : '';
	}
	
	/**
     * Gets query for [[Category]].
	 * @return array
     */ 
	public static function getParentsList()
	{
		$parents = Category::find()
			->select(['c.id', 'c.name'])
			->join('JOIN', 'category c', 'category.parent_id = c.id')
			->distinct(true)
			->all();
		return ArrayHelper::map($parents, 'id', 'name');
	}
	
	/**
     * {@inheritdoc}
     */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			
			if($insert)  Yii::$app->session->setFlash('success', 'Категория успешно добавлена');
				else Yii::$app->session->setFlash('success', 'Категория успешно обновлена');
			
			return true;
		}
		return false;
	}
}
