<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "widget_rating_manager".
 *
 * @property integer $id
 * @property integer $widget_id
 * @property integer $rating
 * @property string $phone
 * @property string $comment
 * @property string $date
 */
class WidgetRatingManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_rating_manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'rating', 'phone', 'comment'], 'required'],
            [['widget_id', 'rating'], 'integer'],
            [['date'], 'safe'],
            [['phone'], 'string', 'max' => 15],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'widget_id' => 'Widget ID',
            'rating' => 'Rating',
            'phone' => 'Phone',
            'comment' => 'Comment',
            'date' => 'Date',
        ];
    }
}
