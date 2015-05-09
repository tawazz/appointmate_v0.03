<?php
    include_once('Pages.php');
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $page = new Pages();
        $page_result = $page->getPage($id);

    }else{
        echo "page not found";
    }
        
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $page_result->title; ?></title>
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    <body>
        <div class="container">
            <a href="index.php" id="logo">CMS</a>
            <?php
                echo"<h4>".$page_result->title."</h4>";
                echo "<p>".$page_result->content ."</p>";
            ?>
            <a href="index.php">&larr;Back</a>
        </div>
    </body>
</html>
