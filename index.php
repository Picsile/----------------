 <?php
    require_once("form generator.php");
    require_once("json functions.php");

    session_start();

    if (isset($_POST["travel_to_crete_account"]) and $_POST["travel_to_crete_account"] == true)
        header("location:create account.php");

    elseif (isset($_POST['login']) and isset($_POST['password']))
    {
        $users = decodeItems("users.json");
        unset($_SESSION['role']);
        unset($_SESSION['name']);
        foreach ($users as $key => $user)
        {
            if ($user['login'] == $_POST['login'] and $user['password'] == $_POST['password'])
            {
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['user_index'] = $key;
                break;
            }
        }
        if (!(isset($_SESSION['role']) and $_SESSION['name']))
        {
            $_SESSION['role'] = "guest";
            $_SESSION['name'] = 'Guest';
        }
        header('location: goods.php');
    }

    echo "<h1>Регистрация</h1>";

    form2(
        [
            ["input", "логин", "login"],
            ["input_hidden", "пароль", "password"]
        ],
        "Войти"
    );
    
    form1("Новый аккаунт", "travel_to_crete_account", true);
?>