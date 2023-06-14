<?php

switch (input::post("action")) {
	
	case "add":
		

        $arrr =  $_FILES;
        $arr = $_FILES["vidf"]["name"]; /* reutn file name madnor */
        $arre = $_FILES["vidt"]; 
        /* die(var_dump($arre)); */
        

		$title = Input::post("title");

		if (!empty(Input::post("title"))) {
			$key = F::UniqKey();
			
			$filename = "";
			$gambar_filename = "";
			$thumbnail = "";

            if ( file_exists($_FILES["vidt"]["tmp_name"]) && is_uploaded_file($_FILES["vidt"]["tmp_name"]) ) {
				 
				$thumbnail_name = $_FILES["vidt"]["name"];
				 
				$thumbnail_tmp = $_FILES["vidt"]["tmp_name"];
				$filenameee = F::uniqKey() . F::URLSlugEncode($thumbnail_name);
				$gambar_filenameeee = F::uniqKey() . F::URLSlugEncode($thumbnail_tmp);
				$ext = pathinfo($filenameee)["extension"];
			}

			if (!file_exists('assets/vids')) {
				mkdir('assets/images/ssm', 0777, true);
			}
			if (!file_exists('assets/vids')) {
				mkdir('assets/images/permohonan', 0777, true);
			}

			 
			move_uploaded_file($thumbnail_tmp,  "assets/tutorial_thumnails/$filenameee");

            /* -------------- */
			
			if ( file_exists($_FILES["vidf"]["tmp_name"]) && is_uploaded_file($_FILES["vidf"]["tmp_name"]) ) {
				 
				$gambar_name = $_FILES["vidf"]["name"];
				 
				$gambar_tmp = $_FILES["vidf"]["tmp_name"];
				$filename = F::uniqKey() . F::URLSlugEncode($gambar_name);
				$gambar_filename = F::uniqKey() . F::URLSlugEncode($gambar_name);
				$ext = pathinfo($filename)["extension"];
			}

			if (!file_exists('assets/vids')) {
				mkdir('assets/images/ssm', 0777, true);
			}
			if (!file_exists('assets/vids')) {
				mkdir('assets/images/permohonan', 0777, true);
			}

			move_uploaded_file($gambar_tmp,  "assets/vids/$gambar_filename"); 

            tutorial_video::insertInto([
                "tv_title" => Input::post("title"),
                "tv_desc" => $gambar_filename ,
                "tv_thumbnail" => $filenameee ,
            ]);

         /* if(Input::post("status") || Input::post("status")) */

		Alert::set(
			"success",
			"Video Berjaya Ditambah",
			[
				"redirect"    => PORTAL . "tutorial"
			]
		);
		break;
    }
}