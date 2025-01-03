<?php 
    require('includes/header.php');
?>

<div class="row">
    <div class="col-lg-10">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Thêm Chuyến Bay</h1>
        </div>
        <form class="user" method="post" action="themChuyenBay.php">
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="flights_Number" name="flights_Number"
                        placeholder="Flights Number">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="departure" name="departure"
                        placeholder="Departure">
                </div>
                <div class="col-sm-6">
                    <input type="datetime-local" id="departure_Time" name="departure_Time" class="form-control form-control-user" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="arrival" name="arrival"
                        placeholder="Arrival">
                </div>
                <div class="col-sm-6">
                    <input type="datetime-local" id="arrival_Time" name="arrival_Time" class="form-control form-control-user" required>
                </div>
            </div>
            <div class="form-group">
                <select class="form-control" name="airlines">
                    <option value="">Chose Airlines</option>
                    <?php
                        require('../db/conn.php');
                        $sql_str = "select * from airlines";
                        $result = mysqli_query($conn, $sql_str);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<option>".$row["name"]."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" class="form-control form-control-user" id="seat_Capacity" name="seat_Capacity"
                        placeholder="Seat Capacity">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" class="form-control form-control-user" id="adult_Price" name="adult_Price"
                        placeholder="Adult Price">
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" class="form-control form-control-user" id="child_Price" name="child_Price"
                        placeholder="Child Price">
                </div>
            </div>
            <input type="submit" name="subFlights" value="Add Flights" class="btn btn-primary btn-user btn-block">                                 
        </form>
    </div>
    </div>
</div>


<?php 
    require('../db/conn.php');
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subFlights'])) {
        $flight_Number = trim($_POST['flights_Number']);
        $departure = trim($_POST['departure']);
        $arrival = trim($_POST['arrival']);
        $seat_Capacity = trim($_POST['seat_Capacity']);
        $airline = trim($_POST['airlines']);
        $adult_Price = trim($_POST['adult_Price']);
        $child_Price = trim($_POST['child_Price']);

        // Kiểm tra xem flight_number đã tồn tại chưa
        $sql_check = "SELECT * FROM flights WHERE flight_number = '$flight_Number'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            echo "Chuyến bay với số hiệu này đã tồn tại!";
        } else {
            if(!empty($departure) && !empty($arrival) && !empty($seat_Capacity) && !empty($adult_Price) && !empty($child_Price)){
                $departure_Time = $conn->real_escape_string($_POST['departure_Time']);
                $arrival_Time = $conn->real_escape_string($_POST['arrival_Time']);
                $seat_Capacity = $conn->real_escape_string($_POST['seat_Capacity']);
                $adult_Price = $conn->real_escape_string($_POST['adult_Price']);
                $child_Price = $conn->real_escape_string($_POST['child_Price']);

                $sql_airline = "SELECT airline_id FROM airlines WHERE name = '$airline'";
                $result_airline = $conn->query($sql_airline);
                if ($result_airline->num_rows > 0) {
                    $row_airline = $result_airline->fetch_assoc();
                    $airline_id = $row_airline['airline_id'];

                    // Câu lệnh SQL để thêm chuyến bay
                    $sql_insert = "INSERT INTO `flights` (`flight_number`, `departure_airport`, `arrival_airport`, `departure_time`, `arrival_time`, `airline_id`, `seat_capacity`, `adult_price`, `child_price`) 
                        VALUES ('$flight_Number','$departure','$arrival','$departure_Time','$arrival_Time','$airline_id','$seat_Capacity','$adult_Price','$child_Price')";
                    
                    // Thực hiện truy vấn
                    if ($conn->query($sql_insert) === TRUE) {
                        echo "Thêm chuyến bay thành công!";
                    } else {
                        echo "Lỗi: " . $sql_insert . "<br>" . $conn->error;
                    }
                } else {
                    echo "Hãng hàng không không tồn tại!";
                } 
            } else {
                echo "Chưa nhập thông tin";
            }
        }
    }
    $conn->close();
?>

<?php 
    require('includes/footer.php');
?>