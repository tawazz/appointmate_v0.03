<?php
    chdir('../classes');
    session_start();

    require_once('db.php');
    require_once('Session.php');
    require_once('input.php');
    require_once('Hash.php');
    require_once('Validate.php');
    require_once('User.php');
    require_once('Token.php');

    if(Input::exist()){
        if(Token::check(Input::get('token'))){
             $validate = new Validate();

            $validation = $validate->check($_POST,array(
                'fname'=> array(
                    'min'=> 2,
                    'max'=>30
                ),
                'lname'=> array(
                    'min'=> 2,
                    'max'=>30
                ),
                'email'=> array(
                    'required'=> TRUE,
                    'min'=> 4,
                    'max'=>60,
                    'unique'=>'users'
                ),
                'password'=> array(
                    'required'=> TRUE,
                    'min'=> 6
                ),
                'password_again'=> array(
                    'required'=> TRUE,
                    'min'=> 6,
                    'matches'=>'password'
                )
            ));

            if($validation -> passed()){
                $user = new User();
                try{
                    $user->create(array(
                    'fname'=>Input::get('fname'),
                    'lname'=>Input::get('lname'),
                    'password'=>Hash::make(Input::get('password'),strtolower(Input::get('email'))),
                    'email'=>strtolower(Input::get('email')),
                    'type'=> 1
                    ));
                }catch(Exception $e){
                    die($e->getMessage());
                }
                
                Session::flash('success',Input::get('fname').' You Have registers successfully');
                header('Location: ../index.php');
            }else{
                $err="";
                foreach ($validation->errors() as $value) {
                    $err .= $value;
                }
                header('Location: ../index.php?p=register&error='.$err);
            }
        }else{
            echo "expired token ";
        }
    }else{
        header("Location: index.html?error=something went wrong");
    }
?>