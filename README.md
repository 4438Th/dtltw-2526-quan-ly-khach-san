# Giới thiệu dự án: Quản lý khách sạn (DTLTW-2526)

## 1. Cấu trúc chính của project
- `index.php` — Front controller, entry point mọi request.
- `init.php` — Nạp hằng số và cấu hình chung (đường dẫn, DB, autoloader).
- `configs/` — Các file cấu hình: `database.php`, `routes.php`.
- `public/` — Tài nguyên tĩnh: CSS, JS, hình ảnh.
- `src/` — Mã nguồn chính:
	- `core/` — Cốt lõi (Router, BaseController, BaseModel,...)
	- `Modules/` — Các module (HomeModule, LabModule, ...). Mỗi module có `controllers/`, `models/`, `views/`.
	- `Share/` — View/partials dùng chung.
- `labs/` — Thư mục bài tập trên lớp thực hành.

## 2. Mô hình dự án & Kiến trúc
- Mô hình: MVC (Model-View-Controller)
	- Model: chứa logic truy xuất dữ liệu (PDO/Models). Các model thường nằm trong `src/Modules/*/models`.
	- View: giao diện, template PHP thuần nằm trong `src/Modules/*/views` và `Share/view` cho phần dùng chung.
	- Controller: xử lý request, gọi Model, trả View hoặc JSON. Các controllers nằm trong `src/Modules/*/controllers`.

- Kiến trúc theo tầng (layered architecture):
	1. Presentation (Views, static assets) — chịu trách nhiệm tương tác với người dùng.
	2. Application (Controllers, Router) — điều phối luồng xử lý, validate input, xử lý HTTP.
	3. Domain (Models, Business Logic) — xử lý nghiệp vụ, tương tác DB.
	4. Infrastructure (configs, core classes, public assets) — cung cấp kết nối DB, logging, file serving.

- Thành phần chính và vai trò:
	- `init.php`: khởi tạo hằng số (đường dẫn, BASE_URL), đăng ký autoloader và nạp file cấu hình.
	- `src/core/Router.php`: nhận URL, giải mã route, phục vụ file tĩnh nếu tồn tại, hoặc chuyển tới controller/action.
	- `src/core/BaseController.php`: cung cấp helper `render()`, `responseJson()` và các tiện ích cho controller.
	- `configs/routes.php`: khai báo các custom route (định tuyến tĩnh/động).
	- `configs/database.php`: cấu hình kết nối DB (được nạp qua `init.php`).

- Luồng xử lý (sequence):
	1. Request -> `index.php` -> `init.php` (nạp config, autoloader)
	2. `Router` kiểm tra file vật lý (serve static/PHP include) --> nếu không tồn tại, match `customRoutes` --> default routing `/module/controller/action`
	3. Controller xử lý, gọi Model (nếu cần), trả View hoặc JSON
	4. View render ra HTML, client nhận và hiển thị

- Các quy ước và best-practice hiện có trong project:
	- Tên module: `HomeModule`, `LabModule` (Router sẽ map URL đầu tiên sang module nếu folder tồn tại trong `src/Modules`).
	- Controller class namespace: `Modules\{ModuleName}\{ControllerName}` (ví dụ `Modules\Home\HomeController`).
	- Routes có thể định nghĩa phương thức HTTP và pattern (ví dụ `GET /api/rooms/{id}`).

## 3. Database
- Cấu hình DB nằm tại `configs/database.php`. `init.php` nạp hằng số `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `DB_NAME_LAB08`, `DB_CHARSET` để dùng toàn cục.
- Các file trong `labs/` đã được chỉnh để include `init.php` và dùng các hằng này.

## 4. Xử lý phương thức HTTP (PUT/DELETE) trên host hạn chế
- Hỗ trợ override method bằng:
	- Header `X-HTTP-Method-Override`
	- Trường ẩn `_method` trong form POST
	- Query param `_method`
 Ứng dụng ưu tiên header, sau đó `_method` trong POST, sau cùng `_method` trong REQUEST.