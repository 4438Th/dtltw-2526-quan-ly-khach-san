<?php

namespace Modules\Home;

use core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $this->render('Home', 'index', []);
    }
    public function detail($id = '', $name = '')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : $id;
        $name = isset($_GET['name']) ? $_GET['name'] : $name;
        echo 'id: ' . $id . '<br>';
        echo 'name: ' . $name . '<br>';
    }
}
