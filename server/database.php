<?php
    function connectDB() {
        $servername = "localhost";
        $username = "wyy";
        $password = "010224";
        $dbname = "html-test";

        $conn = new mysqli($servername, $username, $password, $dbname);
// 检查连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        return $conn;
        }


    
    function registerUser($username, $password, $email) {
        $conn = connectDB();
        if ($conn) {
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $checkStmt->bind_param("s", $username);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo "Username already exists";
                return false;
            }
            $stmt = $conn->prepare("INSERT INTO users (username, password, email,role) VALUES (?, ?, ?, ?)");
            $var1 = $username;
            $var2 = $password;
            $var3 = $email;
            $var4 = 'user';
            $stmt->bind_param('ssss', $var1, $var2, $var3, $var4);
            if ($stmt->execute()) {
                echo "success";
                return true;
            } else {
                echo "error";
            }

            $stmt->close();
            $conn->close();
        } else {
            return false;
        }
    }
    
    function loginUser($username, $password) {
        $conn = connectDB();
        if ($conn) {
            try {
                $sql = "SELECT id, password, role FROM users WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($user = $result->fetch_assoc()) {
                        // verify pwd
                        if ($user['password'] === $password) {
                             echo "success";
                            return $user;
                        } else {
                            echo "error";
                        }
                    } else {
                        echo "The user name does not exist！";
                    }
                } else {
                    echo "Database query failure：" . $conn->error;
                }

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
            $stmt->close();
            $conn->close();
        } else {
            return false;
        }
    }


?>