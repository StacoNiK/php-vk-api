# php-vk-api
Библиотека для работы с API сайта vk.com


**Установка:**

    composer require staconik/php-vk-api

**Пример использования:**

    $token = new \VKApi\VkAccessToken("ACCESS_TOKEN"); 
    if (!$token->check()) {
        echo 'Invalid token';
        exit;
    }
    $vk = new \VKApi\VkApi($token); //основной класс для работы с апи
    $param = new \VKApi\VkParams(["owner_id" => "1"]); //создаем объект параметров запроса
    $request = $vk->createRequest("wall.get", $param);
    $request->attempts = 5; //количество попыток повторения в случае ошибки
    $request->setSuccessListener(function ($response) {
        $items = $response->get()['items'];
        echo "Запрос успешно выполнен!\n";
        echo "Текст первого поста: ".$items[0]['text'];
    }); //выполнение кода в случае успеха
    $request->setVkErrorListener(function($error){
        echo 'Ошибка: '.$error->error_msg;
    });
    $result = $request->execute(); //возвращается объект VkResult
    //второй вариант обработки результата
    if ($result->is_success) {
        echo 'Запрос прошёл успешно [Вариант 2]';
    }
    if ($result->is_error) {
        echo 'Ошибка запроса [Вариант 2]'.$result->error->error_msg;
    } 
**Создание авторизации**

    $auth = new \VKApi\OAuth(['client_id' => "CLIENT_ID", 'scope' => 'offline']); //создаем объект для авторизации и передаем массив параметров
    
    $auth->getImplictFlowLink(); //получение ссылки для авторизации (которая вернет токен)

    $auth->getCodeLink(); //получение ссылки для авторизации (на адрес redirect_url будет передан параметр code)

    $access_token = $auth->getTokenByCode($code); //получение токена по параметру code. Возвращается объект класса \VKApi\VkAccessToken.
    
    Подробнее про авторизацию читайте в документации VK Api
    
**Загрузка фото:**

    $upload = new \VKApi\Media\MessagePhotoUpload($vk, "PHOTO_URL", new \VKApi\VkParams()); //параметры в соответствии с документацией
    $result = $upload->save(new VkParams()); //возвращается объект photo

**Обработка капчи**

    Необходимо реализовать класс наследник от \VKApi\Handler\BaseCaptchaHandler с реализацией метода getCaptchaKey($vkCaptcha), который должен возвращать ответ, где параметр $vkCaptcha - объект класса \VKApi\VkCaptcha. 
    
    Объект реализованного класса нужно задать с помощью \VKApi\VkApi::setCaptchaHandler($yourHandler)
