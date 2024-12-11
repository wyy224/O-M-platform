document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const hashedPassword = CryptoJS.SHA256(password).toString();
        // console.log(hashedPassword, 'after sha256');
        fetch('./server/loginfunc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `username=${encodeURIComponent(username)}&password=${hashedPassword}`,
        })
        .then(response => response.text())
        .then(message => {
            // console.log(message, 'login response');
            console.log(message);
            if(message=== 'success') {
                alert("Login successfully！");
                window.location.href = 'index.php';
            }else {
                alert("Username or password error, please login again!");
                loginForm.reset();
            }
        })

    });
});

