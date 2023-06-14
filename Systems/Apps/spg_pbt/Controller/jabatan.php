<?php

switch (input::post("action")) {
	case "add":
		$d_name = Input::post("d_name");
		$d_code = Input::post("d_code");
		$d_status = Input::post("d_status");
		
		if($d_name != "" && $d_code != "" && $d_status != ""){
			$data = ["d_name" => $d_name, "d_code" => $d_code, "d_status" => $d_status ];
			
			$a = departments::insertInto($data);
			
			if($a){
				Alert::set("success", "Maklumat jabatan telah disimpan.");
			}else{
				Alert::set("error", "Gagal menyimpan data jabatan.");
			}
		}else{
			Alert::set("error", "Maklumat tidak lengkap.");
		}
		
    break;
	
    case "edit":
		$d_name = Input::post("d_name");
		$d_code = Input::post("d_code");
		$d_status = Input::post("d_status");
		$d_id = url::get(3);
		
		
		if($d_name != "" && $d_code != "" && $d_status != ""){
			$data = ["d_name" => $d_name, "d_code" => $d_code, "d_status" => $d_status ];
			
			$a = departments::updateBy(["d_id" => $d_id],$data);
			
			if($a){
				Alert::set("success", "Maklumat jabatan telah disimpan.");
			}else{
				Alert::set("error", "Gagal menyimpan data jabatan.");
			}
		}else{
			Alert::set("error", "Maklumat tidak lengkap.");
		}
		
    break;
	
	  case "delete":
		$d_id = url::get(3);
			
		if($d_id != "" ){
			$aa = departments::deleteBy(["d_id" => $d_id]);
			
			if($aa){
				Alert::set("success", "Maklumat gerai telah dipadam.", 
				[
					"redirect"    => PORTAL . "settings/jabatan/"
				]);
			}else{
				Alert::set("error", "Gagal memadam data jabatan.");
			}
		}else{
			Alert::set("error", "Maklumat jabatan tidak dijumpai.");
		}
		
    break;
}
