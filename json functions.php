<?php
    function decodeItems($json_path)
    {   
        $result = json_decode(file_get_contents($json_path), true);
        if ($result == false)
            throw new Error("Файл с данными $json_path не найден");
        elseif ($result == null)
            throw new Error("Файл с данными $json_path поврежден");
        else 
            return $result;
    }

    function encodeItems($arr, $json_path)
    {
        file_put_contents($json_path, str_replace(["},", "[{", "}]"], ["},\n    ", "[\n    {", "}\n]"], json_encode($arr)));
    }
?>