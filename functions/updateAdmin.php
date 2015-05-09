<?php
    session_start();
    chdir('../classes');
    include_once('db.php');
    include_once('input.php');
    include_once('Hash.php');
    include_once('User.php');
    include_once('Session.php');
    include_once('Validate.php');

    if(Input::exist()){
        $validate = new Validate();

            $validation = $validate->check($_POST,array(
                'old_password'=> array(
                    'min'=> 6,
                    'required'=> TRUE
                ),
                'new_password'=> array(
                    'min'=> 6,
                    'required'=> TRUE
                )
            ));

            if($validation -> passed()){
                $user = new User();

                try{
                    $user->update(array("id","=",Session::get('id')),array(
                    'password'=>Hash::make(Input::get('new_password'),Session::get('userName'))
                    ));
                }catch(Exception $e){
                    die($e->getMessage());
                }

                Session::flash('success','you updated successfully');
                header('Location: ../admin/admin.php');
            }else{
                print_r($validation->errors());
            }
    }else{
        echo "no input detected";
    }
?>
