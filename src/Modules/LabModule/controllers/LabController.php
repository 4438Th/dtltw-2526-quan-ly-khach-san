<?php

namespace Modules\Lab;

use core\BaseController;

class LabController extends BaseController
{
    public function index()
    {
        // Tìm thư mục labs theo thứ tự ưu tiên:
        // 1. src/Modules/LabModule/labs
        // 2. ROOT_PATH/labs
        // 3. ROOT_PATH/public/labs
        $candidates = [
            MODULES_PATH . '/LabModule/labs',
            ROOT_PATH . '/labs',
            ROOT_PATH . '/public/labs'
        ];

        $labsRoot = null;
        $labsWebBase = null; // web path prefix to generate links

        foreach ($candidates as $cand) {
            if (is_dir($cand)) {
                $labsRoot = $cand;
                // xác định web base
                if (strpos(realpath($cand), realpath(ROOT_PATH . '/public')) === 0) {
                    // nằm trong public -> web path relative to BASE_URL
                    $labsWebBase = BASE_URL . ltrim(str_replace(realpath(ROOT_PATH . '/public'), '', realpath($cand)), '/\\') . '/';
                } elseif (strpos(realpath($cand), realpath(MODULES_PATH)) === 0) {
                    // nằm trong src/Modules -> web path is src/Modules/... since document root is project root
                    $relative = str_replace(realpath(ROOT_PATH) . DIRECTORY_SEPARATOR, '', realpath($cand));
                    $labsWebBase = BASE_URL . str_replace('\\', '/', $relative) . '/';
                } else {
                    // nằm ở project root (ROOT_PATH/labs)
                    $relative = str_replace(realpath(ROOT_PATH) . DIRECTORY_SEPARATOR, '', realpath($cand));
                    $labsWebBase = BASE_URL . str_replace('\\', '/', $relative) . '/';
                }
                break;
            }
        }

        $labs = [];
        if ($labsRoot) {
            $entries = scandir($labsRoot);
            foreach ($entries as $entry) {
                if ($entry === '.' || $entry === '..') continue;
                $entryPath = $labsRoot . '/' . $entry;
                if (is_dir($entryPath)) {
                    $files = array_values(array_filter(scandir($entryPath), function ($f) use ($entryPath) {
                        return $f !== '.' && $f !== '..' && is_file($entryPath . '/' . $f);
                    }));
                    $labs[] = [
                        'name' => $entry,
                        'files' => $files
                    ];
                }
            }
        }

        $this->render('Lab', 'lab', ['labs' => $labs, 'labsWebBase' => $labsWebBase]);
    }


    public function detail($id = '', $name = '')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : $id;
        $name = isset($_GET['name']) ? $_GET['name'] : $name;
        echo 'id: ' . $id . '<br>';
        echo 'name: ' . $name . '<br>';
    }
}
