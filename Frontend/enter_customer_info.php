<?php
// Nhận dữ liệu từ form trước đó
$flight_id = $_GET['flight_id'] ?? null;
$adults_amount = $_GET['adults_amount'] ?? 0;
$children_amount = $_GET['children_amount'] ?? 0;

require('../db/conn.php');

$sql_str = "SELECT * FROM Flights JOIN Airlines 
            ON Flights.airline_id = Airlines.airline_id
            WHERE Flights.flight_id = ?";
$stmt = $conn->prepare($sql_str);
$stmt->bind_param("i", $flight_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $flight_number = $row['flight_number'];
    $departure_airport = $row['departure_airport'];
    $arrival_airport = $row['arrival_airport'];
    $departure_time = $row['departure_time'];
    $arrival_time = $row['arrival_time'];
    $airline_name = $row['name'];
    $adult_price = $row['adult_price'];
    $child_price = $row['child_price'];
}
//tổng tiền
$total_price = $adults_amount * $adult_price + $children_amount *  $child_price;
// Chuẩn bị mảng hành khách theo thứ tự Người lớn, Trẻ em
$passengers = array_merge(
    array_fill(0, $adults_amount, "Người lớn"),
    array_fill(0, $children_amount, "Trẻ em")
);

// Danh sách quốc tịch phổ biến
$countries = [
    "Vietnam" => "Việt Nam",
    "United States" => "Hoa Kỳ",
    "United Kingdom" => "Anh",
    "Australia" => "Úc",
    "Canada" => "Canada",
    "China" => "Trung Quốc",
    "France" => "Pháp",
    "Germany" => "Đức",
    "Japan" => "Nhật Bản",
    "South Korea" => "Hàn Quốc",
    "India" => "Ấn Độ",
    "Thailand" => "Thái Lan"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Khách Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
        }
        .container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }
        h2 {
            color: #007bff;
            font-weight: bold;
        }
        h5 {
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .rounded {
            border: 1px solid #ced4da;
        }
        .header-bar {
            background-color: #007bff;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-bar img {
            height: 40px;
        }
    </style>
</head>
<body>
<div class="header-bar">
    <div>
        <img src="your-logo-url.png" alt="Logo">
    </div>
    <div class="hotline">
        <span><i class="fas fa-phone-alt"></i> Hotline: <strong>123-456-7890</strong></span>
    </div>
</div>

<div class="container">
    <h2 class="text-center"><i class="fas fa-user"></i> Thông Tin Khách Hàng</h2>
    <p class="text-center">
        Số Hiệu Chuyến Bay: <strong><?= htmlspecialchars($flight_number) ?></strong>
        <br> 
        Hãng Hàng Không: <strong><?= htmlspecialchars($airline_name) ?></strong> 
        <br>
        Khởi Hành: <strong><?= htmlspecialchars($departure_airport) ?></strong> -
        Đến:  <strong><?= htmlspecialchars($arrival_airport) ?></strong>
        <br>
        Ngày đi: <strong><?= htmlspecialchars($departure_time) ?></strong> -
        Ngày đến:  <strong><?= htmlspecialchars($arrival_time) ?></strong>
    </p>

    <form action="payment.php" method="POST">
        <input type="hidden" name="flight_id" value="<?= htmlspecialchars($flight_id) ?>">
        <input type="hidden" name="adults_amount" value="<?= htmlspecialchars($adults_amount) ?>">
        <input type="hidden" name="children_amount" value="<?= htmlspecialchars($children_amount) ?>">
        <h4 class="mt-4">Thông Tin Hành Khách</h4>
        <?php foreach ($passengers as $index => $passenger_type): ?>
            <div class="mb-4 p-3 rounded">
                <h5>Hành khách <?= $index + 1 ?> - <?= $passenger_type ?></h5>
                <div class="row">
                    <div class="col-md-4">
                        <label for="first_name_<?= $index ?>" class="form-label">Họ</label>
                        <input type="text" class="form-control" id="first_name_<?= $index ?>" name="passengers[<?= $index ?>][first_name]" 
                                oninput="get_Ten()" required>
                    </div>
                    <div class="col-md-4">
                        <label for="last_name_<?= $index ?>" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="last_name_<?= $index ?>" name="passengers[<?= $index ?>][last_name]" 
                                oninput="get_Ten()" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Giới tính</label>
                        <select class="form-select" name="passengers[<?= $index ?>][gender]" required>
                            <option value="Male">Nam</option>
                            <option value="Female">Nữ</option>
                            <option value="Other">Khác</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="dob_<?= $index ?>" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="dob_<?= $index ?>" name="passengers[<?= $index ?>][dob]" required>
                    </div>
                    <div class="col-md-4">
                        <label for="phone_number_<?= $index ?>" class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control" id="phone_number_<?= $index ?>" name="passengers[<?= $index ?>][phone_number]" 
                            oninput="get_Phone()" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="passport_number<?= $index ?>" class="form-label">Passport</label>
                        <input type="text" class="form-control" id="passport_number<?= $index ?>" name="passengers[<?= $index ?>][passport_number]" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nationality_<?= $index ?>" class="form-label">Quốc Tịch</label>
                        <select class="form-select" id="nationality_<?= $index ?>" name="passengers[<?= $index ?>][nationality]" required>
                            <?php foreach ($countries as $key => $value): ?>
                                <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($value) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="email_<?= $index ?>" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_<?= $index ?>" name="passengers[<?= $index ?>][email]" 
                            oninput="get_Email()"required>
                    </div>
                </div>              
            </div>
        <?php endforeach; ?>

        <h4 class="mt-4">Thông Tin Liên Hệ</h4>
        <div class="mb-4 p-3 rounded">
            <div class="row">            
                <div class="col-md-4">
                    <label for="contact_name" class="form-label">Họ Tên</label>
                    <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                    <script>
                        function get_Ten(){
                            const ho = document.getElementById('first_name_0').value;
                            const ten = document.getElementById('last_name_0').value;
                            document.getElementById('contact_name').value = ho + ' ' + ten;
                        }
                    </script>
                       
                </div>
                <div class="col-md-6">
                    <label for="contact_phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                    <script>
                        function get_Phone(){
                            const sdt = document.getElementById('phone_number_0').value;
                            document.getElementById('contact_phone').value = sdt;
                        }
                    </script>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="contact_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                    <script>
                        function get_Email(){
                            const email = document.getElementById('email_0').value;
                            document.getElementById('contact_email').value = email;
                        }
                    </script>
                </div>
                <div class="col-md-6">
                    <label for="contact_diachi" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="contact_diachi" name="contact_diachi" required>
                </div>
            </div>
        </div>
    
        <div>
            <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price) ?>">
            Tổng Tiền:<?php echo " " . $total_price ." VND"?> 
        </div>
        <br>
        <!-- <button type="submit" class="btn btn-primary">Thanh Toán</button> -->
        <button type="submit" class="btn btn-primary">Tiếp tục</button>
        <!-- <a href="../index.php" class="btn btn-danger">Huỷ</a> -->
    </form>
</div>
<script>
    function toggleMenu() {
        const menu = document.querySelector('.dropdown-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }  
                        
                     
</script>
</body>
</html>