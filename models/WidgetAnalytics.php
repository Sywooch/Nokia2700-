<?php

namespace app\models;
use \yii\base\Model;
use \yii\db\Query;

class WidgetAnalytics extends Model
{
    public static function getCatchAnalytics()
    {
        $query = new Query;
        $query->select('date')
            ->from('widget_catching');
        $rows = $query->all();
        return $rows;
    }

    public static function getCatchCount()
    {
        return count(self::getCatchAnalytics());
    }

    public static function getUniqActions($acttype)
    {

        $query = new Query;
        $query->select('ip, action')
            ->distinct('ip')
            ->from('widget_catching')
            ->where('action = "'.$acttype.'"');
        $rows = $query->all();
        return count($rows);
    }

    public static function getCatched($acttype)
    {
        $query = new Query;
        $query->select('*')
            ->from('widget_pending_calls')
            ->join('LEFT JOIN','widget_catching','widget_catching.id=widget_pending_calls.catching_id')
            ->distinct('ip')->where('action = "'.$acttype.'"');
        $rows = $query->all();
        return count($rows);
    }

    public static function conversion($a, $b)
    {
        $res = null;
        ($a != 0 || $b != 0) ? $res = $b*100/$a : $res = 0;
        return $res;
    }

    protected static function getShownWId($w_id)
    {


        $query = new Query;
        $query->select('action')
            ->from('widget_catching')
            ->join('INNER JOIN', 'widget_settings','widget_settings.widget_site_url=widget_catching.website')
            ->where('action != "close_page" AND widget_settings.widget_id="'.$w_id.'"')
            ->groupBy('widget_catching.ip');
        /*$query->select ('*')
                ->from('widget_pending_calls')
                ->join('LEFT JOIN', 'widget_catching', 'widget_pending_calls.catching_id=widget_catching.id')
                ->join('LEFT JOIN', 'widget_settings', 'widget_catching.website=widget_settings.widget_site_url')
                ->where('action != "close_page" AND widget_settings.widget_id="'.$w_id.'"')
                ->groupBy('widget_catching.ip');*/
        $shown = count($query->all());
        return $shown;


    }

    protected static function getCatchedWId($w_id, $acttype)
    {
        $query = new Query;
        /*$query->select('action')
            ->from('widget_catching')
            ->join('INNER JOIN', 'widget_settings','widget_settings.widget_site_url=widget_catching.website')
            ->where('action = "'.$acttype.'" AND widget_settings.widget_id="'.$w_id.'"')
            ->groupBy('widget_catching.ip');*/
        $query->select ('*')
            ->from('widget_pending_calls')
            ->join('LEFT JOIN', 'widget_catching', 'widget_pending_calls.catching_id=widget_catching.id')
            ->join('LEFT JOIN', 'widget_settings', 'widget_catching.website=widget_settings.widget_site_url')
            ->where('action = "'.$acttype.'" AND widget_settings.widget_id="'.$w_id.'"')
            ->groupBy('widget_catching.ip');
        $catched = ($query->all());
        return count($catched);
    }

    protected static function countConv($w_id)
    {
        $convercion = array();
        $acttypes = array('active_more40', 'moretime_after1min', 'more_avgtime','other_page', 'scroll_down',
            'mouse_intencivity', 'sitepage3_activity', 'form_activity', 'client_activity');
        foreach ($acttypes as $act)
        {
            $convercion[$act] = (self::getShownWId($w_id)!=0)?(integer)((self::getCatchedWId($w_id, $act))*100/(self::getShownWId($w_id))):0;
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
}
