<?php

namespace core;

use \PDO;
use \PDOException;

abstract class BaseModel
{
    protected $db;          // Đối tượng PDO connection
    protected $table;       // Tên bảng mặc định
    protected $className;   // Tên lớp (cho fetch object)

    public function __construct()
    {
        // Tên bảng mặc định sẽ được lấy từ tên class con (ví dụ: RoomModel -> rooms)
        // Bạn có thể ghi đè biến $this->table trong các Model con
        if (empty($this->table)) {
            $this->table = strtolower(str_replace('Model', '', (new \ReflectionClass($this))->getShortName())) . 's';
        }

        // Tên lớp hiện tại
        $this->className = get_class($this);

        $this->connect();
    }

    /**
     * Thiết lập kết nối PDO.
     */
    protected function connect()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Quan trọng: Ném ra Exception khi có lỗi SQL
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Quan trọng: Sử dụng Prepared Statements thực
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mặc định trả về mảng kết hợp
        ];

        try {
            $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối
            die("Lỗi kết nối database: " . $e->getMessage());
        }
    }

    /**
     * Thực thi truy vấn SELECT cơ bản.
     * * @param string $sql Câu lệnh SQL
     * @param array $params Tham số cho Prepared Statement
     * @return array Kết quả truy vấn
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Log lỗi hoặc ném lại Exception
            throw new \Exception("Lỗi truy vấn SQL: " . $e->getMessage());
        }
    }

    /**
     * Tìm tất cả các bản ghi.
     * * @return array
     */
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql);
    }

    /**
     * Tìm một bản ghi theo ID.
     * * @param int $id ID của bản ghi
     * @return mixed Bản ghi hoặc null
     */
    public function findById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->query($sql, [$id]);
        return $result[0] ?? null;
    }

    /**
     * Thực thi các truy vấn INSERT, UPDATE, DELETE.
     *
     * @param string $sql Câu lệnh SQL
     * @param array $params Tham số cho Prepared Statement
     * @return bool
     */
    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new \Exception("Lỗi thực thi SQL: " . $e->getMessage());
        }
    }
}
