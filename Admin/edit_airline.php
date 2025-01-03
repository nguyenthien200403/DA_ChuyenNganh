<?php 
    require('includes/header.php');
    require('../db/conn.php');

// Biến để chứa thông tin hãng hàng không
    $airline_id = 0;
    $name = '';
    $contact_info = '';

    // Kiểm tra xem có ID trong URL không
    if (isset($_GET['id'])) {
        $airline_id = intval($_GET['id']);
        
        // Lấy thông tin hãng hàng không từ cơ sở dữ liệu
        $sql_str = "SELECT * FROM airlines WHERE airline_id = $airline_id";
        $result = mysqli_query($conn, $sql_str);
        
        // Lấy dữ liệu nếu có
        if ($row = mysqli_fetch_assoc($result)) {
            $id = htmlspecialchars($row['airline_id']);
            $name = htmlspecialchars($row['name']);
            $contact_info = htmlspecialchars($row['contact_info']);
        }
    }
?>

<div class="row">
    <div class="col-lg-7">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Chỉnh Sửa Hãng Hàng Không</h1>
            </div>
            <form class="user" method="post"> 
                <label>ID AIRLINE:</label><?php echo " ".$airline_id; ?>                      
                <div class="form-group">
                    <label for="name">Tên Hãng:</label>
                    <input type="text" class="form-control form-control-user" id="name" name="name" value="<?php echo $name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact_info">Contract Info:</label>
                    <input type="text" class="form-control form-control-user" id="contact_info" name="contact_info" value="<?php echo $contact_info; ?>" required>
                </div>
                <input type="submit" name="changeAirLines" value="Change AirLines" class="btn btn-primary btn-user btn-block">                                 
            </form>
        </div>
    </div>
</div>


<?php
    require('../db/conn.php');

    // Xử lý yêu cầu cập nhật
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['changeAirLines']))  {
        $name = htmlspecialchars(trim($_POST['name']));
        $contact_info = htmlspecialchars(trim($_POST['contact_info']));

        // Cập nhật thông tin hãng hàng không
        $update_sql = "UPDATE airlines SET name = '$name', contact_info = '$contact_info' WHERE airline_id = $airline_id";
        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Thông tin hãng hàng không đã được cập nhật thành công.');</script>";
            echo "<script>window.location.href='./listHanghangkhong.php';</script>"; 
        } else {
            echo "<script>alert('Lỗi khi cập nhật thông tin: " . mysqli_error($conn) . "');</script>";
        }
    }

    $conn->close();
    require('includes/footer.php');
?>


