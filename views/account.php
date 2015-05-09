<div class="col-xs-12 col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading text-center"> Account Details</div>
            <div class="panel-body">
                <p class="col-xs-12 col-md-4">First Name</p><p class="col-xs-8 text-capitalize"> <?php echo $fname?> </p>
                <p class="col-xs-12 col-md-4">Last Name</p><p class="col-xs-8 text-capitalize"> <?php echo $lname?> </p>
                <p class="col-xs-12 col-md-4">Email </p><p class="col-xs-8"> <?php echo $User->first()->email?>  </p>
                <p class="col-xs-12 col-md-4">User Type</p><p class="col-xs-8"> <?php echo $User->first()->type?>  </p>
                <a class="col-xs-12 col-md-4" href="#">Change Password: </a>
            </div>
        </div>
    </div>
</div>