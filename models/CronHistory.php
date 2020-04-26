<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cron_history".
 *
 * @property int $id
 * @property string $cron_hit_at
 * @property int $status
 */
class CronHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cron_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cron_hit_at', 'status'], 'required'],
            [['cron_hit_at'], 'safe'],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cron_hit_at' => 'Cron Hit At',
            'status' => 'Status',
        ];
    }
}