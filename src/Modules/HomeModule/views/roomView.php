<main>
  <div class="container">
    <?php
    include SRC_PATH . '/Modules/HomeModule/views/roomList.php';
    ?>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // ************************************************
  // ĐỊNH NGHĨA CHUNG VÀ BIẾN
  // ************************************************
  const BASE_URL_JS = '<?php echo BASE_URL; ?>';
  // --- Khai báo các Element ---
  const navSearchForm = document.getElementById('navSearchForm');
  const searchInput = navSearchForm.querySelector('input[type="search"]');
  const roomTableBody = document.getElementById('roomTableBody');
  const refreshDataBtn = document.getElementById('refreshDataBtn');
  const roomFormModalElement = document.getElementById('roomFormModal');
  const roomForm = document.getElementById('roomForm');
  const submitRoomBtn = document.getElementById('submitRoomBtn');
  const addNewRoomBtn = document.getElementById('addNewRoomBtn');
  const roomFormModal = new bootstrap.Modal(roomFormModalElement);
  let currentRoomId = null;

  // ************************************************
  // HÀM HỖ TRỢ
  // ************************************************

  //Định dạng tiền tệ
  function formatCurrencyJS(amount) {
    if (typeof amount !== 'number') {
      amount = parseFloat(amount);
    }
    return amount.toLocaleString('vi-VN');
  }

  //Thông báo thành công
  function showSuccessToast(message) {
    alert(message);
  }
  //Thông báo lỗi
  function showErrorToast(message) {
    alert(message);
  }

  // Hàm tạo hàng trên danh sách
  function createRoomRow(room) {
    const priceFormatted = formatCurrencyJS(room.price);
    const roomNameEscaped = room.name.replace(/'/g, "\\'");

    return `
            <tr>
                <td class="text-center">${room.name}</td>
                <td class="text-center">${room.type}</td>
                <td class="text-center">${priceFormatted} VNĐ</td>
                <td class="text-center btn-action-group">
                    <button class="btn btn-sm btn-warning text-white btn-action"
                        onclick="handleAction('Sửa', ${room.id}, '${roomNameEscaped}')"
                        title="Chỉnh sửa phòng">
                        <i class="bi bi-pencil-square"></i> Sửa
                    </button>
                    <button class="btn btn-sm btn-danger btn-action"
                        onclick="handleAction('Xóa', ${room.id}, '${roomNameEscaped}')"
                        title="Xóa phòng">
                        <i class="bi bi-trash"></i> Xóa
                    </button>
                </td>
            </tr>
        `;
  }

  // Hàm load danh sách phòng
  async function loadRooms(searchTerm = '') {
    roomTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-primary py-4">
                                            <i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...
                                          </td></tr>`;
    refreshDataBtn.disabled = true;

    try {
      const url = new URL(`${BASE_URL_JS}api/rooms`);
      if (searchTerm) {
        url.searchParams.append('search', searchTerm);
      }
      const response = await fetch(url, {
        method: 'GET'
      });

      if (!response.ok) {
        throw new Error('Lỗi khi tải dữ liệu: ' + response.statusText);
      }

      const rooms = await response.json();

      let htmlContent = '';
      if (rooms.length > 0) {
        rooms.forEach(room => {
          htmlContent += createRoomRow(room);
        });
      } else {
        htmlContent = `<tr><td colspan="4" class="text-center text-muted py-4">
                                        Không tìm thấy dữ liệu phòng nào.</td></tr>`;
      }

      roomTableBody.innerHTML = htmlContent;

    } catch (error) {
      roomTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-danger py-4">
                                                Lỗi kết nối hoặc tải dữ liệu.</td></tr>`;
    } finally {
      refreshDataBtn.disabled = false;
    }
  }

  // ************************************************
  // XỬ LÝ LOGIC
  // ************************************************

  //Xử lý thêm phòng
  async function createRoom(roomData) {
    submitRoomBtn.disabled = true;
    submitRoomBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang Lưu...';

    try {
      const response = await fetch(`${BASE_URL_JS}api/rooms`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(roomData)
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Lỗi không xác định khi tạo phòng.');
      }

      const result = await response.json();

      showSuccessToast('Thêm phòng thành công!')
      roomFormModal.hide();
      await loadRooms();

    } catch (error) {
      showErrorToast('Lỗi khi thêm phòng: ' + error.message);
    } finally {
      submitRoomBtn.disabled = false;
      submitRoomBtn.innerHTML = '<i class="fas fa-save"></i> Lưu Phòng';
    }
  }
  //Xử lý sửa phòng
  async function updateRoom(id, roomData) {
    submitRoomBtn.disabled = true;
    submitRoomBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang Cập Nhật...';

    try {
      // Sử dụng API PUT hoặc PATCH, tùy thuộc vào thiết kế backend của bạn
      // Một số host chặn PUT/PATCH; gửi POST và override method qua header/query
      const updateUrl = `${BASE_URL_JS}api/rooms/${id}?_method=PUT`;
      const response = await fetch(updateUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-HTTP-Method-Override': 'PUT'
        },
        body: JSON.stringify(roomData)
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Lỗi không xác định khi cập nhật phòng.');
      }

      showSuccessToast('Cập nhật phòng thành công!');

      roomFormModal.hide();
      await loadRooms();

    } catch (error) {
      showErrorToast('Lỗi khi cập nhật phòng: ' + error.message);
    } finally {
      submitRoomBtn.disabled = false;
      submitRoomBtn.innerHTML = '<i class="fas fa-save"></i> Lưu Phòng';
    }
  }
  // Xử lý xóa phòng
  async function handleDelete(id, name) {
    if (!confirm(`Bạn có chắc chắn muốn xóa phòng "${name}" không?`)) {
      return;
    }

    try {
      const deleteUrl = `${BASE_URL_JS}api/rooms/${id}`;

      // Dùng POST với override để tương thích free host chặn DELETE
      const fallbackUrl = `${deleteUrl}?_method=DELETE`;
      const response = await fetch(fallbackUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-HTTP-Method-Override': 'DELETE'
        }
      });

      const result = await response.json();

      if (response.ok) {
        showSuccessToast(`Xóa phòng thành công!`);
        await loadRooms();
      } else {
        showErrorToast(`Lỗi: Không thể xóa phòng. ${result.message || 'Lỗi server.'}`);
      }

    } catch (error) {
      showErrorToast('Đã xảy ra lỗi kết nối khi xóa phòng.');
    }
  }
  // Hàm tải chi tiết phòng bằng ID
  async function getRoomDetails(id) {
    try {
      const response = await fetch(`${BASE_URL_JS}api/rooms/${id}`, {
        method: 'GET'
      });
      if (!response.ok) {
        throw new Error('Không tìm thấy phòng.');
      }
      return await response.json();
    } catch (error) {
      showErrorToast('Lỗi khi tải chi tiết phòng.');
      return null;
    }
  }
  //Xử lý nút sửa và xóa
  async function handleAction(actionType, id, name) {
    if (actionType === 'Xóa') {
      handleDelete(id, name);
    } else if (actionType === 'Sửa') {

      // 1. Tải dữ liệu chi tiết phòng
      const room = await getRoomDetails(id);

      if (room) {
        // 2. Đặt ID phòng hiện tại
        currentRoomId = id;

        // 3. Đổ dữ liệu vào form
        document.getElementById('roomName').value = room.name;
        document.getElementById('roomType').value = room.type;
        document.getElementById('roomPrice').value = room.price;

        // 4. Cập nhật tiêu đề và nút
        document.getElementById('roomFormModalLabel').textContent = `Sửa Phòng: ${name}`;
        submitRoomBtn.classList.remove('btn-success');
        submitRoomBtn.classList.add('btn-primary');
        submitRoomBtn.innerHTML = '<i class="fas fa-save"></i> Cập Nhật';

        // Thiết lập _method và action của form để fallback (non-AJAX)
        var hiddenMethod = document.getElementById('_method');
        if (hiddenMethod) hiddenMethod.value = 'PUT';
        roomForm.action = `${BASE_URL_JS}api/rooms/${id}`;

        // 5. Mở Modal
        roomFormModal.show();
      }
    }
  }


  // ************************************************
  // XỬ LÝ SỰ KIỆN
  // ************************************************

  // Xử lý mở modal bằng JS
  addNewRoomBtn.addEventListener('click', function() {
    // Chuẩn bị form cho tạo mới
    currentRoomId = null;
    var hiddenMethod = document.getElementById('_method');
    if (hiddenMethod) hiddenMethod.value = '';
    roomForm.action = `${BASE_URL_JS}api/rooms`;
    roomFormModal.show();
  });

  // Xử lý sự kiện Click trên nút Lưu (submitRoomBtn)
  submitRoomBtn.addEventListener('click', async function(e) {

    if (!roomForm.checkValidity()) {
      roomForm.classList.add('was-validated');
      return;
    }

    const roomData = {
      name: document.getElementById('roomName').value.trim(),
      type: document.getElementById('roomType').value,
      price: parseInt(document.getElementById('roomPrice').value, 10)
    };

    // Phân biệt gọi Create hay Update
    if (currentRoomId) {
      await updateRoom(currentRoomId, roomData);
    } else {
      await createRoom(roomData);
    }
  });

  // Reset form và trạng thái khi modal đóng
  roomFormModalElement.addEventListener('hidden.bs.modal', function() {
    roomForm.reset();
    roomForm.classList.remove('was-validated');

    // Reset trạng thái Sửa/Tạo Mới
    currentRoomId = null;
    document.getElementById('roomFormModalLabel').textContent = 'Thêm Phòng Mới';

    // Reset nút về trạng thái Tạo Mới
    submitRoomBtn.classList.remove('btn-primary');
    submitRoomBtn.classList.add('btn-success');
    submitRoomBtn.innerHTML = '<i class="fas fa-save"></i> Lưu Phòng';
    // Reset hidden method and action (fallback)
    var hiddenMethod = document.getElementById('_method');
    if (hiddenMethod) hiddenMethod.value = '';
    roomForm.action = `${BASE_URL_JS}api/rooms`;
  });

  // Xử lý sự kiện tìm kiếm
  navSearchForm.addEventListener('submit', function(e) {
    e.preventDefault(); // Ngăn chặn form submit theo cách truyền thống (tải lại trang)

    const searchTerm = searchInput.value.trim();
    loadRooms(searchTerm); // Gọi hàm loadRooms với tham số tìm kiếm
  });

  // Xử lý sự kiện nút Refresh
  refreshDataBtn.addEventListener('click', function() {
    // 1. Xóa nội dung trong ô tìm kiếm
    searchInput.value = '';

    // 2. Gọi hàm loadRooms() mà không truyền tham số (mặc định là '')
    loadRooms();
  });

  // Tải dữ liệu khi load trang
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Xóa nội dung trong ô tìm kiếm
    searchInput.value = '';

    // 2. Gọi hàm loadRooms() mà không truyền tham số (mặc định là '')
    loadRooms();
  });
</script>