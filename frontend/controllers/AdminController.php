<?php

use Phalcon\Mvc\Controller;


class AdminController extends Controller
{
    function index()
    {
        $connect = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $connect->test->products;
        $find = $collection->find();
        echo '<form action="update" method="post"><table>';
        echo '<tr><td>NAME</td><td>CATEGORY</td><td>PRICE</td><td>QUANTITY</td><td>UPDATE</td></tr>';
        foreach ($find as $v) {
            echo '<tr><td>' . $v->name . '</td><td>' . $v->category . '</td><td>' . $v->price . '</td><td>' . $v->stock . '</td><td><button name="update" value="' . $v->_id . '" type="submit" >update</button></td></tr>';
        }
        echo '</table></form>';
    }
    function update()
    {
        $id = $_POST['update'];
        $connect = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $connect->test->products;
        $find = $collection->find(array("_id" => new MongoDB\BSON\ObjectID($id)));
        echo '<form action="change" method="POST" ><table id="table"><thead></thead><tbody>';
        foreach ($find as $v) {
            echo '<tr><td>NAME</td><td><input type="text" name="name" value="' . $v->name . '" ></td></tr>';
            echo '<tr><td>CATEGORY</td><td><input type="text" name="category" value="' . $v->category . '" ></td></tr>';
            echo '<tr><td>PRICE</td><td><input type="text" name="price" value="' . $v->price . '" ></td></tr>';
            echo '<tr><td>STOCK</td><td><input type="text" name="stock" value="' . $v->stock . '" ></td></tr>';
            echo '<tr><td>META FIELD</td><td><input type="text" name="meta1" value="' . $v->meta_fields[0] . '" ></td><td><input type="text" name="meta2" value="' . $v->meta_fields[1] . '" ></td></tr>';
            echo '<tr><td>VARIATIONS</td><td><input type="text" name="vari1" value="' . $v->Variations[0] . '" ></td><td><input type="text" name="vari2" value="' . $v->Variations[1] . '" ></td><td><input type="text" name="vari3" value="' . $v->Variations[2] . '" ></td></tr>';
            echo '<tr><td><button name="change" type="submit" value="' . $v->_id . '" >change</button></td></tr>';
        }
        echo '</tbody></table></form>';
    }
    function change()
    {
        $id = $_POST['change'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $meta1 = $_POST['meta1'];
        $meta2 = $_POST['meta2'];
        $vari1 = $_POST['vari1'];
        $vari2 = $_POST['vari2'];
        $vari3 = $_POST['vari3'];

        $connect = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $connect->test->products;
        $update = $collection->updateOne(
            array("_id" => new MongoDB\BSON\ObjectID($id)),
            ['$set' => [
                'name'     => $name,
                'category' => $category,
                'price'    => $price,
                'stock'    => $stock,
                'meta_fields'    => [$meta1,$meta2],
                'Variations'    => [$vari1,$vari2,$vari3]
            ]]

        );

        $collection = $connect->frontend->products;
        $update = $collection->updateOne(
            array("_id" => new MongoDB\BSON\ObjectID($id)),
            ['$set' => [
                'name'     => $name,
                'category' => $category,
                'price'    => $price,
                'stock'    => $stock,
                'meta_fields[0]'    => $meta1,
                'meta_fields[1]'    => $meta2,
                'Variations[0]'    => $vari1,
                'Variations[1]'    => $vari2,
                'Variations[2]'    => $vari3,
            ]]

        );
        header('Location: http://localhost:5000/admin/index');
    }
}