function checkCookie(url) {
    fetch('./server/checkStatus.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
    })
        .then(response => response.text())
        .then(message => {
            if(message == 'login' && url != "setting.php") {
                console.log("yes!")
                window.location.href = url;
            }if (url == "setting.php" && message != "loginadmin") {
                alert("No set permissions, please contact the administrator!");
                window.location.href = "index.php";
                //alert(message);
            }
            if (message == "logout") {
                alert("You should login first to visit other pages!"); //
                window.location.href = "login.php"; //
            }
            else if(message == 'loginadmin'){
                window.location.href = url;
            }
            else {
                console.log(url)
            }
    })
}
// Navigation bar highlight jump
var navlink = document.querySelectorAll('.main-top li');
navlink.forEach((item, index) => {
    item.addEventListener('click', function (link) {
        navlink.forEach(col => {
            col.classList.remove('active');
        })
        item.classList.add('active');
        switch (index) {
            case 0:
                checkCookie("index.php");
                break;
            case 1:
                checkCookie("other.php");
                break;
            case 2:
                checkCookie('analysis.php');
                break;
            case 3:
                checkCookie('alarm.php');
                break;

            case 4:
                checkCookie('setting.php');
                break;
            default:
                break;
        }
    })
})


function loginStatus(){
    fetch('./server/checkStatus.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
    })
        .then(response => response.text())
        .then(message => {
            // console.log(message, 'login response');
            alert(message);
            if (message == 'login') {
                var userConfirmed = confirm("Are you sure you want to log out?");
                if (userConfirmed) {
                    fetch('./server/logout.php', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                    })
                        .then(response => response.text())
                        .then(message => {
                            // console.log(message, 'login response');
                            if (message == 'yes') {
                                alert("Logout successfully!")
                                window.location.href = "login.php";
                            } else {
                                console.log("Logout cancelled by user.");
                            }

                        })
                }
            }
            else {
                alert("Login or register at here!")
                window.location.href = "login.php";
            }
        })
}