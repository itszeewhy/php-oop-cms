<?php

class UserModel extends Database
{

    protected function fetchUser()
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        try {
            if (isset($_GET['user_id'])) {
                $id = $_GET['user_id'];
                $stmt = $this->connect_db()->prepare($sql);
                if ($stmt->execute([$id])) {
                    $result = $stmt->fetch();
                    return $result;
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    protected function fetchUserAjax()
    {
        if (isset($_POST['limit'])) {
            echo $_POST['limit'];
        }
    }

    protected function fetchAllUsers()
    {
        $sql = "SELECT * FROM users";
        try {
            if ($query = $this->connect_db()->query($sql)) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    protected function fetchLoginUser()
    {
        $sql = "SELECT * FROM users WHERE user_email = ?";

        try {
            if (isset($_POST['user_login_submit'])) {
                if (!empty($_POST['user_email'] && !empty($_POST['user_password']))) {
                    $email = htmlspecialchars($_POST['user_email']);
                    $password = htmlspecialchars($_POST['user_password']);

                    $stmt = $this->connect_db()->prepare($sql);
                    $stmt->execute([$email]);

                    $result = $stmt->fetch();
                    $num_row = $stmt->rowCount();

                    if ($num_row > 0) {
                        if (password_verify($password, $result['user_password'])) {
                            $_SESSION['logged_in'] = true;
                            $_SESSION['user_info'] = $result;

                            header('Location: index.php');
                        } else {
                            echo "Password incorrect";
                        }
                    } else {
                        echo "User does not exists";
                    }
                } else {
                    echo "Please fill in the blanks";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    protected function checkUserExist()
    {
        $sql = "SELECT * FROM users WHERE user_name = :user_name OR user_email = :user_email";

        try {
            if (isset($_POST['signup_submit'])) {
                $username = htmlspecialchars($_POST['signup_username']);
                $email = htmlspecialchars($_POST['signup_email']);
                $password = htmlspecialchars($_POST['signup_password']);
                $password_r = htmlspecialchars($_POST['signup_password_r']);

                if (!empty($username) && !empty($email) && !empty($password) && !empty($password_r)) {
                    $stmt = $this->connect_db()->prepare($sql);
                    $stmt->execute(['user_name' => $username, 'user_email' => $email]);
                    $stmt->fetch();
                    $num_row = $stmt->rowCount();

                    if ($num_row == 0) {
                        return true;
                    } else {
                        echo "Username or email exists";
                    }
                } else {
                    echo "Please fill in all the fields";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }
}
