<?php

namespace app\models;

use Yii;

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
 */
class WidgetActionMarks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_action_marks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'other_page', 'scroll_down', 'active_more40', 'mouse_intencivity', /*'sitepage_activity',*/ 'sitepage3_activity', 'more_avgtime', 'moretime_after1min', 'form_activity', 'client_activity'], 'required'],
            [['widget_id', 'other_page', 'scroll_down', 'active_more40', 'mouse_intencivity', /*'sitepage_activity',*/ 'sitepage3_activity', 'more_avgtime', 'moretime_after1min', 'form_activity', 'client_activity'], 'integer'],
            [['site_pages_list'],'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'widget_id' => 'Widget ID',
            'other_page' => 'Other Page',
            'scroll_down' => 'Scroll Down',
            'active_more40' => 'Active More40',
            'mouse_intencivity' => 'Mouse Intencivity',
            //'sitepage_activity' => 'Sitepage Activity',
            'sitepage3_activity' => 'Sitepage3 Activity',
            'more_avgtime' => 'More Avgtime',
            'moretime_after1min' => 'Moretime After1min',
            'form_activity' => 'Form Activity',
            'client_activity' => 'Client Activity',
        ];
    }
}
