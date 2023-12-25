<?php
    require_once("goods functions.php");
    require_once("json functions.php");
    require_once("form generator.php");

    session_start();

    if (isset($_POST["travel_to_goods"]))
    {
        header('location: goods.php');
    }

    echo "<h1>Избранные товары</h1>";

    form1("Вернуться к списку товаров", "travel_to_goods", true);

    $data = decodeItems("goods.json");
    $obj_data = items2ObjSourveneers($data);
    $users_data = decodeItems("users.json");

    if (isset($_POST["remove_favourite_index"]))
    {
        unset($users_data[$_SESSION["user_index"]]["favourites"][array_search($_POST["remove_favourite_index"], $users_data[$_SESSION["user_index"]]["favourites"])]);
    }

    $fav_ids = $users_data[$_SESSION["user_index"]]["favourites"];

    foreach ($obj_data as $key => $obj)
    {
        if (in_array($obj->id, $fav_ids))
        {
            $obj->printSouvenir();
            form1("Удалить из избранного", "remove_favourite_index", $obj->id);
        }
    }

    encodeItems($users_data, "users.json");
?>