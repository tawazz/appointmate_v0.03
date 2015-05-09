<?php
    session_start();
    chdir('../classes');
    include_once('Session.php');
?>
<div class="form">
    <form action="../functions/updateAdmin.php" method="post" name="updateAdmin" >
        <div class="header">
            <h2>Change Account Details</h2>
        </div>
        <label>
            username
            <input type="text" name="username" autocomplete="off" readOnly="true" value="<?php echo Session::get('userName');?>"/>
        </label>
        <label>
            old password
            <input type="password" name="old_password"/>
        </label>
        <label>
            new password
            <input type="password" name="new_password"/>
        </label>
        <input type="submit" value="Change"/>
    </form>
</div>