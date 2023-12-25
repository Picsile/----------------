<?php
    require_once("goods functions.php");
    require_once("json functions.php");
    require_once("form generator.php");

    session_start();
    
    if (isset($_POST["travel_to_favourite"]))
        header('location: favourites.php');
    elseif (isset($_POST["travel_to_index"]))
        header('location: index.php');

    echo "<h1>Добро пожаловать, ", $_SESSION['name'], "!</h1>";

    $json_path = "goods.json";

    $data = decodeItems($json_path);

    if (isset($_POST['delindex'])) 
    {   
        unset($data[$_POST["delindex"]]);
        $data = array_values($data);
    }

    if (isset($_POST["add_favourite_index"]))
    {
        $users_data = decodeItems("users.json");

        if (!(in_array($_POST["add_favourite_index"], $users_data[$_SESSION["user_index"]]["favourites"]))) 
            $users_data[$_SESSION["user_index"]]["favourites"][] = (int)$_POST["add_favourite_index"];

        encodeItems($users_data, "users.json");
        
        unset($users_data);
    }
    
    if ($_SESSION['role'] == 'admin')
    {   
        form1("Выйти из аккаунта", "travel_to_index", true);

        echo "<br>";

        form2(
            [   
                ["input", "Название",  "name"],
                ["input", "Описание", "description"],
                ["input", "Новая категория", "new_category"],
                ["select", "Уже существующие категории", "old_category", array_unique(array_map(function ($value) {return $value["category"];}, $data))],
                ["input", "Цена", "price"],
                ["input", "Путь к изображению", "image_url"],
                ["input", "Колличество на складе", "stock"],
                ["input", "Акция", "offers", "Оставьте пустым, если нету акции"]
            ],
            "Ввести товар"
        );
    }
    elseif ($_SESSION['role'] == 'user')
    {
        form1("Выйти из аккаунта", "travel_to_index", true);

        echo "<br>";

        form1("Перейти в список избранных товаров", "travel_to_favourite", true);
    }
    elseif ($_SESSION['role'] == 'guest')
    {
        form1("Авторизироваться", "travel_to_index", true);
    }
    
    if (isset($_POST["name"]) and ( (isset($_POST["new_category"]) and $_POST["new_category"] != "") or (isset($_POST["old_category"]) and $_POST["old_category"] != "") ) and isset($_POST["price"]) and isset($_POST["stock"]))
    {
        {   
            $new_data = [];
            $new_data["name"] = $_POST["name"];
            if ($_POST["description"] != "") $new_data["description"] = $_POST["description"];
            $new_data["category"] = ($_POST["new_category"] != "") ? $_POST["new_category"] : $_POST["old_category"];
            $new_data["price"] = $_POST["price"];
            if ($_POST["image_url"] != "") $new_data["image_url"] = $_POST["image_url"];
            $new_data["stock"] = $_POST["stock"];
            if ($_POST["offers"] != "") $new_data["offers"] = $_POST["offers"];
            $new_data["id"] = max(array_map(function ($value) {return $value["id"];}, $data))+1;

            array_push($data, $new_data);
            unset($new_data);
        }
    }

    $obj_data = items2ObjSourveneers($data);
    uasort($obj_data, function ($val1, $val2) {return strcmp($val1->category, $val2->category);});

    foreach ($obj_data as $key => $obj)
    {   
        if (!isset($old_key) or $data[$old_key]["category"] != $data[$key]["category"]) echo "<h2>$obj->category</h2>";

        $obj->printSouvenir();

        if ($_SESSION['role'] == 'admin')
            form1("Удалить", "delindex", $key);
        elseif ($_SESSION['role'] == 'user')
            form1("Добавить в избранное", "add_favourite_index", $obj->id);
        $old_key = $key;
    }

    encodeItems($data, $json_path);
?>