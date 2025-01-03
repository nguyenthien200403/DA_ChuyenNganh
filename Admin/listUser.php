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
                                <th>ID User</th>
                                <th>User Name</th>   
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created</th>                        
                            </tr>
                        </thead>                                  
                        <tbody>                                       
                        <?php 
                            require('../db/conn.php');
                            $sql_str =  "SELECT *  FROM users";

                            $result = mysqli_query($conn, $sql_str);                           
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                    <td>' . $row['user_id'] . '</td>
                                    <td>' . $row['username'] . '</td>
                                    <td>' . $row['address'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $row['phone_number'] . '</td>
                                    <td>' . $row['created_at'] . '</td>                                
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