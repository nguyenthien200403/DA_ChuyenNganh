// Lắng nghe sự kiện khi người dùng rời khỏi trường nhập liệu
document.getElementById("ho_ten").addEventListener("blur", function () {
  var value = this.value;
  var errorMessage = document.getElementById("user_error");

  // Hàm xử lý viết hoa chữ cái đầu mỗi từ và chấp nhận dấu tiếng Việt
  function capitalizeWords(input) {
    return input.replace(
      /\b([a-zàáạảãăắằẳẵặâấầẩẫậb-z])(\S*)/gi,
      function (match, firstLetter, rest) {
        return firstLetter.toUpperCase() + rest.toLowerCase();
      }
    );
  }

  // Kiểm tra và viết hoa chữ cái đầu mỗi từ
  var capitalizedValue = capitalizeWords(value);

  // Kiểm tra tên có đúng định dạng hay không
  const namePattern =
    /^[A-ZÀÁẠẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬB-CDEFGHIJKLMNOPQRSTUVWXYZà-ýà-ỹà-ỹ\s]+$/;

  // if (!namePattern.test(capitalizedValue)) {
  //   errorMessage.textContent =
  //     "Họ và tên phải viết hoa chữ cái đầu mỗi từ, và có thể có dấu tiếng Việt.";
  // } else {
  //   errorMessage.textContent = ""; // Xóa thông báo lỗi nếu đúng
  // }

  // Đặt lại giá trị sau khi xử lý viết hoa chữ cái đầu
  this.value = capitalizedValue;
});

function validateEmail(input) {
  var value = input.value;
  var errorMessage = document.getElementById("email-error-message");

  // Kiểm tra nếu email không chứa "@gmail.com"
  if (!value.endsWith("@gmail.com")) {
    errorMessage.textContent = "Email phải kết thúc bằng '@gmail.com'.";
    errorMessage.style.display = "block";
    input.focus(); // Đưa con trỏ trở lại trường nhập liệu
  } else {
    // Nếu đúng, ẩn thông báo lỗi
    errorMessage.style.display = "none";
  }
}
function rangbuocsodienthoai(input) {
  var phoneNumber = input.value.trim(); // Lấy giá trị nhập liệu và loại bỏ khoảng trắng
  var errorMessage = document.getElementById("phone-error-message");

  // Kiểm tra số điện thoại: bắt đầu bằng 0 và có độ dài từ 9 đến 10
  var phoneRegex = /^0\d{8,9}$/; // Regex kiểm tra: bắt đầu bằng 0 và tiếp theo là 8-9 chữ số

  if (!phoneRegex.test(phoneNumber)) {
    errorMessage.textContent =
      "Số điện thoại không hợp lệ. Vui lòng nhập 9-10 chữ số bắt đầu bằng số 0.";
    errorMessage.style.display = "block";
    // input.value = ""; // Xóa giá trị không hợp lệ
    input.focus(); // Đưa con trỏ trở lại trường nhập liệu
  } else {
    errorMessage.style.display = "none"; // Ẩn thông báo lỗi nếu hợp lệ
  }
}
function rangbuocdiachi(input) {
  var diaChi = input.value.trim(); // Lấy giá trị và loại bỏ khoảng trắng
  var errorMessage = document.getElementById("address-error-message");

  // Kiểm tra địa chỉ phải có cả chữ và số
  var hasLetter = /[a-zA-Z]/.test(diaChi); // Kiểm tra có ít nhất một chữ cái
  var hasNumber = /\d/.test(diaChi); // Kiểm tra có ít nhất một chữ số

  if (!hasLetter || !hasNumber) {
    errorMessage.textContent = "Địa chỉ phải bao gồm cả chữ và số.";
    errorMessage.style.display = "block";
    // input.value = ""; // Xóa giá trị không hợp lệ
    input.focus(); // Đưa con trỏ trở lại trường nhập liệu
  } else {
    errorMessage.style.display = "none"; // Ẩn thông báo lỗi nếu hợp lệ
  }
}

function rangbuocngaysinh(input) {
  const selectedDate = new Date(input.value); // Lấy giá trị người dùng nhập
  const today = new Date(); // Ngày hiện tại
  const errorMessage = document.getElementById("date-error-message");

  // Đặt giờ, phút, giây, và mili giây của ngày hiện tại và ngày nhập về 0 để chỉ so sánh ngày
  today.setHours(0, 0, 0, 0);
  selectedDate.setHours(0, 0, 0, 0);

  // Kiểm tra nếu ngày nhập không hợp lệ
  if (!input.value || selectedDate >= today) {
    errorMessage.textContent = "Ngày sinh phải là ngày trước hôm nay.";
    errorMessage.style.display = "block";
    // input.value = ""; // Xóa giá trị không hợp lệ
    input.focus(); // Đưa con trỏ quay lại trường nhập
  } else {
    errorMessage.style.display = "none"; // Ẩn thông báo lỗi nếu hợp lệ
  }
}
function rangbuocMatKhau(input) {
  var password = input.value.trim(); // Lấy giá trị nhập liệu và loại bỏ khoảng trắng
  var errorMessage = document.getElementById("password-error-message");

  // Kiểm tra mật khẩu có độ dài từ 8 đến 10 ký tự
  if (password.length < 8 || password.length > 10) {
    errorMessage.textContent = "Mật khẩu phải có độ dài từ 8 đến 10 ký tự.";
    errorMessage.style.display = "block";
    // input.value = ""; // Xóa giá trị không hợp lệ
    input.focus(); // Đưa con trỏ trở lại trường nhập liệu
  } else {
    errorMessage.style.display = "none"; // Ẩn thông báo lỗi nếu hợp lệ
  }
}
