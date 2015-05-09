<?php
    chdir('classes');
    require_once('Token.php');
?>

<div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Register</div>
        <div class="panel-body">
            <form role="form" style="margin: 0 auto;" name="regester" action="functions/register.php" method="post">
                <div class="form-group">
                <label for="First Name">First Name</label>
                <input type="text" class="form-control" name="fname" placeholder="Enter your first name">
                </div>
                <div class="form-group">
                <label for="First Name">Last Name</label>
                <input type="text" class="form-control" name="lname" placeholder="Enter your last name">
                </div>
                <div class="form-group">
                <label for="First Name">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email">
                </div>
                <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Your Password">
                </div>
                <label for="password">Confirm Password</label>
                <input type="password" class="form-control" name="password_again" placeholder="Confirm Password">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate();?>"/>
                <button type="submit" class="btn btn-primary">Register</button><br/>
                <?php
                    if(isset($_GET['error'])){
                        $error = $_GET['error'];
                        echo "<span class='glyphicon glyphicon-warning-sign text-danger'> ".$error."</span>";
                    }
                ?>
                <span class="help-block"><p>If you already have an account <a href="index.php">Login here</a></p></span>
            </form>
        </div>
  </div>
</div>