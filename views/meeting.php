<?php

    function actMenu($str, $p =''){
         if(isset($_GET[$p])){
             $p = $_GET[$p];
         }
        return $p == $str ? FALSE : TRUE;
    }
?>

<div class="col-xs-12">
    <ol class="breadcrumb">
        <?php
            if(isset($_GET['m'])){

                $pos = $_GET['m'];
                switch ($pos) {
                  case 'setup':
                    echo "<li class='active'>Set Up Meetings</li>";
                    echo "<li class='blue'>Pick Times</li>";
                    echo "<li class='blue'>Confirm</li>";
                    break;
                  case 'pick_times':
                    echo "<li class='active'>Set Up Meetings</li>";
                    echo "<li class='active'>Pick Times</li>";
                    echo "<li class='blue'>Confirm</li>";
                    break;
                  case 'confirm':
                    echo "<li class='active'>Set Up Meetings</li>";
                    echo "<li class='active'>Pick Times</li>";
                    echo "<li class='active'>Confirm</li>";
                    break;
                  default:
                    echo "<li class='active'>Set Up Meetings</li>";
                    echo "<li class='blue'>Pick Times</li>";
                    echo "<li class='blue'>Confirm</li>"; "<li>Confirm</li>";
                }
            }else{
                echo "<li class='active'>Set Up Meetings</li>";
                echo "<li class='blue'>Pick Times</li>";
                echo "<li class='blue'>Confirm</li>";
            }
        ?>
    </ol>
</div>
<div class="col-xs-12">
    <?php
        $m='';

        if(isset($_GET['m'])){
            $m = $_GET['m'];
            file_exists("views/meetings/".$m.".php") ? include("views/meetings/".$m.".php") : include("views/file_not_found.php");
        }else{
            $m = 'setup';
            include("views/meetings/".$m.".php");
        }
    ?>
</div>



