<?php
/**
 * Server
 *
 * Серверный класс для приёма уведомлений от сервиса Яндекс.Деньги
 *
 * Использование:
 * $yamnotif = new \YandexMoneyHttpNotification\Server('Секретное слово');
 * echo $yamnotif->check($_POST);
 *
 * @version 0.1.0 24.12.2015
 * @author Дмитрий Щербаков <atomcms@ya.ru>
 * @license MIT
 * @copyright 2015 Bestion
 * @link https://github.com/DimNS/YandexMoneyHttpNotification <GitHub репозиторий>
 */

namespace YandexMoneyHttpNotification;

class Server
{
    /**
     * @var string $secret Секретное слово позволит вам проверять подлинность уведомлений, выдаётся здесь https://money.yandex.ru/myservices/online.xml
     */
    private $secret = '';

    /**
     * Инициализация объекта
     *
     * @param string $secret Секретное слово
     *
     * @return null
     *
     * @version 0.1.0 24.12.2015
     * @author Дмитрий Щербаков <atomcms@ya.ru>
     */
    function __construct($secret) {
        $this->secret = $secret;
    }

    /**
     * Проверка полученных данных от Яндекса
     *
     * @param array $params Параметры уведомления
     *
     * @return null
     *
     * @version 0.1.0 24.12.2015
     * @author Дмитрий Щербаков <atomcms@ya.ru>
     */
    public function check($params) {
        // Считаем хеш для проверки
        $hash = sha1($params['notification_type'] . '&' . $params['operation_id'] . '&' . $params['amount'] . '&643&' . $params['datetime'] . '&' . $params['sender'] . '&' . $params['codepro'] . '&' . $this->secret . '&' . $params['label']);

        // Сверяем хеши
        if ($hash === $params['sha1_hash']) {
            header('HTTP/1.0 200 OK');
            return '200 OK';
        } else {
            header('HTTP/1.0 400 Bad Request');
            return '400 Bad Request';
        }
    }
}
?>