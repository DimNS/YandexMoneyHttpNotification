<?php
/**
 * Client
 *
 * Клиентский класс для приёма уведомлений от сервиса Яндекс.Деньги
 *
 * Использование:
 * $yamnotif = new \YandexMoneyHttpNotification\Client('Номер кошелька', 'Секретное слово');
 * echo $yamnotif->generateButton('Метка', 'Описание платежа', 500, 'Адрес для редиректа после перевода');
 *
 * @version 0.1.0 24.12.2015
 * @author Дмитрий Щербаков <atomcms@ya.ru>
 * @license MIT
 * @copyright 2015 Bestion
 * @link https://github.com/DimNS/YandexMoneyHttpNotification <GitHub репозиторий>
 */

namespace YandexMoneyHttpNotification;

class Client
{
    /**
     * @var string $account Номер кошелька Яндекс.Деньги
     */
    private $account = '';

    /**
     * @var string $secret Секретное слово позволит вам проверять подлинность уведомлений, выдаётся здесь https://money.yandex.ru/myservices/online.xml
     */
    private $secret = '';

    /**
     * Инициализация объекта
     *
     * @param string $account Номер кошелька
     * @param string $secret  Секретное слово
     *
     * @return null
     *
     * @version 0.1.0 24.12.2015
     * @author Дмитрий Щербаков <atomcms@ya.ru>
     */
    function __construct($account, $secret) {
        $this->account = $account;
        $this->secret  = $secret;
    }

    /**
     * Генерация кнопки оплаты
     *
     * @param string  $label       Метка, по которой серверная часть будет знать откуда приходит платеж, здесь же нужно указывать другие данные для автоматизации платежа
     * @param string  $targets     Название платежа (за что)
     * @param integer $sum         Сумма
     * @param string  $success_url Адрес для редиректа после перевода
     *
     * @return string
     *
     * @version 0.1.0 24.12.2015
     * @author Дмитрий Щербаков <atomcms@ya.ru>
     */
    public function generateButton($label, $targets, $sum, $success_url) {
        return '<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=' . $this->account . '&quickpay=small&any-card-payment-type=on&button-text=01&button-size=l&button-color=orange&targets=' . urlencode($targets) . '&default-sum=' . $sum . '&successURL=' . urlencode($success_url) . '&label=' . urlencode($label) . '" width="242" height="54"></iframe>';
    }
}
?>