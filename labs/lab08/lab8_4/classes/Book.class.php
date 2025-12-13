<?php
// Lớp Book kế thừa từ lớp Db (đã định nghĩa trước đó)
// => có thể sử dụng các phương thức kết nối và truy vấn CSDL của Db
class Book extends Db
{
	// Hàm lấy ngẫu nhiên $n quyển sách từ bảng book
	public function getRand($n)
	{
		// Câu lệnh SQL: chọn các cột book_id, book_name, img
		// sắp xếp ngẫu nhiên (order by rand()) và giới hạn số lượng $n
		$sql = "select book_id, book_name, img from book order by rand() limit 0, $n ";
		// Gọi phương thức select() của lớp Db để thực thi câu lệnh
		return $this->select($sql);
	}

	// Hàm lấy sách theo mã nhà xuất bản
	public function getByPubliser($manhaxb)
	{
		$sql = "select book_id, book_name, img 
            from book 
            where pub_id = :manhaxb 
            order by rand()";
		return $this->select($sql, [":manhaxb" => $manhaxb]);
	}
	//Lấy tất cả
	public function getAll()
	{
		$sql = "select * from book";
		return $this->select($sql);
	}

	//Xóa theo id
	public function deleteById($book_id)
	{
		$arr = array(":book_id" => $book_id);
		$sql = "delete from book where book_id = :book_id";
		return $this->delete($sql, $arr);
	}

	//Thêm
	public function create($book_id, $book_name)
	{
		$arr = array(":book_id" => $book_id, ":book_name" => $book_name);
		$sql = "insert into book(book_id, book_name) values(:book_id, :book_name)";
		return $this->insert($sql,$arr);
	}
}
