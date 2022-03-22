<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $endpoint
 * @property int $request_type
 * @property string $parameters
 * @property string $date_created
 *
 * @property Event[] $events
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    const REQUEST_TYPE_GET = 1;
    CONST REQUEST_TYPE_POST = 2;
    const REQUEST_TYPE_PUT = 3;
    const REQUEST_TYPE_PATCH = 4;
    const REQUEST_TYPE_DELETE = 5;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['endpoint', 'request_type', 'parameters'], 'required'],
            [['request_type'], 'integer'],
            [['date_created'], 'safe'],
            [['endpoint', 'parameters'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'endpoint' => 'Endpoint',
            'request_type' => 'Request Type',
            'parameters' => 'Parameters',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return array
     */
    public static function getRequestTypes (): array
    {
        return [
            self::REQUEST_TYPE_GET => 'GET',
            self::REQUEST_TYPE_POST => 'POST',
            self::REQUEST_TYPE_PUT => 'PUT',
            self::REQUEST_TYPE_PATCH => 'PATCH',
            self::REQUEST_TYPE_DELETE => 'DELETE',
        ];
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['supplier_id' => 'id']);
    }
}
