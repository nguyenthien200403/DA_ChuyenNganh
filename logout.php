<?php
    session_start();
    session_unset();
    session_destroy();

    
    header("location: ../index.php");
    header("location: index.php");
    echo "<script>alert('Xóa nhân viên thành công');</script>";
?>