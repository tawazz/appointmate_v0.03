<?php
     chdir('classes');
    require_once('Token.php');
?>
<div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <h3><?php echo Session::flash('success');?></h3>
            <form role="form" class="" style="margin: 0 auto;" name="login" action="functions/login.php" method="post">
                <div class="form-group">
                <label for="username">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email">
                </div>
                <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate();?>"/>
                <button type="submit" class="btn btn-primary">Log In</button><br/>
                <?php
                    if(isset($_GET['error'])){
                        $error = $_GET['error'];
                        echo "<span class='glyphicon glyphicon-warning-sign text-danger'> ".$error."</span>";
                    }
                ?>
                <span class="help-block">If you don't have an account <a href="index.php?p=register">register here</a></span>
        
            </form>
        </div>
  </div>
</div>