<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coments".
 *
 * @property int $id
 * @property int $id_article
 * @property string $user
 * @property string $coment
 * @property int $status
 * @property int $created_at
 */
class Coment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coments';
    }
	
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_article', 'user', 'coment', 'status',], 'required'],
            [['id_article', 'status', 'created_at'], 'default', 'value' => null],
            [['id_article', 'status', 'created_at'], 'integer'],
            [['user'], 'string', 'max' => 100],
            [['coment'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_article' => 'Id Article',
            'user' => 'Ваше имя',
            'coment' => 'Коментарий',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
	
	/**
     * {@inheritdoc}
     */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			
			if($insert) $this->created_at = date('U');
			return true;
		}
		return false;
	}
}
