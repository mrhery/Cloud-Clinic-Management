<?php

class UserAuthentication {
	public static function check(){
		if(
			!empty(Input::post("username")) && 
			!empty(Input::post("password")) && 
			!empty(Input::post("ukey"))
		){			
			$u = customers::getBy([
				"c_email"		=> Input::post("username"),
				"c_password"	=> Input::post("password"),
				"c_ukey"		=> Input::post("ukey")
			]);
			
			if(count($u) > 0){
				$u = $u[0];
				
				return $u;
			}else{
				die(json_encode([
					"status"	=> "error",
					"message"	=> "Email or password is not correct."
				]));
			}
		}else{
			die(json_encode([
				"status"	=> "error",
				"message"	=> "Insufficient request parameter."
			]));
		}
	}
}