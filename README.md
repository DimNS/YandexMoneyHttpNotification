# YandexMoneyHttpNotification
Когда сайтов много, а кошелёк один. PHP-библиотека для получения HTTP-уведомлений от Яндекс.Денег и перенаправление их на нужный сайт.

## Требования
- PHP 5.3 или выше.

## Установка через Composer
1. Установите [Composer](http://getcomposer.org/).
3. Подключите пакет в ваш проект командой `php composer.phar require dimns/yandexmoneyhttpnotification` или `composer require dimns/yandexmoneyhttpnotification` (если composer установлен глобально).
3. Подключите автозагрузку в вашем проекте (если еще не сделали этого): `require 'vendor/autoload.php';`.

## Использование
```php
// Клиентская часть на каждом вашем сайте, генерирует кнопки оплаты
$yamnotif = new \DimNS\YandexMoneyHttpNotification\Client('Номер кошелька', 'Секретный ключ');
echo $yamnotif->generateButton('mysite#123', 'Пополнение личного счёта', 500, 'http://mysite.tld/payments/success', 's');

// Серверная часть, которая будет обрабатывать запросы от всех сайтов
// Указывается здесь: https://money.yandex.ru/myservices/online.xml
// Это один из возможных вариантов обработки уведомлений
$yamnotif = new \DimNS\YandexMoneyHttpNotification\Server('Секретный ключ');
// Платёж успешно проведён, уведомление получено
if ($yamnotif->check($_POST) == '200 OK') {
    // Получаем метку, в которой указан сайт и номер заказа (или любая другая информация)
    $data = explode('#', $_POST['label']);
    switch ($data[0]) {
        // Уведомление для сайта
        case 'mysite':
            // Перенаправим информацию необходимому сайту
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => 'http://mysite.tld/payments/paid',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => [
                    'secretkey'    => 'Секретный ключ сайта',
                    'datetime'     => $_POST['datetime'],
                    'operation_id' => $_POST['operation_id'],
                    'user_id'      => $data[1], // ИД пользователя
                    'amount'       => $_POST['withdraw_amount'], // Сумма, списанная с плательщика
                ],
            ]);
            $return = json_decode(curl_exec($ch), true);
            curl_close($ch);
            break;
    }
}
```