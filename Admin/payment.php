<?php
    // Cấu hình kết nối tới cơ sở dữ liệu
    require('includes/header.php');
    require('../db/conn.php');
    // Truy vấn để tính doanh thu theo từng năm
    $sql = "SELECT YEAR(payment_date) AS year, SUM(amount) AS total_revenue 
            FROM Payments 
            GROUP BY YEAR(payment_date) 
            ORDER BY YEAR(payment_date)";
    $result = mysqli_query($conn, $sql);

    $data = [];
    $labels = [];

    // Lấy dữ liệu
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['year'];
        $data[] = $row['total_revenue'];
    }


    // Đóng kết nối
    $conn->close();

    // Chuyển đổi dữ liệu sang định dạng JSON
    $labels_json = json_encode($labels);
    $data_json = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu đồ Doanh thu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="path/to/your/chart-bar-demo.js"></script> <!-- Thay đổi đường dẫn nếu cần -->
</head>
<body>
    <canvas id="myBarChart" width="400" height="200"></canvas>
    <script>
        // Thiết lập dữ liệu cho biểu đồ
        const labels = <?php echo $labels_json; ?>;
        const data = <?php echo $data_json; ?>;

        // Cấu hình biểu đồ
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Doanh thu (VNĐ)",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: data,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        },
                        maxBarThickness: 15, // Giảm kích thước cột
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: Math.max(...data) * 1.1,
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value) {
                                return '₫' + number_format(value, 2, ',', ' ');
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ₫' + number_format(tooltipItem.yLabel, 2, ',', ' ');
                        }
                    }
                },
            }
        });
    </script>
</body>
</html>

<?php 
    require('includes/footer.php');
?>