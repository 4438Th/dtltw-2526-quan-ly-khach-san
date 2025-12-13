<?php
header("Content-Type: text/html; charset=UTF-8");
$url = 'https://vietnamnet.vn/';

//xử dụng file_get_contents để tải trang:
$html = file_get_contents($url);
// Tạo đối tượng DOMDocument để phân tích HTML
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($html);

// Tìm các tiêu đề tin tức
$xpath = new DOMXPath($doc);

// XPath chính: lấy <a> bên trong <h3 class="horizontalPost__main-title vnn-title ">
$nodes = $xpath->query('//h3[@class="horizontalPost__main-title vnn-title "]/a');

echo "<h3>Tiêu đề tin trang VietNamNet:</h3>";
if ($nodes->length > 0) {
    foreach ($nodes as $node) {
        $title = trim($node->nodeValue);
        /** @var DOMelement $node  */   // Khai báo kiểu cho biến $node
        $link = $node->getAttribute('href');
        echo "<p><a href='$link' target='_blank'>$title</a></p>";
    }
} else {
    echo "<p>Không tìm thấy tiêu đề nào. Kiểm tra lại XPath hoặc cấu trúc HTML.</p>";
}
