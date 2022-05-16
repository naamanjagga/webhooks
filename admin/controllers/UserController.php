<?php

use Phalcon\Mvc\Controller;


class UserController extends Controller
{
    function index()
    {
        $connect = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $connect->frontend->products;
        $find = $collection->find();
        echo '<table>';
        echo '<tr><td>NAME</td><td>CATEGORY</td><td>PRICE</td><td>QUANTITY</td><td>UPDATE</td></tr>';
        foreach ($find as $v) {
            echo '<tr><td>' . $v->name . '</td><td>' . $v->category . '</td><td>' . $v->price . '</td><td>' . $v->stock . '</td><td><button name="update" value="' . $v->_id . '" type="" >order</button></td></tr>';
        }
        echo '</table>';
    }
}
