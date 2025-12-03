<?php

namespace Modules\Home;

use core\BaseController;

class HomeController extends BaseController
{
    protected $roomModel;
    public function __construct()
    {
        $this->roomModel = new RoomModel();
    }
    // render giao diện
    public function index()
    {
        $this->render('Home', 'home', []);
    }
    //hàm lấy danh sách phòng
    public function getRooms()
    {
        $searchTerm = $_GET['search'] ?? '';

        if (!empty($searchTerm)) {
            // 2. Nếu có từ khóa tìm kiếm, gọi hàm tìm kiếm trong Model
            // *Cần đảm bảo RoomModel có phương thức searchRooms($searchTerm)*
            $rooms = $this->roomModel->searchRooms($searchTerm);
        } else {
            // 3. Nếu không có từ khóa, gọi hàm lấy tất cả như cũ
            $rooms = $this->roomModel->findAll();
        }

        // 4. Trả về kết quả JSON
        $this->responseJson($rooms, 200);
    }
    // hàm lấy thông tin của 1 phòng
    public function getRoom(int $id)
    {
        $room = $this->roomModel->findById($id);

        if (!$room) {
            $this->responseJson(['message' => 'Room not found'], 404);
            return;
        }
        $this->responseJson($room, 200);
    }
    // hàm tạo phòng
    public function createRoom()
    {
        // 1. Lấy dữ liệu JSON từ request body
        $data = $this->getJsonRequestData(); // Giả sử BaseController có phương thức này

        if (empty($data['name']) || empty($data['type']) || empty($data['price'])) {
            $this->responseJson(['message' => 'Missing required fields'], 400);
            return;
        }

        if ($this->roomModel->createRoom($data)) {
            $this->responseJson(['message' => 'Room created successfully'], 201); // 201 Created
        } else {
            $this->responseJson(['message' => 'Failed to create room'], 500);
        }
    }
    //hàm cập nhật phòng
    public function updateRoom(int $id)
    {
        $data = $this->getJsonRequestData();

        // 1. Kiểm tra phòng có tồn tại không
        if (!$this->roomModel->findById($id)) {
            $this->responseJson(['message' => 'Room not found'], 404);
            return;
        }

        // 2. Gọi Model để cập nhật (Cần thêm phương thức updateRoom trong RoomModel)
        // Ví dụ: $this->roomModel->updateRoom($id, $data)

        // GIẢ ĐỊNH: Bạn đã thêm logic update vào RoomModel
        if ($this->roomModel->updateRoom($id, $data)) {
            $this->responseJson(['message' => 'Room updated successfully'], 200);
        } else {
            $this->responseJson(['message' => 'Failed to update room'], 500);
        }
    }
    // hàm xóa phòng
    public function deleteRoom(int $id)
    {
        // 1. Kiểm tra phòng có tồn tại không
        if (!$this->roomModel->findById($id)) {
            $this->responseJson(['message' => 'Room not found'], 404);
            return;
        }

        // 2. Gọi Model để xóa (Cần thêm phương thức deleteRoom trong RoomModel)
        // Ví dụ: $this->roomModel->deleteRoom($id)

        // GIẢ ĐỊNH: Bạn đã thêm logic delete vào RoomModel
        if ($this->roomModel->deleteRoom($id)) {
            $this->responseJson(['message' => 'Room deleted successfully'], 200);
        } else {
            $this->responseJson(['message' => 'Failed to delete room'], 500);
        }
    }
}
