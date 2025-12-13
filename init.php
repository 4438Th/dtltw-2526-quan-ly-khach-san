<?php
// WEB ROOT PATH
if (!defined('BASE_URL')) {
    // Xác định giao thức (http/https)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

    // Lấy tên miền đã cấu hình
    $host = $_SERVER['HTTP_HOST'];

    // Vì Document Root trỏ vào public/ => BASE_URL là tên miền gốc
    define('BASE_URL', $protocol . '://' . $host . '/');
}
// BASE_ASSETS_URL
if (!defined('BASE_ASSETS_URL')) {
    define('BASE_ASSETS_URL', BASE_URL . 'public/assets/');
}
// LOCAL ROOT PATH
define('ROOT_PATH', __DIR__); // Đường dẫn tới thư mục gốc tại local
define('CONFIGS_PATH', ROOT_PATH . '/configs');
define('SRC_PATH', ROOT_PATH . '/src');
define('CORE_PATH', SRC_PATH . '/core');
define('MODULES_PATH', SRC_PATH . '/Modules');
define('SHARE_PATH', SRC_PATH . '/Share');
// Yêu cầu cấc file cấu hình
require_once CONFIGS_PATH . '/database.php';
require_once CORE_PATH . '/Router.php';
// Hàm tự động load core
// --- Hàm Autoloader ---
function coreAutoloader($className)
{
    // Chuyển đổi dấu \ thành /
    $className = str_replace('\\', '/', $className);

    // 1. Xử lý Namespace 'core\' (Router, BaseController...)
    if (strpos($className, 'core/') === 0) {
        $className = str_replace('core/', '', $className);
        $file = CORE_PATH . '/' . $className . '.php';

        // 2. Xử lý Namespace 'Modules\' (Controller, Model)
    } elseif (strpos($className, 'Modules/') === 0) {

        // Tách chuỗi: Modules/Home/RoomModel
        $parts = explode('/', $className); // parts = ['Modules', 'Home', 'RoomModel']

        // Loại bỏ phần tử 'Modules'
        array_shift($parts); // parts = ['Home', 'RoomModel']

        $moduleName = array_shift($parts) . 'Module'; // => HomeModule (VD: HomeModule)
        $classNameOnly = array_pop($parts); // => RoomModel (VD: RoomModel)

        // Xác định loại Class (Controller/Model) và đường dẫn thư mục
        $typePath = '';
        if (strpos($classNameOnly, 'Controller') !== false) {
            $typePath = 'controllers/';
        } elseif (strpos($classNameOnly, 'Model') !== false) {
            $typePath = 'models/';
        }

        // Xây dựng đường dẫn file hoàn chỉnh
        // Ví dụ: MODULES_PATH/HomeModule/models/RoomModel.php
        $file = MODULES_PATH . '/' . $moduleName . '/' . $typePath . $classNameOnly . '.php';
    } else {
        return false;
    }

    // Nhúng file nếu tồn tại
    if (file_exists($file)) {
        require_once $file;
        return true;
    }

    return false;
}

// Đăng ký Autoloader
spl_autoload_register('coreAutoloader');
