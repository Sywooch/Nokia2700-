<?php

namespace app\models;

use Yii;
use \yii\db\Query;

/**
 * This is the model class for table "widget_sended_email_messeg".
 *
 * @property integer $widget_id
 * @property integer $id
 * @property string $phone
 * @property string $email
 * @property string $message
 */
class WidgetSendedEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_sended_email_messeg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'id', 'email'], 'required'],
            [['widget_id', 'id'], 'integer'],
            [['phone'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100],
            [['message'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'widget_id' => 'Номер виджета',
            'id' => 'ID',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'message' => 'Сообщение',
        ];
    }

    public function getWidget()
    {
        return $this
            ->hasOne(WidgetSettings::className(), ['widget_id' => 'widget_id'])       
            ->viaTable(WidgetSettings::tableName(), ['widget_id' => 'widget_id']);  
    }

    public static function getCountSendMails()
    {
        $query = new Query;
        $query->select('*')
            ->from('widget_sended_email_messeg');
        $row = $query->count();
        return $row;
    }

    public static function getCountChats()
    {
        $query = new Query;
        $query->select('*')
            ->from('widget_chat_messeg');
        $row = $query->count();
        return $row;
    }
}
