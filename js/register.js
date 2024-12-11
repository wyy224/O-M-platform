document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('register-form');
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const email = document.getElementById('email').value;
        if(password !== confirmPassword) {
            alert("The two passwords are different. Please re-enter them");
            return;
        }

        // encryption
        const hashedPassword = CryptoJS.SHA256(password).toString();
        fetch('./server/registerfunc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `username=${encodeURIComponent(username)}&password=${password}&email=${email}`
        })
        .then(response => response.text())
        .then(message => {
            console.log(message);
            if(message === 'success') {
                alert("Registration successful, please login"); // 显示登录结果
                window.location.href = 'login.php'; // 跳转到登录页面
            }else {
                alert("Registration failed, please try again"); // 显示注册结果
            }
        })
        .catch(error => {
            console.error('Login error:', error);
        });
    });
});