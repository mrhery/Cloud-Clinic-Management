<?php

switch(Input::post("action")){

	case "delete":
		// die("delete here");
		$t_key = url::get(2);

		// Debug: Show t_key in browser console
		echo "<script>console.log('t_key: " . $t_key . "');</script>";
	    $t = tips::deleteBy(["t_key" => url::get(2), "t_business" => Session::get("clinic")->c_id]);
		
		if ($t) {
			Alert::set("success", "Tips has been deleted successfully.",
			[
				"redirect"	=> PORTAL . "tips"
			]);
		} else {
			new Alert("error", "Failed to delete tips.");
		}
	break;
	
	case "add":
		$tkey = F::UniqKey("tips_");
		
		tips::insertInto([
			"t_user"		=> Session::get("user")->u_id,
			"t_content"		=> Input::post("content"),
			"t_business"	=> Session::get("clinic")->c_id,
			"t_createdDate"	=> date("Y-m-d H:i:s"),
			"t_date"		=> Input::post("time"),
			"t_key"			=> $tkey
		]);
		
		$t = tips::getBy(["t_key" => $tkey]);
		
		if(count($t) > 0){
			$t = $t[0];
			
			if(
				isset($_FILES["attachments"]) && 
				is_array($_FILES["attachments"]["name"]) &&
				count($_FILES["attachments"]["name"]) > 0
			){
				for($i = 0; $i < count($_FILES["attachments"]["name"]); $i++){
					$oldfname = $_FILES["attachments"]["name"][$i];
					$oldtemp = $_FILES["attachments"]["tmp_name"][$i];
					$newfname = F::UniqKey("file_") . $oldfname;
					$path = ASSET . "tips_media/" . Session::get("clinics")->c_ukey;
					
					if(!is_dir($path)){
						@mkdir($path, 0755, true);
					}
					
					if(
						move_uploaded_file($oldtemp, $path . "/" . $newfname)
					){
						$tmkey = F::UniqKey("tips_media_");
						
						tips_media::insertInto([
							"tm_post"		=> $t->t_id,
							"tm_type"		=> $_FILES["attachments"]["type"][$i],
							"tm_url"		=> $newfname,
							"tm_created"	=> date("Y-m-d H:i:s"),
							"tm_business"	=> Session::get("clinic")->c_id,
							"tm_key"		=> $tmkey
						]);
					}
				}
			}
			//post_media
			
			Alert::set("success", "Post data has been saved successfully.");
		}else{
			Alert::set("error", "Post data cannot be save at the moment.");
		}
	break;

    case "edit":
        // die("edit here");

        $data = [
            "t_content" 	=> Input::post("content"),
            "t_date"		=> Input::post("date")
        ];

        $t = tips::updateBy(["t_key" => url::get(3), "t_business" => Session::get("business")->c_id], $data);

        if($t){
        Alert::set("success","post have been successfully updated.");
        }else{
        Alert::set("error","post cannot be updated. Post not found.");
        }
    break;
}