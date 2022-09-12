<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alias".
 *
 * @property int $id
 * @property string $seourl
 * @property string $url
 * @property string $safe
 */
class Alias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seourl', 'url', 'safe'], 'required'],
            [['seourl'], 'string', 'max' => 500],
            [['url'], 'string', 'max' => 505],
            [['safe'], 'string', 'max' => 250],
            [['seourl'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seourl' => 'Seourl',
            'url' => 'Url',
            'safe' => 'Safe',
        ];
    }
}
