document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('redirect-button');
    button.addEventListener('click', function () {
        window.location.href = "login.php";  // إعادة التوجيه إلى صفحة تسجيل الدخول
    });
});

