<?php 
    require('includes/header.php');
    require('../db/conn.php');

    // Kiểm tra xem có ID trong URL không
    if (isset($_GET['id'])) {
        $flight_id = intval($_GET['id']);
        
        // Lấy thông tin hãng hàng không từ cơ sở dữ liệu
        $sql_str = "SELECT * FROM flights WHERE flight_id = $flight_id";
        $result = mysqli_query($conn, $sql_str); 

        $flight = mysqli_fetch_assoc($result);
        if (!$flight) {
            die("Chuyến bay không tồn tại.");
        }
    }else {
        die("ID chuyến bay không hợp lệ.");
    }

        // Xử lý form khi người dùng gửi thông tin sửa đổi
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changeFlight'])) {
        $flight_Number = $_POST['flight_Number'];
        $departure = $_POST['departure'];
        $departure_Time = $_POST['departure_Time'];
        $arrival = $_POST['arrival'];
        $arrival_Time = $_POST['arrival_Time'];
        $airline_id = $_POST['airline_id'];
        $seat_Capacity = $_POST['seat_Capacity'];
        $adult_Price = $_POST['adult_Price'];
        $child_Price = $_POST['child_Price'];

        // Cập nhật thông tin chuyến bay
        $update_sql = "UPDATE flights SET 
                        flight_number='$flight_Number', 
                        departure_airport='$departure', 
                        departure_time='$departure_Time', 
                        arrival_airport='$arrival', 
                        arrival_time='$arrival_Time', 
                        airline_id='$airline_id', 
                        seat_capacity='$seat_Capacity', 
                        adult_price='$adult_Price', 
                        child_price='$child_Price' 
                    WHERE flight_id = $flight_id";

        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Thông tin chuyến bay đã được cập nhật thành công.');</script>";
            echo "<script>window.location.href='./listChuyenBay.php';</script>"; 
        } else {
            echo "<script>alert('Lỗi khi cập nhật thông tin: " . mysqli_error($conn) . "');</script>";
        }
        
    }
?>

<div class="row">
    <div class="col-lg-10">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Chỉnh Sửa Chuyến Bay</h1>
        </div>
        <form class="user" method="post">
            <label>ID Flight:</label><?php echo " ".$flight_id; ?>  
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="flight_Number">Flight Number:</label>
                    <input type="text" class="form-control form-control-user" id="flight_Number" name="flight_Number" 
                        value="<?php echo $flight['flight_number']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="departure">Departure:</label>
                    <input type="text" class="form-control form-control-user" id="departure" name="departure"
                        value="<?php echo $flight['departure_airport']; ?>">
                </div>
                <div class="col-sm-6">
                    <label for="departure_Time">Departure Time:</label>
                    <input type="datetime-local" id="departure_Time" name="departure_Time" class="form-control form-control-user" 
                        value="<?php echo date('Y-m-d\TH:i', strtotime($flight['departure_time'])); ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="arrival">Arrival:</label>
                    <input type="text" class="form-control form-control-user" id="arrival" name="arrival"
                        value="<?php echo $flight['arrival_airport']; ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="arrival_Time">Arrival Time:</label>
                    <input type="datetime-local" id="arrival_Time" name="arrival_Time" class="form-control form-control-user"
                        value="<?php echo date('Y-m-d\TH:i', strtotime($flight['arrival_time'])); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="airline_id">Airlines:</label>
                <select class="form-control" id="airline_id" name="airline_id" required>
                    <?php
                    // Lấy danh sách các hãng hàng không
                    $airlines_sql = "SELECT * FROM airlines";
                    $airlines_result = mysqli_query($conn, $airlines_sql);
                    
                    while ($airline = mysqli_fetch_assoc($airlines_result)) {
                        $selected = ($airline['airline_id'] == $flight['airline_id']) ? 'selected' : '';
                        echo "<option value='" . $airline['airline_id'] . "' $selected>" . $airline['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="seat_Capacity">Seat Capacity:</label>
                    <input type="number" class="form-control form-control-user" id="seat_Capacity" name="seat_Capacity"
                        value="<?php echo $flight['seat_capacity']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="adult_Price">Adult Price:</label>
                    <input type="number" class="form-control form-control-user" id="adult_Price" name="adult_Price"
                        value="<?php echo $flight['adult_price']; ?>" required>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="child_Price">Child Price:</label>
                    <input type="number" class="form-control form-control-user" id="child_Price" name="child_Price"
                        value="<?php echo $flight['child_price']; ?>" required>
                </div>
            </div>
            <input type="submit" name="changeFlight" value="Change Flight" class="btn btn-primary btn-user btn-block">                                 
        </form>
    </div>
    </div>
</div>

<?php
    $conn->close(); 
    require('includes/footer.php');
?>




