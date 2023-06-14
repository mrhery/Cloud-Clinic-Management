<?php

class Session {	
	public static function destroy($name){
		if(isset($_SESSION[$name])){
			unset($_SESSION[$name]);
			return true;
		}else{
			return false;
		}
	}
	
	public static function update($name, $data, $temp = false){
		if(isset($_SESSION[$name])){
			$_SESSION[$name] = (object)[
				"name"	=> $name,
				"data"	=> $data,
				"temp"	=> $temp
			];
		}else{
			return false;
		}
	}
	
	public static function exists($name){
		if(isset($_SESSION[$name])){
			return true;
		}else{
			return false;
		}
	}
	
	public static function get($name = ""){
		if(isset($_SESSION[$name])){
			if(isset($_SESSION[$name]->data)){
				if($_SESSION[$name]->temp){
					$data = $_SESSION[$name]->data;
					self::destroy($name);
					
					return $data;
				}else{
					return $_SESSION[$name]->data;
				}
			}
		}else{
			return false;
		}
	}
	
	public static function set($name, $data, $temp = false){
		$_SESSION[$name] = (object)[
			"name"	=> $name,
			"data"	=> $data,
			"temp"	=> $temp
		];
	}
}