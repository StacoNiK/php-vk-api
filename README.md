# php-vk-api
Библиотека для работы с API сайта vk.com


**Установка:**

    composer require staconik/php-vk-api

**Пример использования:**

    $token = new VKApi\VkAccessToken("ACCESS_TOKEN"); 
    if (!$token->check()) {
        echo 'Invalid token';
        exit;
    }
    $vk = new VKApi\VkApi($token); //основной класс для работы с апи
    $param = new VKApi\VkParams(["owner_id" => "1"]); //создаем объект параметров запроса
    $request = $vk->createRequest("wall.get", $param);
    $request->attempts = 5; //количество попыток повторения в случае ошибки
    $request->setSuccessListener(function ($response) {
        $items = $response->get()['items'];
        echo "Запрос успешно выполнен!\n";
        echo "Текст первого поста: ".$items[0]['text'];
    });
    $request->setVkErrorListener(function($error){
        echo 'Ошибка: '.$error->error_msg;
    });
    $request->execute();
    
