<?php

use Phalcon\Mvc\Controller;


class WebhooksController extends Controller
{
    function index()
    {
        
    }
    function storeWebhook()
    {
        $connect = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $connect->test->webhooks;
        $insertOneResult = $collection->insertOne([
            'webhook' => $_POST['webhookName'],
            'event' => $_POST['eventName'],
            'key' => $_POST['key'],
            'url' => $_POST['url'],
        ]);
    }
    
}