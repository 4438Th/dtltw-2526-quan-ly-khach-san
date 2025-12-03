<?php

namespace Modules\Lab;

use core\BaseController;

class LabController extends BaseController
{
    public function index()
    {
        $this->render('Lab', 'lab', []);
    }
    public function detail($id = '', $name = '')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : $id;
        $name = isset($_GET['name']) ? $_GET['name'] : $name;
        echo 'id: ' . $id . '<br>';
        echo 'name: ' . $name . '<br>';
    }
}
