<?php

namespace app\models;

use Random\RandomException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $url
 * @property string $short_token
 * @property string $date_create
 */
class Link extends ActiveRecord
{
    const EVENT_LINK_REDIRECT = 'linkRedirect';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'short_token'], 'required'],
            [['url'], 'string', 'max' => 255],
            [['url'], 'filter', 'filter' => 'trim'],
            [['url'], 'filter', 'filter' => 'strip_tags'],
            [['short_token'], 'string', 'length' => 5],
            [['short_token'], 'match', 'pattern' => '/^[A-Za-z0-9_-]+$/', 'message' => 'Short token can only contain letters, numbers, dashes, and underscores.'],
            [['date_create'], 'safe'],
            [['url'], 'url'],
            [['short_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'URL',
            'short_token' => 'Short Token',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * Generate a random, unique short token
     */
    public static function generateShortToken()
    {
        $token = self::generateRandomToken();

        while (self::find()->where(['short_token' => $token])->exists()) {
            $token = self::generateRandomToken();
        }

        return $token;
    }

    /**
     * Helper method to generate a random 5-character short token
     * @throws RandomException
     */
    private static function generateRandomToken()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $token = '';
        for ($i = 0; $i < 5; $i++) {
            $token .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $token;
    }

    /**
     * Before validate, generate the short token if it's not set
     */
    public function beforeValidate()
    {
        if (empty($this->short_token)) {
            $this->short_token = self::generateShortToken();
        }

        return parent::beforeValidate();
    }

    /**
     * Before saving, generate the short token if it's not set
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord && empty($this->short_token)) {
            $this->short_token = self::generateShortToken();
        }

        return parent::beforeSave($insert);
    }

}
