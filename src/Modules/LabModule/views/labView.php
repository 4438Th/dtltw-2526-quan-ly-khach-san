<main>
    <div class="container py-4">
        <h1 class="mb-4">Danh sách Lab</h1>

        <?php if (!empty($labs) && is_array($labs)): ?>
            <div class="list-group">
                <?php foreach ($labs as $lab): ?>
                    <div class="list-group-item mb-3">
                        <h5 class="mb-2"><?php echo htmlspecialchars($lab['name']); ?></h5>
                        <?php if (!empty($lab['files'])): ?>
                            <ul class="mb-0">
                                <?php foreach ($lab['files'] as $file): ?>
                                    <?php
                                    // Dùng labsWebBase do controller truyền vào (nếu null thì fallback /labs/)
                                    $base = isset($labsWebBase) && $labsWebBase ? rtrim($labsWebBase, '/') . '/' : BASE_URL . 'labs/';
                                    $url = $base . rawurlencode($lab['name']) . '/' . rawurlencode($file);
                                    ?>
                                    <li>
                                        <a href="<?php echo $url; ?>" target="_blank"><?php echo htmlspecialchars($file); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="text-muted">(Không có file trong thư mục này)</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Không tìm thấy thư mục <strong>labs</strong> trong project. Vui lòng tạo thư mục <code>labs/</code> ở gốc dự án và bên trong mỗi tuần tạo một thư mục chứa file bài tập.</div>
        <?php endif; ?>
    </div>
</main>