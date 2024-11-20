<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "link_stats".
 *
 * @property int $id
 * @property int $link_id
 * @property string $date
 * @property int $count
 * @property string $created_at
 *
 * @property Link $link
 */
class LinkStat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link_id', 'date'], 'required'],
            [['link_id', 'count'], 'integer'],
            [['date'], 'safe'],
            [['created_at'], 'safe'],
            [['link_id'], 'exist', 'skipOnError' => true, 'targetClass' => Link::class, 'targetAttribute' => ['link_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Link]].
     *
     * @return ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Link::class, ['id' => 'link_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_id' => 'Link ID',
            'date' => 'Date',
            'count' => 'Count',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @throws Exception
     */
    public static function addStatToLink(int $linkId, int $count = 1, $date = null): bool
    {
        if (null === $date) {
            $date = date('Y-m-d');
        }
        $stat = self::findOne(['link_id' => $linkId, 'date' => $date]);

        if ($stat === null) {
            $stat = new LinkStat();
            $stat->link_id = $linkId;
            $stat->date = $date;
            $stat->count = $count;
        } else {
            $stat->count += $count;
        }

        return $stat->save();
    }
}
