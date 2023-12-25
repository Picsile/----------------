<?php

    require_once("json functions.php");

    class Souvenir
    {
        public $name;
        public $description;
        public $category;
        public $price;
        public $image_url;
        public $stock;
        public $offer;
        public $id;

        static protected $image_size = [500, 500];

        public function __construct($name, $description, $category, $price, $image_url, $stock, $id, $offer=null)
        {
            $this->name = $name;
            $this->description = $description;
            $this->category = $category;
            $this->price= $price;
            $this->image_url = $image_url;
            $this->stock = $stock;
            $this->id = $id;
            $this->offer = $offer;
        }

        public function printSouvenir()
        {
            echo "<h4>$this->name</h4>";
            echo "Описание: $this->description<br>";
            echo "Цена: $this->price<br>";
            if ($this->offer != null) echo "Акция: $this->offer";
            if ($this->image_url != "") echo "<img src = $this->image_url height = ", self::$image_size[0], " width = ", self::$image_size[1], ">";
        }
    }

    function items2ObjSourveneers($data)
    {   
        $obj_arr=[];
        foreach ($data as $item)
        {
            $obj_arr[] = new Souvenir(
                $item["name"],
                isset($item["description"]) ? $item["description"] : null,
                $item["category"],
                $item["price"],
                isset($item["image_url"]) ? $item["image_url"] : null,
                $item["stock"],
                $item["id"],
                isset($item["offer"]) ? $item["offer"] : null
            );
        }
        return $obj_arr;
    }
?>