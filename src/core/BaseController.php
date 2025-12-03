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
        $viewPath = $modulePath . '/views/' . $viewName . '.php';
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
    /**
     * Gửi phản hồi JSON về client và kết thúc chương trình.
     * Đây là phương thức bị thiếu gây ra lỗi 'Undefined method'.
     * @param mixed $data Dữ liệu trả về (thường là mảng hoặc đối tượng).
     * @param int $statusCode Mã trạng thái HTTP.
     */
    protected function responseJson($data, $statusCode = 200)
    {
        // Thiết lập mã phản hồi HTTP
        http_response_code($statusCode);

        // Thiết lập Content-Type là JSON (Bắt buộc cho API)
        header('Content-Type: application/json');

        // Xuất dữ liệu đã được mã hóa JSON
        echo json_encode($data);

        // Ngăn chặn các xử lý không cần thiết sau đó
        exit;
    }

    /**
     * Lấy dữ liệu từ JSON request body (dùng cho POST, PUT, DELETE).
     * @return array|null Dữ liệu đã giải mã dưới dạng mảng kết hợp.
     */
    protected function getJsonRequestData()
    {
        // Đọc nội dung thô từ input stream
        $input = file_get_contents('php://input');

        // Giải mã JSON thành mảng kết hợp (tham số 'true')
        $data = json_decode($input, true);

        // Trả về dữ liệu (hoặc mảng rỗng nếu dữ liệu rỗng/lỗi)
        return $data ?? [];
    }
}
