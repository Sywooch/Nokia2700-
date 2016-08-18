<?php

namespace app\models;
use Yii;
use \yii\base\Model;
use \yii\db\Query;

/**
 * This is the model class for table "widget_action_marks".
 *
 * @property integer $widget_id
 * @property integer $other_page
 * @property integer $scroll_down
 * @property integer $active_more40
 * @property integer $mouse_intencivity
 * @property string $site_pages_list
 * @property integer $sitepage_activity
 * @property integer $sitepage3_activity
 * @property integer $more_avgtime
 * @property integer $moretime_after1min
 * @property integer $form_activity
 * @property integer $client_activity
 * @property string $widget_site_url
 */

class WidgetAnalytics extends Model
{

    public  $widget_id;
    public $other_page;
    public $scroll_down;
    public $active_more40;
    public $mouse_intencivity;
    public $site_pages_list;
    public $sitepage_activity;
    public $sitepage3_activity;
    public $more_avgtime;
    public $moretime_after1min;
    public $form_activity;
    public $client_activity;
    public $widget_site_url;

    public function rules()
    {
        return [
            [['widget_id', 'other_page', 'scroll_down', 'active_more40', 'mouse_intencivity', 'sitepage3_activity', 'more_avgtime', 'moretime_after1min', 'form_activity', 'client_activity', 'widget_site_url'], 'required'],
            [['widget_id', 'other_page', 'scroll_down', 'active_more40', 'mouse_intencivity', 'sitepage3_activity', 'more_avgtime', 'moretime_after1min', 'form_activity', 'client_activity'], 'integer'],
            [['widget_site_url'],'string']
        ];
    }

    public static function getCatchAnalytics($w_id=null)
    {
        $acttypes = array('active_more40', 'moretime_after1min', 'more_avgtime','other_page', 'scroll_down',
            'mouse_intencivity', 'sitepage3_activity', 'form_activity', 'client_activity');

        $acts = array(
            'active_more40'=>'<i class="fa fa-hourglass-o"></i>Более 40с. на сайте',
            'moretime_after1min'=>'<i class="fa fa-hourglass-end"></i>Каждые 30с. после минуты',
            'more_avgtime'=>'<i class="fa fa-hourglass"></i>Дольше среднего времени',
            'other_page'=> '<i class="fa fa-clone"></i>Переход на другую страницу',
            'scroll_down'=>'<i class="fa fa-long-arrow-down"></i>Скролл в конец страницы',
            'mouse_intencivity'=>'<i class="fa fa-mouse-pointer"></i>Активность мыши',
            'sitepage3_activity'=>'<i class="fa fa-file-word-o"></i>Посещение более 3-х страниц',
            'form_activity'=>'<i class="fa fa-commenting-o"></i>Взаимодействие с формами',
            'client_activity'=>'<i class="fa fa-hand-pointer-o"></i>Нажатие на кнопку');

        $analyt = array();
        foreach($acttypes as $act)
        {

            if($w_id == 0)
            {
                $catched = self::getCatchedWId($act);
                $shown = self::getShownWId($act);
                ($shown != 0 && $catched != 0) ? $conver = (integer)($catched*100/$shown) : $conver = 0;
                $analyt[$act] = array('name'=>$acts[$act], 'shown'=>$shown, 'catch'=>$catched, 'conversion'=>$conver );
            }
            else
            {
                $catched = self::getCatchedWId($act, $w_id);
                $shown = self::getShownWId($act, $w_id);
                ($shown != 0 || $catched != 0) ? $conver = (integer)($catched*100/$shown) : $conver = 0;
                $analyt[$act] = array('name'=>$acts[$act], 'shown'=>$shown, 'catch'=>$catched, 'conversion'=>$conver );
            }


        }

        return $analyt;

    }

    public static function conversion($a, $b)
    {
        $res = null;
        ($a != 0 || $b != 0) ? $res = $b*100/$a : $res = 0;
        return $res;
    }

