<?php 
    require('includes/header.php');
?>

<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Passenger</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Passenger</th>
                            <th>ID Booking</th>   
                            <th>Name</th>
                            <th>Date Of Birth</th>
                            <th>Gender</th>
                            <th>Passport</th>
                            <th>Nationality</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>                                  
                    <tbody>                                       
                    <?php 
                        require('../db/conn.php');
                        $sql_str =  "SELECT   
                            CONCAT(first_name, ' ', last_name) AS name,
                            passenger_id,
                            date_of_birth,
                            gender,
                            passport_number,
                            nationality,
                            email,
                            phone_number,
                            booking_id
                        FROM passengers";

                        $result = mysqli_query($conn, $sql_str);                           
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                                <td>' . $row['passenger_id'] . '</td>
                                <td>' . $row['booking_id'] . '</td>
                                <td>' . $row['name'] . '</td>
                                <td>' . $row['date_of_birth'] . '</td>
                                <td>' . $row['gender'] . '</td>
                                <td>' . $row['passport_number'] . '</td>
                                <td>' . $row['nationality'] . '</td>
                                <td>' . $row['email'] . '</td>
                                <td>' . $row['phone_number'] . '</td>
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