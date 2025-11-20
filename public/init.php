<?php
define('ROOT_PATH', dirname(__DIR__)); // Đường dẫn tới thư mục gốc
require_once ROOT_PATH . '/configs/route.php';
require_once CORE_PATH . '/Router.php';
function coreAutoloader($className)
{
    if (strpos($className, 'core\\') === 0) {

        // 2. Loại bỏ Namespace 'core\' để lấy tên lớp thuần
        $className = str_replace('core\\', '', $className);

        // 3. Xây dựng đường dẫn file
        // Ví dụ: core\BaseController -> CORE_PATH/BaseController.php
        $file = CORE_PATH . '/' . $className . '.php';

        // 4. Nhúng file nếu nó tồn tại
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
