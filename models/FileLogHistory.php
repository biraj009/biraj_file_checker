<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_log_history".
 *
 * @property int $id
 * @property int $file_system_id
 * @property int $status 0=all,1=added,2=updated,3=deleted
 * @property string $last_updated_at
 * @property string $created_at
 * @property string $updated_at
 */
class FileLogHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_log_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_system_id', 'status'], 'required'],
            [['file_system_id', 'status'], 'integer'],
            [['last_updated_at', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_system_id' => 'File System ID',
            'status' => 'Status',
            'last_updated_at' => 'Last Updated At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}