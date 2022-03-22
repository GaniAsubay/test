<?php
namespace app\services;
use app\models\Event;
use app\models\Supplier;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gani
 * Date: 3/22/22
 * Time: 9:10 PM
 */

class EventService
{
    /**
     * массив с ключем {id} и значение {endpoint}
     * @return array
     */
    public function getSuppliersMap(): array
    {
        return ArrayHelper::map(Supplier::find()->select(['id','endpoint'])->asArray()->all(), 'id','endpoint') ?? [];
    }

    public function sentByEndpoint($id): void
    {
        $event = Event::findOne($id);
        $supplier = $event->supplier;
        $requstParams = $this->normalizeParams($event, $supplier->parameters);
        $url = $this->normalizeUrl($supplier->endpoint, $supplier->parameters);
    }

    private function normalizeParams(Event $event, $supplierParameters): string
    {
        $parameterKeys = Supplier::getParameterKeys();
        $result = $supplierParameters;
        if (is_array($parameterKeys)) {
            foreach ($parameterKeys as $key => $parameterKey) {
                $result = str_replace($parameterKey, $event->{$key}, $supplierParameters);
            }
        }
        return $result;
    }

    private function normalizeUrl($url, $params) {
        return str_replace('//', '/', $url.$params);
    }
}