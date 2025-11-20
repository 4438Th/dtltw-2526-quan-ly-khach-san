<?php
require_once CONFIGS_PATH . '/route.php';
class Router
{
    private $__module,
        $__controller,
        $__action,
        $__params;
    function __construct()
    {
        global $route;
        // Thiết lập giá trị mặc định
        if (!empty($route['defaultModule'])) {
            $this->__module = $route['defaultModule'];
        }
        $this->__controller = $route['defaultController'];
        $this->__action = $route['defaultAction'];
        $this->__params = $route['defaultParams'];
        // Xử lý URL
        $this->handleURL();
    }

    function handleURL()
    {
        // Lấy URL từ request
        $url = $this->getURL();
        // Xử lý URL
        $urlArr = array_filter(explode('/', $url)); // Tách URL thành mảng
        $urlArr = array_values($urlArr); // Cài lại chỉ số mảng
        $namespace = str_replace('Module', '', $this->__module);
        // Xử lý module
        if (!empty($urlArr[0])) {
            $this->__module = ucfirst($urlArr[0]) . 'Module';
            $namespace = str_replace('Module', '', $this->__module);
            unset($urlArr[0]);
            $urlArr = array_values($urlArr);
        }
        // Xử lý controller
        $controllerClassName = $this->__controller;
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
            $controllerClassName = $this->__controller . 'Controller';
            unset($urlArr[0]);
            $urlArr = array_values($urlArr);
        }
        // Nạp file controller
        $controllerClassName = $this->__controller;
        $controllerFilePath = MODULES_PATH . '/' . $this->__module . '/controllers/' . $controllerClassName . '.php';
        $fullClassName = "\\Modules\\$namespace\\$controllerClassName";
        // Kiểm tra và nạp file controller
        if (file_exists($controllerFilePath)) {
            require_once $controllerFilePath;
            if (class_exists($fullClassName)) {
                // Khởi tạo đối tượng và gán vào __controller
                $this->__controller = new $fullClassName();
            } else {
                $this->loadError('404');
                return;
            }
        } else {
            $this->loadError('404');
            return;
        }

        // Xử lý action
        if (!empty($urlArr[0])) {
            $this->__action = $urlArr[0];
            unset($urlArr[0]);
        }
        // Xử lý params
        $this->__params = array_values($urlArr);
        // Gọi action
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError('404');
        }
    }
    function getURL()
    {
        // Lấy URL từ request
        if (!empty(($_SERVER['PATH_INFO']))) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }
    function loadError($errorName = '404')
    {
        require_once SHARE_PATH . '/view/error/' . $errorName . '.php';
    }
}
