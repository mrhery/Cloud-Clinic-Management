<?php

switch (input::post("action")) {
    case"recover-password":

        $u = users::getBy([
			"u_email" => Input::post("email"),
			"u_password" => Password::get(Input::post("password"))
		]);

        if(count($u) > 0){
            users::updateBy([
                "u_email" => Input::post("email")
            ],[
                "u_password" => Password::get(Input::post("newpassword"))
            ]);
            
            $u = users::getBy([
                "u_email" => Input::post("email")
            ])[0];

            header("Location: " . PORTAL . "login");

        }else{
        
            Alert::set("error", "Email or Password not match");

        }
        

    break;
        
}
