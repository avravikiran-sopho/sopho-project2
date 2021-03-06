<?php

    // configuration
    require("../controllers/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $q = sprintf("DELETE FROM items WHERE id='%s'", $_POST["delete"]);
        $r = mysqli_query($link, $q);
        
        if($r === false)
            apologize("Can not remove item.");
    }
    
    if(!empty($_GET["category"]))
        $query = sprintf("SELECT * FROM items WHERE category='%s' AND seller_id='%s'", $category[$_GET['category']], $_SESSION["id"]);
    else
        $query = sprintf("SELECT * FROM items WHERE seller_id = '%d'", $_SESSION["id"]);
        
    $rows = mysqli_query($link, $query);
  
    if(mysqli_num_rows($rows) == 0)
        apologize("You haven't put any item on sale yet.");
    
    while($row = mysqli_fetch_array($rows))
    {
        $positions[] = [
            "id"  => $row["id"],
            "path" => $row["path"],
            "title" =>  $row["title"],
            "price" => number_format($row["price"], 2),
            "description" => $row["description"],
            "category" => $row["category"],
            "date" => $row["date"]
            ];
    }

    
    // rendestoreioStore
    render("dashboard.php", ["title" => "Dashboard", "position" => $positions]);

?>