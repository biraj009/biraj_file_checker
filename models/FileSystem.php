<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_system".
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_url
 * @property int $status
 * @property int $type 0=all, 1=added, 2=updated, 3=deleted
 * @property string $created_at
 * @property string $updated_at
 */
class FileSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_system';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name', 'file_url', 'status'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name'], 'string', 'max' => 200],
            [['file_url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'file_url' => 'File Url',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}