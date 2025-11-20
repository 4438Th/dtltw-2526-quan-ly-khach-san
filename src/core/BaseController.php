<?php

namespace core;

class BaseController
{
    protected $view;
    protected $model;

    public function __construct() {}

    //    Tải một lớp model.
    protected function loadModel($moduleName, $modelName)
    {
        $modulePath = MODULES_PATH . '/' . $moduleName . 'Module';
        $modelPath = $modulePath . 'models' . $modelName . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName();
        } else {
            throw new \Exception("Không tìm thấy file model: " . $modelPath);
        }
    }

    // Hiển thị một file view.
    protected function render($moduleName, $viewName, $data = [])
    {
        $modulePath = MODULES_PATH . '/' . $moduleName . 'Module';
        $viewPath = $modulePath . '/views/' . $viewName . '.html';
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            throw new \Exception("Không tìm thấy file view: " . $viewPath);
        }
    }

    // Chuyển hướng đến một URL khác
    protected function redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
}
