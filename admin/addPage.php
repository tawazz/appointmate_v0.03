<?php
    chdir('../');
    include_once("Pages.php");
    if(isset($_POST['title'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $time = date('Y-m-d H:i:s');

        $page = new Pages();

        $page->create(array(
            'title'=> $title,
            'content'=> $content,
            'time'=> $time
        ));
        echo "page added";
        header("Location: admin.php?success= page added");
    }

?>
