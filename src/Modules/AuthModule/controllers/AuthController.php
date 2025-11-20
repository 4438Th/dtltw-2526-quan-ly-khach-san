<?php

namespace Modules\Auth;

use core\BaseController;

class AuthController extends BaseController
{
    public function index()
    {
        $this->render('Auth', 'signup', []);
    }
    public function detail($id = '', $name = '')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : $id;
        $name = isset($_GET['name']) ? $_GET['name'] : $name;
        echo 'id: ' . $id . '<br>';
        echo 'name: ' . $name . '<br>';
    }
}
