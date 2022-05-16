<?php

use Phalcon\Mvc\Controller;


class LoginController extends Controller
{

    function index()
    {
        $naman = 'naman';
        $this->view->naman = $naman;
    }
    function auth()
    {
        $email = $this->request->get('email');
        $password = $this->request->get('password');
        $connect = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@sandbox.j4aug.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $connect->test->users;
        $find = $collection->find(["email" => $email]);

        if ($find != null) {

            foreach ($find as $f) {

                if ($f->password == $password) {
                    // echo $f->role;die;
                    if ($f->role == 'admin') {
                        // echo $f->role;die;
                        // echo 'admin';die;
                        header('Location: http://localhost:8080/admin/index');
                        // $collection = $connect->test->orders;
                        // $find = $collection->find();
                        // echo '<table>';
                        // foreach ($find as $v) {
                        //     echo '<tr><td>' . $v->costumer_name . '</td><td>' . $v->name . '</td><td>' . $v->category . '</td><td>' . $v->price . '</td><td>' . $v->quantity . '</td><td>' . $v->status . '</td></tr>';
                        // }
                        // echo '</table>';
                    } else {
                        echo 'hello';die;
                        header('Location: http://localhost:8080/webhooks/index');
                    }
                } else {
                    echo 'wrong password';
                    die;
                }
            }
        } else {
            echo 'user not found';
            die;
        }
        echo '<br>';
    }
}
