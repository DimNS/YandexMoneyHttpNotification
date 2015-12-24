<?php
/**
 * Пример получения уведомления от Яндекс.Денег и отправки его необходимому сайту
 *
 * Клиентская кнопка для этого примера была такой:
 * $yamnotif = new \YandexMoneyHttpNotification\Client('Номер кошелька', 'Секретный ключ');
 * echo $yamnotif->generateButton('mysite#123', 'Пополнение личного счёта', 500, 'http://mysite.tld/payments/success');
 */
$yamnotif = new \YandexMoneyHttpNotification\Server('Секретный ключ');
if ($yamnotif->check($_POST) == '200 OK') {
    $data = explode('#', $_POST['label']);
    switch ($data[0]) {
        case 'mysite':
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL            => 'http://mysite.tld/payments/paid',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => array(
                    'secretkey'    => 'Секретный ключ сайта',
                    'datetime'     => $_POST['datetime'],
                    'operation_id' => $_POST['operation_id'],
                    'user_id'      => $data[1], // ИД пользователя
                    'amount'       => $_POST['withdraw_amount'], // Сумма, списанная с плательщика
                ),
            ));
            $return = json_decode(curl_exec($ch), true);
            curl_close($ch);
        break;
    }
}
?>