<?php

use Phalcon\Mvc\Controller;


class ProductController extends Controller
{
    function index()
    {
        $mongo =  new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $mongo->test->products;
        $find = $collection->find();
        foreach ($find as $f) {
            echo "name :" . $f->name;
            echo '<br>';
        }
    }
    function search($name = "")
    {
        
        $array = explode("%20", $name);
        $mongo =  new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $mongo->test->products;

        for ($i = 0; $i < count($array); $i++) {
            $find = $collection->find(["name" => ['$regex' => $array[$i]]]);
            foreach ($find as $f) {
                echo "name :" . $f->name;
                echo '<br>';
            }
        }
        for ($i = 0; $i < count($array); $i++) {
            $find = $collection->find(["Variations" => ['$elemMatch' => ['$regex' => $array[$i]]]]);
            foreach ($find as $f) {
                echo "name :" . $f->name;
                echo '<br>';
            }
        }
        die;
    }
    function get($per_page = "" , $page = "")
    {
        $start = 0 + $per_page*($page-1);
        $limit = $per_page + $per_page*($page-1);
        $options = [
            'skip' => $start,
            'limit' => $limit,
        ];
        $mongo =  new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $mongo->test->products;
        $find = $collection->find([], $options);
        foreach ($find as $f) {
            echo "name :" . $f->name;
            echo '<br>';
        }
    }
}