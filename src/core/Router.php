<?php

namespace core;

class Router
{
    private $__module;
    private $__controller;
    private $__action;
    private $__params;
    protected $config;

    function __construct()
    {
        // 1. Tải cấu hình
        $this->config = require ROOT_PATH . '/configs/routes.php';

        // 2. Thiết lập giá trị mặc định
        $this->__module = $this->config['defaultModule'];
        $this->__controller = $this->config['defaultController'];
        $this->__action = $this->config['defaultAction'];
        $this->__params = $this->config['defaultParams'];

        // 3. Xử lý URL
        $this->handleURL();
    }

    // Hàm xử lý url
    function handleURL()
    {
        // Nếu request trỏ tới file/tài nguyên tồn tại trên hệ thống, phục vụ trực tiếp
        $this->serveStaticIfExists();

        // Xử lý Custom Routes
        if ($this->handleCustomRoutes()) {
            return;
        }

        // Xử lý Default Routes
        $this->handleDefaultRoutes();
    }

    // Hàm xử lý CustomRoutes
    protected function handleCustomRoutes()
    {
        $url = $this->getURL();
        $method = $this->getHttpMethod();
        $customRoutes = $this->config['customRoutes'] ?? [];

        foreach ($customRoutes as $routeKey => $routeTarget) {

            // 1. Tách Phương thức và Pattern từ $routeKey (Ví dụ: "GET /api/rooms/{id}")
            $parts = explode(' ', $routeKey, 2);
            $routeMethod = strtoupper($parts[0]);
            $routePattern = $parts[1] ?? $parts[0]; // Nếu không có khoảng trắng, lấy toàn bộ

            // 2. Kiểm tra khớp Phương thức
            // Nếu phương thức trong route không khớp với phương thức request, bỏ qua
            if ($routeMethod !== $method) {
                continue;
            }

            // --- Logic khớp URL và tham số động ---

            // Xử lý trang chủ
            $currentUrl = $url === '' ? '/' : $url;

            // Chuẩn hóa Pattern (loại bỏ '/' ở đầu/cuối của Pattern)
            $trimmedPattern = trim($routePattern, '/');

            // 3. Xử lý Tham số Động ({id})
            // Biến {param} thành nhóm bắt (?P<param>[^\/]+) trong Regex
            $regexPattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^\/]+)', $trimmedPattern);

            // Tạo Regex hoàn chỉnh
            $pattern = '@^' . str_replace('/', '\/', $regexPattern) . '$@';

