<?php
    function form2 ($checkboxes, $submit_text = "Отправить", $submit_text_title = "Жми сюда") {
            echo "<form method = \"POST\" action = \"\">";
            foreach ($checkboxes as $checkbox) {
                if ($checkbox[0] == 'input' or $checkbox[0] == 'input_hidden')
                {
                    echo "$checkbox[1]<br>";
                    echo "<input ";
                    if ($checkbox[0] == 'input_hidden') echo "type = password ";
                    echo "name = \"$checkbox[2]\" "; if (isset($checkbox[3])) echo "title = \".$checkbox[3].\""; echo "><br>";
                }
                elseif ($checkbox[0] == 'select')
                {   
                    echo "$checkbox[1]<br>";
                    echo "<select name = '$checkbox[2]'>";
                    echo "<option></option>";
                    foreach ($checkbox[3] as $option)
                    {
                        echo "<option value = '$option'> $option </option>";
                    }
                    echo "</select><br>";
                }
            }
            echo "<input type = \"submit\" value = \"$submit_text\" title = \"$submit_text_title\">";
            echo "</form>";
        }

    function form1($title, $name, $value)
    {
        echo "<form method = 'POST'>";
        echo "<input type = 'hidden' name = '$name' value = '$value'>";
        echo "<input type = 'submit' value = '$title'>";
        echo "</form>";
    }
?>