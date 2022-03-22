<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $date_created
 * @property string $goal
 * @property float $price
 * @property int $supplier_id
 * @property int $status
 *
 * @property Supplier $supplier
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    const STATUS_CREATED = 1;
    const STATUS_SENT = 2;
    const STATUS_CONFIRMED = 3;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_created'], 'safe'],
            [['status'],'default', 'value' => self::STATUS_CREATED],
            [['goal', 'price', 'supplier_id', 'status'], 'required'],
            [['price'], 'number'],
            [['supplier_id', 'status'], 'integer'],
            [['goal'], 'string', 'max' => 255],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_created' => 'Date Created',
            'goal' => 'Goal',
            'price' => 'Price',
            'supplier_id' => 'Supplier ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
          self::STATUS_CREATED => 'Создан',
          self::STATUS_SENT => 'Отправлен',
          self::STATUS_CONFIRMED => 'Подтвержден',
        ];
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
}