    public static function getShownWId($acttype , $w_id=null)
    {
        $query = new Query;

        if (isset($acttype) && isset($w_id))
        {
            $query->select('action')
                ->from('widget_catching')
                ->join('INNER JOIN', 'widget_settings','widget_settings.widget_site_url=widget_catching.website')
                ->where('`action` = "'.$acttype.'" AND widget_settings.widget_id="'.$w_id.'" AND widget_settings.user_id = "'.Yii::$app->user->identity->id.'"')
                ->groupBy('widget_catching.date');
        }
        elseif(isset($w_id))
        {
            $query->select('action')
                ->from('widget_catching')
                ->join('INNER JOIN', 'widget_settings','widget_settings.widget_site_url=widget_catching.website')
                ->where('`action` = "close_page" AND widget_settings.widget_id="'.$w_id.'" AND widget_settings.user_id = "'.Yii::$app->user->identity->id.'"')
                ->groupBy('widget_catching.date');
        }
        else
        {
            $query->select('action')
                ->from('widget_catching')
                ->join('INNER JOIN', 'widget_settings','widget_settings.widget_site_url=widget_catching.website')
                ->where('action= "'.$acttype.'" AND widget_settings.user_id = "'.Yii::$app->user->identity->id.'"')
                ->groupBy('widget_catching.date');

        }

        $shown = count($query->all());
        return $shown;
//comments

    }

    public static function getCatchedWId($acttype, $w_id=null)
    {
        $query = new Query;

        if(isset($w_id))
        {
          /*  $query->select ('*')
                ->from('widget_pending_calls')
                ->join('LEFT JOIN', 'widget_catching', 'widget_pending_calls.catching_event=widget_catching.id')
                ->join('LEFT JOIN', 'widget_settings', 'widget_catching.website=widget_settings.widget_site_url')
                ->where('action = "'.$acttype.'" AND widget_settings.widget_id="'.$w_id.'"')
                ->groupBy('widget_catching.ip');*/
        }
        else
        {
         /*   $query->select ('*')
                ->from('widget_pending_calls')
                ->join('LEFT JOIN', 'widget_catching', 'widget_pending_calls.catching_id=widget_catching.id')
                ->join('LEFT JOIN', 'widget_settings', 'widget_catching.website=widget_settings.widget_site_url')
                ->where('action = "'.$acttype.'"')
                ->groupBy('widget_catching.ip');*/

        }

/*        $catched = ($query->all());
        return count($catched);*/
    }

    public static function countConv($w_id)
    {
        $convercion = array();
        $acttypes = array('active_more40', 'moretime_after1min', 'more_avgtime','other_page', 'scroll_down',
            'mouse_intencivity', 'sitepage3_activity', 'form_activity', 'client_activity');
        foreach ($acttypes as $act)
        {
            $convercion[$act] = (self::getShownWId(null,$w_id)!=0)?(integer)((self::getCatchedWId($act, $w_id))*100/(self::getShownWId(null,$w_id))):0;
        }
        return $convercion;
    }

    public static function saveHandSettings($w_id)
    {
        $w_cv = self::countConv($w_id);
        $mark = array();
        foreach($w_cv as $key => $val) {
            if ($val <= 5) $mark[$key] = 1;
            elseif (5 < $val & $val <= 10) $mark[$key] = 2;
            elseif (10 < $val & $val <= 15) $mark[$key] = 3;
            elseif (20 < $val & $val <= 25) $mark[$key] = 4;
            elseif (25 < $val & $val <= 30) $mark[$key] = 5;
            elseif (30 < $val & $val <= 35) $mark[$key] = 6;
            elseif (35 < $val & $val <= 40) $mark[$key] = 7;
            elseif (40 < $val & $val <= 45) $mark[$key] = 8;
            elseif (45 < $val & $val <= 50) $mark[$key] = 9;
            else $mark[$key] = 10;
        }
        self::saveMarks($w_id, $mark);
    }

    protected static function saveMarks($w_id, $marks)
    {
        if (($model = WidgetActionMarks::findOne($w_id)) !== null) {
            $model->other_page = $marks['other_page'];
            $model->active_more40 = $marks['active_more40'];
            $model->moretime_after1min = $marks['moretime_after1min'];
            $model->more_avgtime = $marks['more_avgtime'];
            $model->scroll_down = $marks['scroll_down'];
            $model->mouse_intencivity = $marks['mouse_intencivity'];
            $model->sitepage3_activity = $marks['sitepage3_activity'];
            $model->form_activity = $marks['form_activity'];
            $model->client_activity = $marks['client_activity'];
            $model->save();
        }
    }

    public static function getWidgets()
    {
        $query = new Query;
        $query->select('widget_action_marks.*, widget_settings.widget_site_url')
            ->from('widget_action_marks')
            ->join('INNER JOIN','widget_settings','widget_settings.widget_id=widget_action_marks.widget_id')
            ->where('widget_settings.user_id ="'.Yii::$app->user->identity->id.'"')
            ->distinct('widget_site_url');
        $rows = $query->all();
        return $rows;
    }

}
