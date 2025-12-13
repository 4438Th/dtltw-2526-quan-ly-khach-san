<div class="container mt-5">
    <div class="mb-3 text-end">
        <button id="addNewRoomBtn" class="btn btn-success shadow-sm rounded-pill me-2">
            <i class="fas fa-plus-circle"></i> Thêm phòng
        </button>
        <button id="refreshDataBtn" class="btn btn-primary shadow-sm rounded-pill">
            <i class="fas fa-sync-alt"></i> Làm mới
        </button>
    </div>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle rounded-3 overflow-hidden">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">Tên phòng</th>
                            <th class="text-center">Loại phòng</th>
                            <th class="text-center">Giá phòng</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody id="roomTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="roomFormModal" tabindex="-1" aria-labelledby="roomFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-success text-white border-0 rounded-top-4">
                <h5 class="modal-title" id="roomFormModalLabel"><i class="fas fa-plus-circle"></i> Thêm phòng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="roomForm" method="POST" action="<?php echo BASE_URL; ?>api/rooms">
                <input type="hidden" name="_method" id="_method" value="">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="roomName" class="form-label">Tên phòng:</label>
                        <input type="text" class="form-control" id="roomName" name="name" required placeholder="Ví dụ: Phòng A101">
                        <div class="invalid-feedback">Vui lòng nhập tên phòng.</div>
                    </div>
                    <div class="mb-3">
                        <label for="roomType" class="form-label">Loại phòng:</label>
                        <select class="form-select" id="roomType" name="type" required>
                            <option value="" disabled selected>Chọn loại phòng</option>
                            <option value="Đơn">Đơn</option>
                            <option value="Đôi">Đôi</option>
                            <option value="Gia Đình">Gia Đình</option>
                        </select>
                        <div class="invalid-feedback">Vui lòng chọn loại phòng.</div>
                    </div>
                    <div class="mb-3">
                        <label for="roomPrice" class="form-label">Giá phòng (VNĐ):</label>
                        <input type="number" class="form-control" id="roomPrice" name="price" required min="10000" placeholder="Ví dụ: 350000">
                        <div class="invalid-feedback">Giá phòng phải là số và tối thiểu 10000.</div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" id="submitRoomBtn">
                        <i class="fas fa-save"></i> Lưu Phòng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>