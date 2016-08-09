<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "widget_catching".
 *
 * @property integer $id
 * @property string $ip
 * @property string $action
 * @property string $website
 * @property integer $time
 * @property string $date
 */
class WidgetCatching extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_catching';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'action'], 'required'],
            [['id', 'time'], 'integer'],
            [['date'], 'safe'],
            [['action'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 20],
            [['website'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'ip' => 'IP-адрес',
            'action' => 'Действие',
            'website' => 'Сайт',
            'time' => 'Время на сайте',
            'date' => 'Дата',
        ];
    }

    public static function getStatistics()
    {
        $query = new Query;
        $query->select('action, COUNT(action)')
            ->from('widget_catching')
            ->join('INNER JOIN', 'widget_settings','widget_settings.widget_site_url=widget_catching.website')
            ->where('action != "close_page" AND user_id='.Yii::$app->user->identity->id)
            ->groupBy('action');
        $rows = $query->all();
        return $rows;
    }

    public static function getCountStats()
    {
        $query = new Query;
        $query->select('COUNT(action)')
            ->from('widget_catching')
            ->join('INNER JOIN', 'widget_settings','widget_settings.widget_site_url=widget_catching.website')
            ->where('action != "close_page" AND user_id='.Yii::$app->user->identity->id);
        $row = $query->one();
        return $row['COUNT(action)'];
    }

    public static function getLabel($action)
    {
        switch($action)
        {
            case 'active_more40':
                return 'Активность более 40 секунд';
            break;
            case 'moretime_after1min':
                return 'За каждые 30 сек. после 1 минуты';
                break;
            case 'more_avgtime':
                return 'Дольше среднего времени на сайте';
                break;
            case 'other_page':
                return 'Посещение конкретных ссылок';
                break;
            case 'scroll_down':
                return 'Скролл вниз';
                break;
            case 'mouse_intencivity':
                return 'Интенсивность движения мышки';
                break;
            case 'sitepage3_activity':
                return 'Посещение более трёх страниц сайта';
                break;
            case 'form_activity':
                return 'Взаимодействие с формами';
                break;
            case 'client_activity':
                return 'Поведение, похожее на других пользователей';
                break;
        }
    }
}
