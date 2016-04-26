<?php
/**
 * Client
 *
 * Клиентский класс для приёма уведомлений от сервиса Яндекс.Деньги
 *
 * Использование:
 * $yamnotif = new \DimNS\YandexMoneyHttpNotification\Client('Номер кошелька', 'Секретное слово');
 * echo $yamnotif->generateButton('Метка', 'Описание платежа', 500, 'Адрес для редиректа после перевода', 's');
 *
 * @version 1.0.0 26.04.2016
 * @author Дмитрий Щербаков <atomcms@ya.ru>
 */

namespace DimNS\YandexMoneyHttpNotification;

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
     * @version 1.0.0 26.04.2016
     * @author Дмитрий Щербаков <atomcms@ya.ru>
     */
    public function __construct($account, $secret)
    {
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
     * @param string  $button_size Адрес для редиректа после перевода
     *
     * @return string
     *
     * @version 1.0.0 26.04.2016
     * @author Дмитрий Щербаков <atomcms@ya.ru>
     */
    public function generateButton($label, $targets, $sum, $success_url, $button_size)
    {
        switch ($button_size) {
            case 's':
                $iframe_size = [
                    'width'  => 136,
                    'height' => 31,
                ];
                break;

            case 'm':
                $iframe_size = [
                    'width'  => 197,
                    'height' => 42,
                ];
                break;

            case 'l':
                $iframe_size = [
                    'width'  => 242,
                    'height' => 54,
                ];
                break;

            default:
                $button_size = 's';
                $iframe_size = [
                    'width'  => 136,
                    'height' => 31,
                ];
                break;
        }

        return '<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=' . $this->account . '&quickpay=small&any-card-payment-type=on&button-text=01&button-size=' . $button_size . '&button-color=orange&targets=' . urlencode($targets) . '&default-sum=' . $sum . '&successURL=' . urlencode($success_url) . '&label=' . urlencode($label) . '" width="' . $iframe_size['width'] . '" height="' . $iframe_size['height'] . '"></iframe>';
    }
}
