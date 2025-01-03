<?php
require('../db/conn.php');

// Nhận dữ liệu từ form
$flight_id = $_POST['flight_id'] ?? null;
$passengers = $_POST['passengers'] ?? [];
$username = $_POST['contact_name'] ?? ''; // Change this to username
$contact_phone = $_POST['contact_phone'] ?? '';
$contact_email = $_POST['contact_email'] ?? '';
$contact_address = $_POST['contact_diachi'] ?? '';
$total_price = $_POST['total_price'] ?? 0;
$adults_amount = $_POST['adults_amount'] ?? 0;
$children_amount = $_POST['children_amount'] ?? 0;


// Thêm người dùng vào bảng users
$stmt = $conn->prepare("INSERT INTO Users (username, email, phone_number, address) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ssss", $username, $contact_email, $contact_phone, $contact_address);
$stmt->execute();
$user_id = $conn->insert_id; // Lấy ID của người dùng vừa thêm

// Insert booking information
$sql_booking = "INSERT INTO Bookings (flight_id, user_id, total_price, number_of_adult_tickets,   number_of_child_tickets) VALUES (?, ?, ?,?,?)";
$stmt_booking = $conn->prepare($sql_booking);
if (!$stmt_booking) {
    die("Prepare failed: " . $conn->error);
}
$stmt_booking->bind_param("iidii", $flight_id, $user_id, $total_price,$adults_amount,$children_amount);
$stmt_booking->execute();
$booking_id = $stmt_booking->insert_id;

// Insert passenger information
$sql_passenger = "INSERT INTO Passengers (booking_id, first_name, last_name, gender, date_of_birth, phone_number, passport_number, nationality, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_passenger = $conn->prepare($sql_passenger);

foreach ($passengers as $passenger) {
    if (!$stmt_passenger) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt_passenger->bind_param(
        "issssssss",
        $booking_id,
        $passenger['first_name'],
        $passenger['last_name'],
        $passenger['gender'],
        $passenger['dob'],
        $passenger['phone_number'],
        $passenger['passport_number'],
        $passenger['nationality'],
        $passenger['email']
    );
    $stmt_passenger->execute();
}
$stmt_payment = $conn->prepare("INSERT INTO payments (booking_id,amount) VALUES (?, ?)");
$stmt_payment->bind_param("id", $booking_id,$total_price);
$stmt_payment->execute();

$stmt -> close();
$stmt_passenger->close();
$stmt_booking->close();
$stmt_payment ->close();
$conn->close();
header("Location: success.php");
exit();
?>




