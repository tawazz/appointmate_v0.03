<?php
    chdir('../classes');
    session_start();
    include_once('db.php');
    include_once('Session.php');
    include_once('input.php');
    include_once('Hash.php');
    require_once('Token.php');


if(Input::exist()){
    if(Token::check(Input::get('token'))){
        
       $useremail= strtolower(Input::get('email'));
       $password = Hash::make(Input::get('password'),$useremail);
       $find = DB::connect()->query("select * from users where email= ? AND password= ? and (type =1 OR type =0)",array($useremail,$password));
       $user = $find->first();

       if($find->count()===1){
          
           Session::put('id',$user->id);
           header("Location : ../organizer.php");
           exit(0);
       }else{
           //echo"user name or password incorrect";
           header("Location : ../index.php?error=email or password is incorrect");
       }
    }else{
        echo "expired token";
    }
   
}else{
    echo "no input detected";
}
?>