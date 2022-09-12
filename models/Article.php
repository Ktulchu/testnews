<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $position
 * @property string $title
 * @property string $announcement
 * @property int $created_at
 * @property int $updated_at
 * @property string $content
 * @property string|null $image
 * @property string|null $public_date
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
            [['position', 'title', 'announcement', 'content', 'seourl'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'position'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 32],
            [['announcement'], 'string', 'max' => 100],
            [['image', 'public_date', 'ext_id'], 'string', 'max' => 255],
            [['seourl'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'announcement' => 'Announcement',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'content' => 'Content',
            'image' => 'Image',
            'public_date' => 'Public Date',
            'ext_id' => 'Ext ID',
            'seourl' => 'Seourl',
        ];
    }
}