            // 4. Kiểm tra khớp Regex
            if (preg_match($pattern, $currentUrl, $matches)) {

                // 5. Trích xuất tham số
                $params = [];
                foreach ($matches as $key => $value) {
                    // Lấy các tham số được đặt tên (có key string)
                    if (is_string($key) && $key != '') {
                        $params[] = $value;
                    }
                }

                // 6. Thiết lập thuộc tính từ Custom Route
                $this->__module     = $routeTarget['module'];
                $this->__controller = $routeTarget['controller'];
                $this->__action     = $routeTarget['action'];
                // Gán tham số đã trích xuất
                $this->__params     = $params;

                $this->executeController();
                return true;
            }
        }
        return false;
    }

    //Xử lý DefaultRoutes
    function handleDefaultRoutes()
    {
        $url = $this->getURL();

        // 1. Xử lý trang chủ (URL rỗng)
        if ($url === '') {
            $this->executeController();
            return;
        }

        // 2. Tách URL thành mảng
        $urlArr = array_values(array_filter(explode('/', $url)));

        // Xử lý Module (Url[0])
        if (!empty($urlArr[0])) {
            $moduleName = ucfirst($urlArr[0]) . 'Module';
            if (is_dir(MODULES_PATH . '/' . $moduleName)) {
                $this->__module = $moduleName;
                unset($urlArr[0]);
                $urlArr = array_values($urlArr);
            }
        }

        // Xử lý Controller (Url[0]) - Lưu tên ngắn gọn
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
            unset($urlArr[0]);
            $urlArr = array_values($urlArr);
        }

        // Xử lý Action (Url[0])
        if (!empty($urlArr[0])) {
            $this->__action = $urlArr[0];
            unset($urlArr[0]);
        }

        // Xử lý Params
        $this->__params = array_values($urlArr);

        $this->executeController();
    }

    // --- Phương thức lấy URL đã chuẩn hóa ---
    function getURL()
    {
        // Lấy URL và loại bỏ query string
        $url = strtok($_SERVER['REQUEST_URI'], '?');

        // Loại bỏ dấu '/' ở đầu và cuối. Nếu là '/', kết quả là chuỗi rỗng ''
        return trim($url, '/');
    }

    // Nếu request tương ứng với file trên hệ thống, phục vụ file đó trực tiếp.
    protected function serveStaticIfExists()
    {
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $clean = trim($requestPath, '/');

        // Nếu là root, không phục vụ
        if ($clean === '') return;

        $fullPath = realpath(ROOT_PATH . '/' . $clean);
        if ($fullPath && is_file($fullPath) && strpos($fullPath, realpath(ROOT_PATH)) === 0) {
            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            // Nếu là PHP, include để thực thi bằng PHP engine (không xuất source)
            if ($ext === 'php') {
                include $fullPath;
                exit;
            }

            // Khác (ảnh, css, js, pdf...) -> gửi nội dung
            $mime = 'application/octet-stream';
            if (function_exists('mime_content_type')) {
                $t = mime_content_type($fullPath);
                if ($t) $mime = $t;
            }
            header('Content-Type: ' . $mime);
            header('Content-Length: ' . filesize($fullPath));
            readfile($fullPath);
            exit;
        }
    }

    // --- Phương thức lấy Phương thức HTTP đã chuẩn hóa ---
    function getHttpMethod()
    {
        // 1) Kiểm tra header X-HTTP-Method-Override (thường dùng cho AJAX/clients)
        $override = null;
        if (!empty($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            $override = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
        } elseif (function_exists('getallheaders')) {
            $headers = getallheaders();
            if (!empty($headers['X-HTTP-Method-Override'])) {
                $override = $headers['X-HTTP-Method-Override'];
            } elseif (!empty($headers['x-http-method-override'])) {
                $override = $headers['x-http-method-override'];
            }
        }
        if ($override) {
            return strtoupper($override);
        }

        // 2) Nếu là form HTML gửi POST nhưng kèm _method, dùng để mô phỏng PUT/DELETE
        if (isset($_POST['_method'])) {
            return strtoupper($_POST['_method']);
        }

        // 3) Cho phép override qua query string hoặc request param (ví dụ: ?_method=PUT)
        if (isset($_REQUEST['_method'])) {
            return strtoupper($_REQUEST['_method']);
        }

        // 4) Nếu không có override, trả về phương thức gốc
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    // --- Hàm thực thi Controller và Action ---
    private function executeController()
    {
        // 1. Xây dựng Tên Controller đầy đủ (thêm hậu tố)
        $controllerClassName = $this->__controller;
        // 2. Xây dựng Namespace và Tên Class đầy đủ (Modules\Auth\AuthController)
        $namespace = str_replace('Module', '', $this->__module);
        $fullClassName = "\\Modules\\$namespace\\" . $controllerClassName;
        // 3. Kiểm tra và khởi tạo Controller
        if (class_exists($fullClassName)) {
            $controllerInstance = new $fullClassName();
            // 4. Kiểm tra và gọi Action
            if (method_exists($controllerInstance, $this->__action)) {
                call_user_func_array([$controllerInstance, $this->__action], $this->__params);
                return;
            }
        }
        // Nếu không tìm thấy Controller hoặc Action hợp lệ
        $this->loadError('404');
    }

    // Hàm xử lý lỗi
    function loadError($errorName = '404')
    {
        header("HTTP/1.0 404 Not Found");
        // Giả định bạn có file 404.php trong thư mục SHARE_PATH/view/error/
        require_once SHARE_PATH . '/view/error/' . $errorName . '.php';
    }
}
