<?php

class UserContr extends UserModel
{
    public function loginUser()
    {
        $this->fetchLoginUser();
    }

    public function logoutUser()
    {
        session_start();
        $_SESSION = array();
        return $_SESSION;
    }

    public function signupUser()
    {

        $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES (:user_name, :user_email, :user_password)";

        try {
            if (isset($_POST['signup_submit'])) {
                $username = htmlspecialchars($_POST['signup_username']);
                $email = htmlspecialchars($_POST['signup_email']);
                $password = htmlspecialchars($_POST['signup_password']);
                $password_r = htmlspecialchars($_POST['signup_password_r']);

                if ($this->checkUserExist() == true) {
                    if ($password == $password_r) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $this->connect_db()->prepare($sql);
                        if ($stmt->execute(['user_name' => $username, 'user_email' => $email, 'user_password' => $hash])) {
                            echo "Signup success!";
                        }
                    } else {
                        echo "passwords don't match";
                    }
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function deleteUser()
    {
        $sql = "DELETE FROM users WHERE id = ?";

        try {
            if (isset($_GET['user_id'])) {
                $id = $_GET['user_id'];

                $user = $this->fetchUser();

                if ($user != false) {
                    if ($user['user_isadmin'] == 0) {
                        $stmt = $this->connect_db()->prepare($sql);
                        if ($stmt->execute([$id])) {
                            header("Location: " . $_SERVER['PHP_SELF'] . "?admin_page=users");
                        }
                    } else {
                        header("Location: " . $_SERVER['PHP_SELF'] . "?admin_page=users");
                    }
                } else {
                    header("Location: " . $_SERVER['PHP_SELF'] . "?admin_page=users");
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function updateUser()
    {
        $sql = "UPDATE users SET user_name = :user_name, user_email = :user_email, user_isadmin = :user_isadmin WHERE id = :id";

        try {
            if (isset($_POST['user_update_submit'])) {
                if (!in_array("", $_POST['user']) && isset($_GET['user_id'])) {
                    $fields = $_POST['user'];
                    $username = htmlspecialchars($fields['name']);
                    $email = htmlspecialchars($fields['email']);
                    $role = htmlspecialchars($fields['role']);
                    $id = $_GET['user_id'];
                    $stmt = $this->connect_db()->prepare($sql);

                    if ($stmt->execute(['user_name' => $username, 'user_email' => $email, 'user_isadmin' => $role, 'id' => $id])) {
                        header("Location: " . $_SERVER['PHP_SELF'] . "?admin_page=users");
                    }
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function updateUserPassword()
    {
        $sql = "UPDATE users SET user_password = :user_password WHERE id = :id";

        try {
            if (isset($_POST['user_reset_pw_submit'], $_GET['user_id'])) {
                if (!in_array("", $_POST['user'])) {
                    $fields = $_POST['user'];
                    $new_password = $fields['new_password'];
                    $new_password_r = $fields['new_password_r'];
                    $id = $_GET['user_id'];
                    $is_admin = $this->fetchUser()['user_isadmin'];

                    if ($new_password == $new_password_r) {
                        $hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $this->connect_db()->prepare($sql);
                        if ($stmt->execute(['user_password' => $hash, 'id' => $id])) {
                            switch ($is_admin) {
                                case 1:
                                    $_SESSION['user_info']['user_password'] = $hash;
                                    header("Location: " . $_SERVER['PHP_SELF'] . "?admin_page=users");
                                    break;
                                case 0:
                                    header("Location: " . $_SERVER['PHP_SELF'] . "?admin_page=users");
                                    break;
                            }
                        }
                    } else {
                        echo "Please repeat the password";
                    }
                } else {
                    echo "Please fill in all the blanks";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }
}
