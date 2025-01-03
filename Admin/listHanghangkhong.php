<?php 
    require('includes/header.php');
?>

<!-- Form Thêm Hãng Hàng Không -->
<div class="row">
    <div class="col-lg-7">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Thêm Hãng Hàng Không</h1>
            </div>
            <form class="user" method="post" action="listHanghangkhong.php">                       
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="airline_Name" name="airline_Name"
                        placeholder="AirLine Name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="contact_Info" name="contact_Info"
                        placeholder="Contact Info">
                </div>
                <input type="submit" name="subAirLines" value="Add AirLines" class="btn btn-primary btn-user btn-block">                                 
            </form>
        </div>
    </div>
</div>

<!-- Thêm Airline vào danh sách -->
<?php
    require('../db/conn.php');
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subAirLines'])) {
        $airline_Name = trim($_POST['airline_Name']); // Lấy tên hãng hàng không và loại bỏ khoảng trắng
        $contact_Info = trim($_POST['contact_Info']);
        if(!empty($airline_Name) || !empty($contact_Info)){
            $airline_Name = $conn->real_escape_string($_POST['airline_Name']); // Lấy tên hãng hàng không và bảo vệ dữ liệu
            $contact_Info = $conn->real_escape_string($_POST['contact_Info']);
            // Câu lệnh SQL để thêm tên hãng hàng không mới
            $sql_str = "INSERT INTO `airlines`(`airline_id`, `name`, `contact_info`) 
                VALUES (Null, '$airline_Name', '$contact_Info');";
            // Thực hiện truy vấn
            mysqli_query($conn, $sql_str);
        }else 
            echo "Vui lòng nhập dữ liệu hãng hàng không.";  
    }
?>

<!-- Xử lý yêu cầu xóa -->
<?php 
    require('../db/conn.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
        $airline_id = intval($_POST['delete_id']);   
        //thực hiện xóa
        $delete_sql = "DELETE FROM airlines WHERE airline_id = $airline_id";
        if (mysqli_query($conn, $delete_sql)) {
            echo "<script>alert('Hãng hàng không đã được xóa thành công.');</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa hãng hàng không: " . mysqli_error($conn) . "');</script>";
        }
    }                   
?>

<!-- Xử lý tìm kiếm -->
<?php 
    require('../db/conn.php');

    // Khởi tạo biến để lưu kết quả tìm kiếm
    $search_name = '';
    $search_result = [];

    // Xử lý yêu cầu tìm kiếm
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_name'])) {
        $search_name = htmlspecialchars(trim($_POST['search_name']));

        // Truy vấn tìm kiếm theo tên hãng
        $sql_str = "SELECT * FROM airlines WHERE name LIKE '%$search_name%'";
        $search_result = mysqli_query($conn, $sql_str);
    } else {
        // Nếu không có tìm kiếm, lấy tất cả dữ liệu
        $sql_str = "SELECT * FROM airlines";
        $search_result = mysqli_query($conn, $sql_str);
    }
?>

<div>
    <div class="card shadow mb-4 " >
        <div class="card-header py-3 d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary mr-5">Danh Sách Các Hãng Hàng Không</h6>
            <form
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                method="POST">
                <div class="input-group">
                    <input type="text" class="form-control bg-white border-0" 
                        name="search_name" id="search_name" value="<?php echo $search_name; ?>"placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Airline Name</th>   
                            <th>Contact Info</th> 
                            <th>Operation</th>                               
                        </tr>
                    </thead>                                  
                    <tbody>                                          
                    <?php                                              
                        while ($row = mysqli_fetch_assoc($search_result)) {
                            $airline_id = $row["airline_id"];
                            // Kiểm tra xem có liên kết với bảng flights không
                            $check_flight_sql = "SELECT COUNT(*) AS count FROM flights WHERE airline_id = $airline_id";
                            $check_result = mysqli_query($conn, $check_flight_sql);
                            $check_row = mysqli_fetch_assoc($check_result);
                            $can_delete = $check_row['count'] == 0; // Có thể xóa nếu không có liên kết
                
                            echo "<tr>
                                    <td>" . $row["airline_id"] . "</td>
                                    <td>" . htmlspecialchars($row["name"]) . "</td>
                                    <td>" . htmlspecialchars($row["contact_info"]) . "</td>
                                    <td>";
                            if ($can_delete) {
                                echo "<form method='POST' style='display:inline;'>
                                        <input type='hidden' name='delete_id' value='$airline_id'>
                                        <button type='submit' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'>Delete</button>
                                    </form>" ;
                                echo " | <a href='edit_airline.php?id=$airline_id'>Edit</a></td></tr>";
                            } else{
                                echo "Không thể xóa/sửa";
                            }
                    
                            
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