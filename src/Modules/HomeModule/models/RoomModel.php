<?php

namespace Modules\Home;

use core\BaseModel;

class RoomModel extends BaseModel
{
    public function __construct()
    {
        // Khởi tạo Base Model để thiết lập kết nối DB và tên bảng
        parent::__construct();
    }

    /**
     * Thêm một phòng mới vào bảng 'rooms'. (Create)
     *
     * @param array $data Mảng chứa dữ liệu phòng (name, type, price).
     * @return bool True nếu thành công.
     */
    public function createRoom(array $data)
    {
        $sql = "INSERT INTO {$this->table} (name, type, price) VALUES (?, ?, ?)";

        $params = [
            $data['name'],
            $data['type'],
            $data['price']
        ];

        return $this->execute($sql, $params);
    }

    /**
     * Cập nhật thông tin của một phòng dựa trên ID. (Update)
     *
     * @param int $id ID của phòng cần cập nhật.
     * @param array $data Mảng chứa dữ liệu cần cập nhật (name, type, price).
     * @return bool True nếu thành công.
     */
    public function updateRoom(int $id, array $data)
    {
        // Sử dụng Prepared Statements để cập nhật an toàn
        $sql = "UPDATE {$this->table} SET name = ?, type = ?, price = ? WHERE id = ?";

        $params = [
            $data['name'],
            $data['type'],
            $data['price'],
            $id // ID luôn là tham số cuối cùng trong trường hợp này
        ];

        return $this->execute($sql, $params);
    }

    /**
     * Xóa một phòng dựa trên ID. (Delete)
     *
     * @param int $id ID của phòng cần xóa.
     * @return bool True nếu thành công.    
     */
    public function deleteRoom(int $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";

        $params = [$id];

        return $this->execute($sql, $params);
    }

    /**
     * Tìm kiếm phòng theo Tên hoặc Loại Phòng.
     * @param string $searchTerm Giá trị tìm kiếm
     * @return array Danh sách phòng khớp
     */
    public function searchRooms($searchTerm)
    {
        // 1. Chuẩn bị SQL
        $sql = "SELECT id, name, type, price 
                FROM {$this->table} 
                WHERE LOWER(name) LIKE ? OR LOWER(type) LIKE ?";

        // 2. Tạo chuỗi tìm kiếm dạng '%giá_trị%'
        $searchPattern = '%' . $searchTerm . '%';

        // 3. Chuẩn bị các tham số cho truy vấn
        $params = [
            $searchPattern, // cho name LIKE ?
            $searchPattern  // cho type LIKE ?
        ];

        // 4. Sử dụng phương thức $this->query() của BaseModel
        // Hàm query sẽ xử lý prepare, execute và fetchAll, đồng thời bắt PDOException
        try {
            return $this->query($sql, $params);
        } catch (\Exception $e) {
            // Log lỗi hoặc xử lý lỗi nếu cần
            error_log("Lỗi truy vấn tìm kiếm (RoomModel): " . $e->getMessage());
            return [];
        }
    }
}
