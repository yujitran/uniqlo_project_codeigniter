<form method="post" action="<?= base_url('user/doLogin') ?>">
    <div class="container">
        <div class="layer">
            <div class="login-wrapper">
                <div class="login-title__wrapper">
                    <h2 class="login-title__h2">Đăng nhập</h2>
                    <div class="login-title__emphasis">Bắt buộc*</div>
                </div>
                <div class="note-wrapper">
                    <div class="note-text">
                        Đăng nhập bằng địa chỉ email và mật khẩu của bạn
                    </div>
                    <div class="note-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                </div>
                <?= view('massages/massageCustomer') ?>
                <div class="wrapper-input">
                    <div class="label">
                        địa chỉ email <span style="color: #378694;">*</span>
                    </div>
                    <input type="text" id="email-login" name="emaillogin" class="input" placeholder="Nhập email hợp lệ">
                </div>
                <div class="wrapper-input password-toggle">
                    <div id="tooltip-pwd" style="display: none;">
                        <span id="tooltipText-pwd">Vui lòng nhập mật khẩu</span>
                    </div>
                    <div class="label">
                        mật khẩu <span style="color: #378694;">*</span>
                    </div>
                    <input type="password" id="pwd-login" name="pwdlogin" class="input">
                    <div class="require-note">
                        Mật khẩu cần có ít nhất 08 ký tự (bao gồm cả chữ và số). Chỉ có thể sử dụng các ký tự đặc biệt này -_.@
                    </div>
                </div>
                <div class="check-showpass">
                    <input type="checkbox" id="showpass" value="Hiện mật khẩu">
                    <label for="showpass">
                        <span>Hiện mật khẩu</span>
                    </label>
                </div>
                <div class="wrapper-linkag">
                    <div><a href="#">Điều khoản sử dụng</a></div>
                    <div><a href="#">chính sách bảo mật</a></div>
                </div>
                <div class="wrapper-loginbtn">
                    <input type="submit" name="submitLogin" class="button" value="Đăng nhập">
                </div>
                <div class="link__forget-pwd"><a href="#">Quên mật khẩu của bạn?</a></div>
            </div>
            <div class="create-acc-wrapper">
                <h2>tạo một tài khoản</h2>
                <div class="note-wrapper">
                    <div class="note-text">
                        Hãy tạo tài khoản ngay ! Bạn có thể nhận được các dịch vụ đặc biệt cho riêng bạn như kiểm tra lịch sử mua hàng và nhận phiếu giảm giá cho thành viên. Đăng ký miễn phí ngay hôm nay!
                    </div>
                </div>
                <div class="button craete-accbtn">
                    <a href="<?php echo base_url('user/userRegister') ?>">Tạo tài khoản</a>
                </div>
            </div>
        </div>
        <div class="contained">
            <div class="end-page">
                Bản quyền thuộc Công ty TNHH UNIQLO. Bảo lưu mọi quyền.
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url('assets/customer/js/login.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>