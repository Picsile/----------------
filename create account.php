<?php
    require_once("form generator.php");
    require_once("json functions.php");

    session_start();

    if (isset($_POST["name"]) and isset($_POST["login"]) and isset($_POST["password"]))
    {
        $users = decodeItems("users.json");
        $new_user = [];
        $new_user['name'] = $_POST["name"];
        $new_user['login'] = $_POST["login"];
        $new_user['password'] = $_POST["password"];
        $new_user['role'] = "user";
        $new_user['favourites'] = [];
        $users[] = $new_user;
        encodeItems($users, "users.json");
        header("location:index.php");
    }

    form2(
        [
            ["input", "имя", "name"],
            ["input", "логин", "login"],
            ["input_hidden", "пароль", "password"],
        ],
        "Зарегестрироваться"
    );
?>