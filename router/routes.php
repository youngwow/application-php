<?php

use Boyarkin\App\Services\Router;
use Boyarkin\App\Pages\Root;
use Boyarkin\App\Pages\Server\Api\Json;
use Boyarkin\App\Pages\NotFoundHttpException;

$pathText = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);

Router::RegisterPage('/', Root::class);
Router::RegisterPage('/root/index', Root::class);
Router::RegisterPage('/root', Root::class);
Router::RegisterPage('/server/api/json', Json::class);

try {
    if (!$pathText){
        throw new NotFoundHttpException('Incorrect uri');
    }
    Router::SearchPage($pathText);
} catch (NotFoundHttpException $e) {
    echo "<h1>".$e->getMessage()."</h1>";
}
