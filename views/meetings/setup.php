<div class="col-xs-12 col-md-8 col-md-offset-2">
<div class="panel panel-primary">
    <div class="panel-heading">Create Booking</div>
    <div class="panel-body">
        <form role="form" class="" style="margin: 0 auto;" name="metting" method="post" action="functions/handle_files.php" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-xs-12 col-md-3">Meeting Subject</label>
                <div class="col-xs-12 col-md-9">
                    <input type="text" name="name" class="form-control" /><br/>
                </div>
            </div>
            <div class="form-group">
            <label class="col-xs-12 col-md-3">Upload Excel File of Attendees</label>
                <div class="col-xs-12 col-md-9">
                    <input  type="file" name="time" class="form-control" />
                    <p class="help-block"><a href="apointmate.csv">download template</a></p>
                </div>   
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-md-3">Duration Of Each Meeting</label>
                <div class="col-xs-12 col-md-9">
                    <select name="duration" class="form-control">
                        <option value="5">5 minutes</option>
                        <option value="10">10 minutes</option>
                        <option value="15">15 minutes</option>
                        <option value="30">30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">1 Hour</option>
                        <option value="90">1 Hour 30mins</option>
                        <option value="105">1 Hour 45mins</option>
                        <option value="120">2 Hours</option>
                        <option value="150">2 Hour 30mins</option>
                        <option value="165">2 Hour 45mins</option>
                        <option value="180">3 Hours</option>
                        <option value="210">3 Hour 30mins</option>
                        <option value="225">3 Hour 45mins</option>
                        <option value="240">4 Hours</option>
                    </select><br/>
                </div>
            </div>
             <div class="form-group">
                <label class="col-xs-12 col-md-3">Location Of Meetings</label>
                 <div class="col-xs-12 col-md-9">
                    <input type="text" name="location" class="form-control" /><br/>
                 </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-md-3">Message to Attendees </label>
                 <div class="col-xs-12 col-md-9">
                    <textarea style="resize:none;" name="description" class="form-control" rows="6" ></textarea><br/>
                 </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary col-xs-12 col-md-3">Next</button><br/>
            </div>
            <?php
                if(isset($_GET['error'])){
                    $error = $_GET['error'];
                    echo "<span class='glyphicon glyphicon-warning-sign text-danger'> ".$error."</span>";
                }
            ?>
        
        </form>
    </div>
</div>
</div>