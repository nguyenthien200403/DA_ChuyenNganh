<?php 
    require('includes/header.php');
?>

<div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh Sách BooKings</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Booking</th>
                                <th>Passenger</th>   
                                <th>Flight Number</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>Booking Date</th>
                                <th>Number of adult tickets</th>
                                <th>Number of child tickets</th>
                                <th>Total price</th>
                            </tr>
                        </thead>                                  
                        <tbody>                                       
                        <?php 
                            require('../db/conn.php');
                        
                            $sql_str = "SELECT b.booking_id, u.username, f.flight_number, f.departure_airport, f.arrival_airport, 
                                b.booking_date, b.number_of_adult_tickets, b.number_of_child_tickets, b.total_price
                                FROM Bookings b
                                JOIN Users u ON b.user_id = u.user_id
                                JOIN Flights f ON b.flight_id = f.flight_id
                                ORDER BY b.booking_date DESC";
                                $result = mysqli_query($conn, $sql_str);                           
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                    <td>' . $row['booking_id'] . '</td>
                                    <td>' . $row['username'] . '</td>
                                    <td>' . $row['flight_number'] . '</td>
                                    <td>' . $row['departure_airport'] . '</td>
                                    <td>' . $row['arrival_airport'] . '</td>
                                    <td>' . $row['booking_date'] . '</td>
                                    <td>' . $row['number_of_adult_tickets'] . '</td>
                                    <td>' . $row['number_of_child_tickets'] . '</td>
                                    <td>' . $row['total_price'] . '</td>
                                </tr>';
                            }  
                            $conn->close(); 
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