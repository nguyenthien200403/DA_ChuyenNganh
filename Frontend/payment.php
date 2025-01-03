<?php 
    // Nhận dữ liệu từ form
    $flight_id = $_POST['flight_id'] ?? null;
    $passengers = $_POST['passengers'] ?? [];
    $username = $_POST['contact_name'] ?? ''; 
    $contact_phone = $_POST['contact_phone'] ?? '';
    $contact_email = $_POST['contact_email'] ?? '';
    $contact_address = $_POST['contact_diachi'] ?? '';
    $total_price = $_POST['total_price'] ?? 0;
    $adults_amount = $_POST['adults_amount'] ?? 0;
    $children_amount = $_POST['children_amount'] ?? 0;
?>

 

<?php
        // Nhận dữ liệu từ form
        $flight_id = $_POST['flight_id'] ?? null;
        $passengers = $_POST['passengers'] ?? [];
        $username = $_POST['contact_name'] ?? ''; 
        $contact_phone = $_POST['contact_phone'] ?? '';
        $contact_email = $_POST['contact_email'] ?? '';
        $contact_address = $_POST['contact_diachi'] ?? '';
        $total_price = $_POST['total_price'] ?? 0;
        $adults_amount = $_POST['adults_amount'] ?? 0;
        $children_amount = $_POST['children_amount'] ?? 0;
        if(isset($_POST['xacnhan'])){
            if (empty($username) || empty($contact_email) || empty($contact_phone) || empty($contact_address)) {
                echo "<h2 class='text-danger'>Thông tin liên hệ không được rỗng!</h2>";}
            require('../db/conn.php');
            // Thêm người dùng vào bảng users
            $stmt = $conn->prepare("INSERT INTO Users (username, email, phone_number, address) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ssss", $username, $contact_email, $contact_phone, $contact_address);
            $stmt->execute();
            $user_id = $conn->insert_id; // Lấy ID của người dùng vừa thêm
    
            // Insert booking information
            $sql_booking = "INSERT INTO Bookings (flight_id, user_id, total_price, number_of_adult_tickets, number_of_child_tickets) VALUES (?, ?, ?,?,?)";
            $stmt_booking = $conn->prepare($sql_booking);
            if (!$stmt_booking) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt_booking->bind_param("iidii", $flight_id, $user_id, $total_price,$adults_amount,$children_amount);
            $stmt_booking->execute();
            $booking_id = $stmt_booking->insert_id;
    
            // Insert passenger information
            $sql_passenger = "INSERT INTO Passengers (booking_id, first_name, last_name, gender, date_of_birth, phone_number, passport_number, nationality, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_passenger = $conn->prepare($sql_passenger);
    
            foreach ($passengers as $passenger) {
                if (!$stmt_passenger) {
                    die("Prepare failed: " . $conn->error);
                }
                $stmt_passenger->bind_param(
                    "issssssss",
                    $booking_id,
                    $passenger['first_name'],
                    $passenger['last_name'],
                    $passenger['gender'],
                    $passenger['dob'],
                    $passenger['phone_number'],
                    $passenger['passport_number'],
                    $passenger['nationality'],
                    $passenger['email']
                );
                $stmt_passenger->execute();
            }
            $stmt_payment = $conn->prepare("INSERT INTO payments (booking_id,amount) VALUES (?, ?)");
            $stmt_payment->bind_param("id",$booking_id,$total_price);
            $stmt_payment->execute();
    
            $stmt->close();
            $stmt_passenger->close();
            $stmt_booking->close();
            $stmt_payment ->close();
            $conn->close();
            echo "<h2>Đặt Vé Thành Công!</h2>";
        } 
    
?>
<!-- Hiển thị thông tin người dùng đã nhập -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Vé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert">
            <p>Thông tin chi tiết</p>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Thông Tin Liên Hệ</h4>
            </div>
            <div class="card-body">
                <p>Họ Tên: <strong><?= $username ?></strong></p>
                <p>Số Điện Thoại: <strong><?= $contact_phone ?></strong></p>
                <p>Email: <strong><?= $contact_email ?></strong></p>
                <p>Địa Chỉ: <strong><?= $contact_address ?></strong></p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Thông Tin Hành Khách</h4>
            </div>
            <div class="card-body">
                <?php foreach ($passengers as $index => $passenger): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Hành khách <?= $index + 1 ?></h5>
                        </div>
                        <div class="card-body">
                            <p>Họ: <strong><?= $passenger['first_name'] ?></strong></p>
                            <p>Tên: <strong><?= $passenger['last_name'] ?></strong></p>
                            <p>Giới tính: <strong><?= $passenger['gender'] ?></strong></p>
                            <p>Ngày sinh: <strong><?= $passenger['dob'] ?></strong></p>
                            <p>Số điện thoại: <strong><?= $passenger['phone_number'] ?></strong></p>
                            <p>Passport: <strong><?= $passenger['passport_number'] ?></strong></p>
                            <p>Quốc tịch: <strong><?= $passenger['nationality'] ?></strong></p>
                            <p>Email: <strong><?= $passenger['email']?></strong></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Tổng giá vé</h4>
            </div>
            <div class="card-body">
                <p>Tổng Tiền: <strong><?= $total_price ." VND" ?></strong></p>
            </div>
        </div>

        <div class="">
            <form action="payment.php" method="post">
                <input type="hidden" name="flight_id" value="<?= htmlspecialchars($flight_id) ?>">
                <input type="hidden" name="adults_amount" value="<?= htmlspecialchars($adults_amount) ?>">
                <input type="hidden" name="children_amount" value="<?= htmlspecialchars($children_amount) ?>">
                <input type="hidden" class="form-control" name="contact_phone" value="<?= htmlspecialchars($contact_phone) ?>" >
                <input type="hidden" class="form-control" name="contact_email"  value="<?= htmlspecialchars($contact_email) ?>">
                <input type="hidden" class="form-control" name="contact_diachi"  value="<?= htmlspecialchars($contact_address) ?>">
                <input type="hidden" class="form-control" name="contact_name" value="<?= htmlspecialchars($username) ?> ">
                <input type="hidden" class="form-control" name="total_price" value="<?= htmlspecialchars($total_price) ?> ">
                <?php foreach ($passengers as $index => $passenger): ?>
                    <input type="hidden" name="passengers[<?= $index ?>][first_name]" value="<?= htmlspecialchars($passenger['first_name']) ?>">
                    <input type="hidden" name="passengers[<?= $index ?>][last_name]" value="<?= htmlspecialchars($passenger['last_name']) ?>">
                    <input type="hidden" name="passengers[<?= $index ?>][gender]" value="<?= htmlspecialchars($passenger['gender']) ?>">
                    <input type="hidden" name="passengers[<?= $index ?>][dob]" value="<?= htmlspecialchars($passenger['dob']) ?>">
                    <input type="hidden" name="passengers[<?= $index ?>][phone_number]" value="<?= htmlspecialchars($passenger['phone_number']) ?>">
                    <input type="hidden" name="passengers[<?= $index ?>][passport_number]" value="<?= htmlspecialchars($passenger['passport_number']) ?>">
                    <input type="hidden" name="passengers[<?= $index ?>][nationality]" value="<?= htmlspecialchars($passenger['nationality']) ?>">
                    <input type="hidden" name="passengers[<?= $index ?>][email]" value="<?= htmlspecialchars($passenger['email']) ?>">
                <?php endforeach; ?>
                <button name="xacnhan" class="btn btn-primary">Xác nhận thanh toán</button>
                <a href="../index.php" class="btn btn-danger">Huỷ</a>
            </form>
        </div>
    </div>

</body>
</html>
