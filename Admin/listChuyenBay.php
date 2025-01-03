<?php 
    require('includes/header.php');
    require('../db/conn.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_idFL'])) {
        $flight_id = intval($_POST['delete_idFL']);   
        //thực hiện xóa
        $delete_sql = "DELETE FROM flights WHERE flight_id = $flight_id";
        if (mysqli_query($conn, $delete_sql)) {
            echo "<script>alert('Chuyến bay đã được xóa thành công.');</script>";
        } else {
            echo "<script>alert('Lỗi : " . mysqli_error($conn) . "');</script>";
        }
    }         
?>

<div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh Sách Chuyến Bay</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Flight Number</th>  
                                <th>Departure</th>  
                                <th>Departure Time</th>  
                                <th>Arrival</th> 
                                <th>Arrival Time</th>  
                                <th>AirLines</th>
                                <th>Seat Capacity</th>
                                <th>Adult Price</th>
                                <th>Child Price</th>         
                                <th>Operation</th>                               
                            </tr>
                        </thead>                                  
                        <tbody>                                       
                        <?php 
                            require('../db/conn.php');
                            $sql_str = "select * from flights join airlines on flights.airline_id = airlines.airline_id";
                            $result = mysqli_query($conn, $sql_str);                                             
                            while($row = mysqli_fetch_assoc($result)) {
                                $flight_id = $row["flight_id"];
                                // Kiểm tra xem có liên kết với bảng bookings không
                                $check_flight_sql = "SELECT COUNT(*) AS count FROM bookings WHERE flight_id = $flight_id";
                                $check_result = mysqli_query($conn, $check_flight_sql);
                                $check_row = mysqli_fetch_assoc($check_result);
                                $can_delete = $check_row['count'] == 0; // Có thể xóa nếu không có liên kết
                                echo "<tr>
                                        <td>" . $row["flight_id"] . "</td>
                                        <td>" . $row["flight_number"] . "</td>
                                        <td>" . $row["departure_airport"] . "</td>
                                        <td>" . $row["departure_time"] . "</td>
                                        <td>" . $row["arrival_airport"] . "</td>
                                        <td>" . $row["arrival_time"] . "</td>
                                        <td>" . $row["name"] . "</td>
                                        <td>" . $row["seat_capacity"] . "</td>
                                        <td>" . $row["adult_price"] . "</td>
                                        <td>" . $row["child_price"] . "</td>
                                        <td>";
                                        if ($can_delete) {
                                            echo "<form method='POST' style='display:inline;'>
                                                    <input type='hidden' name='delete_idFL' value='$flight_id'>
                                                    <button type='submit' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'>Delete</button>
                                                </form>" ;
                                            echo " | <a href='edit_flight.php?id=$flight_id'>Edit</a></td></tr>";
                                        } else{
                                            echo "Không thể xóa/sửa";
                                        }                             
                                       
                            }
                        ?>                                                                                                                                                                                                                                                                                                                                                                                         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php 
    require('includes/footer.php');
?>