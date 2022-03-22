<?php
namespace app\services;
use app\helpers\CurlHelper;
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

    /**
     * отправка запроса
     * @param $id
     */
    public function sentByEndpoint($id): void
    {
        $event = Event::findOne($id);
        $supplier = $event->supplier;
        $requestParams = $this->normalizeParams($event, $supplier->parameters);
        $url = $this->normalizeUrl($supplier->endpoint, $requestParams);
        $result = CurlHelper::sendCurl($url, $supplier->request_type);
        $this->saveByResult($event, $result);
    }

    /**
     * сохранение результата
     * @param Event $event
     * @param $result
     */
    public function saveByResult(Event $event, $result): void
    {
        if ((bool)$result === true) {
            $event->status = Event::STATUS_CONFIRMED;
        } else {
            $event->status = Event::STATUS_FAILED;
        }
        $event->save(false);
    }

    /**
     * вставляем данные вместо ключей
     * @param Event $event
     * @param $supplierParameters
     * @return string
     */
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

    /**
     * приводим в порядок урл
     * @param $url
     * @param $params
     * @return string
     */
    private function normalizeUrl($url, $params): string
    {
        return str_replace('//', '/', $url.$params);
    }
}