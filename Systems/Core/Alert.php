<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Alert{
	public function __construct($type, $message, $style = "", $class = ""){	
		switch($type){
			case "success":
			?>
				<div class="alert alert-success alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
			
			case "error":
			?>
				<div class="alert alert-danger alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Error!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
			
			case "warning":
			?>
				<div class="alert alert-warning alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Warning!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
			
			case "info":
			?>
				<div class="alert alert-info alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<strong>Notice!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
		}
	}
	
	public static function set($type = "success", $message = "", $set = []){
		$style = "";
		if(isset($set["style"])){
			$style = $set["style"];
		}
		
		$class = "";
		if(isset($set["class"])){
			$class = $set["class"];
		}
		
		$redirect = "";
		if(isset($set["redirect"])){
			$redirect = $set["redirect"];
		}
		
		Session::set("alert", [
			"type"		=> $type,
			"message"	=> $message,
			"style"		=> $style,
			"class"		=> $class,
			"redirect"	=> $redirect
		], false);
	}
}

?>