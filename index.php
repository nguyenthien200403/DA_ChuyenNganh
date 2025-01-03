<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Chuyến Bay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            color: #007bff;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-check-label {
            color: #495057;
        }
        input, select {
            border-radius: 8px;
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
        .header-bar .menu-items a {
            margin-right: 15px;
            text-decoration: none;
            color: white;
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .header-bar .menu-items .hotline {
                display: none;
            }
            .menu-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
<div class="header-bar">
<div class="d-flex align-items-center">
        <div>
            <img src="your-logo-url.png" alt="Logo" class="me-3">
        </div>
        <div class="menu-items d-none d-md-flex">
                <a href="index.php"><i class="fas fa-home"></i> Trang Chủ</a>
                <a href="login.php"><i class="fas fa-credit-card"></i> Quản Lý</a>
            </div>
            </div>
        <div class="hotline">
            <span><i class="fas fa-phone-alt"></i> Hotline: <strong>123-456-7890</strong></span>
        </div>
        <button class="btn btn-light menu-btn" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
    </div>


    <!-- Dropdown Menu -->
    <div class="container mt-5">
        <h2 class="text-center mb-4"><i class="fas fa-plane-departure"></i> Tìm Chuyến Bay</h2>
        <form action="TEST/select_flight.php" method="get">
            <?php
                require('db/conn.php');

                // Lấy danh sách điểm đi và điểm đến
                $sql = "SELECT DISTINCT departure_airport FROM flights"; 
                $result_departure = $conn->query($sql);

                $sql = "SELECT DISTINCT arrival_airport FROM flights"; 
                $result_arrival = $conn->query($sql);

            ?>
            <!-- Điểm đi và đến -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="departure_airport" class="form-label">Điểm khởi hành</label>
                    <select class="form-control" id="departure_airport" name="departure_airport" required>
                    <option value=""></option>
                    <?php
                        if ($result_departure->num_rows > 0) {
                            while ($row = $result_departure->fetch_assoc()) {
                                echo '<option value="'.$row['departure_airport'].'">'.$row['departure_airport'].'</option>';
                            }
                        }
                    ?>
                </select>
                </div>
                <div class="col-md-6">
                    <label for="arrival_airport" class="form-label">Điểm đến</label>
                    <select class="form-control" id="arrival_airport" name="arrival_airport" required>
                    <option value=""></option>
                    <?php
                        if ($result_arrival->num_rows > 0) {
                            while ($row = $result_arrival->fetch_assoc()) {
                                echo '<option value="'.$row['arrival_airport'].'">'.$row['arrival_airport'].'</option>';
                            }
                        }
                    ?>
                </select>
                </div>
            </div>

            <!-- Ngày đi và ngày về -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="departure_date" class="form-label">Ngày đi</label>
                    <input type="date" class="form-control" id="departure_date" name="departure_date" required>
                </div>
                <!-- <div class="col-md-6">
                    <label for="return_date" class="form-label">Ngày về</label>
                    <input type="date" class="form-control" id="return_date" name="return_date" disabled>
                </div> -->
            </div>

            <!-- Số lượng hành khách -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="adults" class="form-label">Người lớn</label>
                    <input type="number" class="form-control" id="adults" name="adults" min="1" max="10" value="1" required>
                </div>
                <div class="col-md-4">
                    <label for="children" class="form-label">Trẻ em (0-11 tuổi)</label>
                    <input type="number" class="form-control" id="children" name="children" min="0" max="10" value="0">
                </div>
                <!-- <div class="col-md-4">
                    <label for="infants" class="form-label">Em bé (< 2 tuổi)</label>
                    <input type="number" class="form-control" id="infants" name="infants" min="0" max="5" value="0">
                </div> -->
            </div>
            <button type="submit" class="btn btn-primary w-100">Tìm chuyến bay</button>
        </form>
    </div>

    <script>
        function toggleReturnDate() {
            const tripType = document.querySelector('input[name="trip_type"]:checked').value;
            const returnDateField = document.getElementById('return_date');
            returnDateField.disabled = tripType === 'one_way';
            if (tripType === 'one_way') returnDateField.value = '';
        }
        toggleReturnDate();

        function toggleMenu() {
            const menu = document.querySelector('.dropdown-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>
