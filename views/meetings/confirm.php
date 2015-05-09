<?php
if(isset($_POST["times"])){
    //selected meeting times
    $times= $_POST["times"];

    if(isset($_POST['bookingId'])){
        //create booking object from booking id
        $bookingId = $_POST['bookingId'];
    }else{
        die("booking id not set");
    }
    if(isset($_POST['file'])){
        //gets the temperal csv file
        $file = $_POST['file'];
        $file = substr($file,3);
    }else{
       die("file not set"); 
    }
}else{
    die("no times selected");
}
?>

<div class="col-xs-12 col-md-8 col-md-offset-2">
<div class="panel panel-primary">
    <div class="panel-heading">Confirm Booking</div>
    <div class="panel-body">
        <h5> Would you like to send Meeting invites to the list of attendee below? </h5>
        <div style="max-height: 450px; overflow: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $handle = fopen($file,"r");      
                        //loop through the csv file
                        $i =0;
                        do { 
                            if ($i>1) { //skip the first line
                                 echo"<tr>
                                        <td>{$data[0]}</td>
                                        <td>{$data[1]}</td>
                                        <td>{$data[2]}</td>
                                        <td>{$data[3]}</td>
                                    </tr>";
                            } 
                            $i++; 
                        } while ($data = fgetcsv($handle,1000,",","'")); 
                        //close the file stream                    
                        fclose($handle);
                    ?>
                </tbody>
            </table>
        </div>
        <form role="form" class="col-xs-6" style="margin: 0 auto;" name="meeting" method="post" action="functions/send_meetings.php">
            <div class="form-group">
                <input type="hidden" name="bookingId" value="<?php echo $bookingId;?>"/>
                <input type="hidden" name="file" value="<?php echo "../".$file;?>"/>
                <?php
                    foreach($times as $time){
                        echo "<input type=\"hidden\" name=\"times[]\" value=\"{$time}\"/>";
                    }
                ?>
                <button type="submit" class="btn btn-primary col-xs-12">Send Meeting Invites</button><br/>
            </div>
        </form>
        <form role="form" class="col-xs-6" style="margin: 0 auto;" name="meeting" method="post" action="functions/cancel_booking.php">
            <div class="form-group">
                <input type="hidden" name="bookingId" value="<?php echo $bookingId;?>"/>
                <input type="hidden" name="file" value="<?php echo "../".$file;?>"/>
                <button type="submit" class="btn btn-danger col-xs-12">Cancel</button><br/>
            </div>
        </form>
        
    </div>
</div>
</div>