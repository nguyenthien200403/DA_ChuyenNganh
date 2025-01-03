
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Chuyến Bay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            color: #007bff;
            font-weight: bold;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
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
        .menu-btn {
            display: none;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 15px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #007bff;
        }
        .dropdown-menu a:hover {
            background-color: #f3f4f6;
        }

        
        @media (max-width: 768px) {
            .header-bar .hotline {
                display: none;
            }
            .menu-btn {
                display: block;
            }
        }
    </style>
</head>
<body>

<?php 
    // Lấy dữ liệu từ biểu mẫu
    $departure_airport= $_GET['departure_airport'];
    $arrival_airport = $_GET['arrival_airport'];
    $departure_date = $_GET['departure_date'];
    $adults_amount = $_GET['adults'];
    $children_amount = $_GET['children'];

?>
<div class="header-bar">
        <div>
            <img src="your-logo-url.png" alt="Logo">
        </div>
        <div class="hotline">
            <span><i class="fas fa-phone-alt"></i> Hotline: <strong>123-456-7890</strong></span>
        </div>
        <button class="btn btn-light menu-btn" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Dropdown Menu -->
    <div class="dropdown-menu">
        <a href="search_flights.php"><i class="fas fa-home"></i> Trang Chủ</a>
        <a href="payment.php"><i class="fas fa-credit-card"></i> Thanh Toán</a>
    </div>
    <div class="container">
        <h2 class="text-center"><i class="fas fa-plane"></i> Chọn Chuyến Bay</h2>
        <p class="text-center">
            <strong>Từ:</strong> <?= htmlspecialchars($departure_airport) ?> - 
            <strong>Đến:</strong> <?= htmlspecialchars($arrival_airport) ?> - 
            <strong>Ngày đi:</strong> <?= htmlspecialchars($departure_date) ?>
        </p>
        <p class="text-center">
            <strong>Người lớn:</strong> <?= htmlspecialchars($adults_amount) ?>, 
            <strong>Trẻ em:</strong> <?= htmlspecialchars($children_amount) ?>
        </p>

        <div class="list-group mt-4">
            <?php 
                require('../db/conn.php');
                $sql_str = "select * from flights join airlines on flights.airline_id = airlines.airline_id";
                $result = mysqli_query($conn, $sql_str); 
                $hasFlight = false;                                            
                while($row = mysqli_fetch_assoc($result)) {
                    if($departure_airport == $row['departure_airport'] && $arrival_airport == $row['arrival_airport'] 
                            && $departure_date ==  date('Y-m-d', strtotime($row['departure_time']))){
                        $hasFlight = true;

                        $flight_id = $row['flight_id'];

                        $sql_count_seat = "SELECT COUNT(*) AS total_booking FROM Bookings WHERE flight_id = ?";
                        $stmt = $conn->prepare($sql_count_seat);
                        $stmt->bind_param("i", $flight_id);
                        $stmt->execute();
                        $count_result = $stmt->get_result();
                        $count_row = $count_result->fetch_assoc();
                        $total_booking = $count_row['total_booking'];

                        // Kiểm tra số ghế còn lại
                        $available_seats = $row['seat_capacity'] - $total_booking;

                        echo '<form action="" method="get" enctype="multipart/form-data">';
                        echo '<table class="table table-bordered">';
                        echo '<tr>';
                        echo '<div class="d-flex align-items-center">';
                            echo '<span class="me-2"><strong>Số hiệu chuyến bay:</strong> '.$row['flight_number'].'</span>';
                            echo '<span class="me-2"><strong>Hãng Bay:</strong> '.$row['name'].'</span>';
                            echo '<span class="me-2"><strong>Vé người lớn:</strong> '.$row['adult_price'].' VND</span>';
                            echo '<span class="me-2"><strong>Vé trẻ em:</strong> '.$row['child_price'].' VND</span>';
                            echo '<span class="me-2"><strong>Giờ khởi hành:</strong> '.date('H:i:s', strtotime($row['departure_time'])).'</span>';
                            echo '<span class="me-2"><strong>Ghế trống:</strong> '.$available_seats.'</span>';
                            if($available_seats <= 0){
                                echo '<span class="text-danger ms-auto">Full ghế.</span>';
                            }else
                                echo '<div class="ms-auto"><a href="enter_customer_info.php?&flight_id='.$flight_id.
                                    '&adults_amount='.$adults_amount.'&children_amount='.$children_amount.
                                    '"class="btn btn-primary">Đặt vé</a></div>';
                        echo '</div>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</form>';
                    }                                                                                  
                }
                if (!$hasFlight) {
                    echo '<p>Không có chuyến bay phù hợp</p>';
                }
            ?>                          
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('.dropdown-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>
