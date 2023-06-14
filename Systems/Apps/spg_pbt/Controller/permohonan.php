<?php

switch (input::post("action")) {
	case "add":

		
		$arr = $_FILES["titles"]["name"];
		$arrlabel = Input::post("doklabel");

		if (!empty(Input::post("name"))) {
			$key = F::UniqKey();
			
			$filename = "";
			$gambar_filename = "";
			
			if ( file_exists($_FILES["ssm"]["tmp_name"]) && is_uploaded_file($_FILES["ssm"]["tmp_name"]) ) {
				$name = $_FILES["ssm"]["name"];
				$gambar_name = $_FILES["gambar"]["name"];
				$tmp = $_FILES["ssm"]["tmp_name"];
				$gambar_tmp = $_FILES["gambar"]["tmp_name"];
				$filename = F::uniqKey() . F::URLSlugEncode($name);
				$gambar_filename = F::uniqKey() . F::URLSlugEncode($gambar_name);
				$ext = pathinfo($filename)["extension"];
			}

			if (!file_exists('assets/images/ssm')) {
				mkdir('assets/images/ssm', 0777, true);
			}
			if (!file_exists('assets/images/permohonan')) {
				mkdir('assets/images/permohonan', 0777, true);
			}

			move_uploaded_file($tmp,  "assets/images/ssm/$filename");
			move_uploaded_file($gambar_tmp,  "assets/images/permohonan/$gambar_filename");
			
			
			

			$a = applications::insertInto([
				"a_name"	=> 	Input::post("name"),
				"a_email"	=> 	Input::post("email"),
				"a_ic"		=> 	Input::post("ic"),
				"a_alamat"	=> 	Input::post("alamat"),
				"a_phone"	=> 	Input::post("phone"),
				"a_time"	=> 	F::GetTime(),
				"a_key"		=> 	$key,
				"a_shop"	=> 	Input::post("shop_picked"),
				"a_gambar"	=> 	$gambar_filename,
				"a_date"    =>  date('Y-m-d h:m:s'),
				"a_mp"		=>	Input::post("maklumatPerniagaan"),
				"a_ssm"		=>	$filename,
			]);
			
			if ($a) {
				$xz = applications::getBy(["a_key" => $key]);

				if (count($xz) > 0) {
					$xz = $xz[0];

					application_status::insertInto([
						"as_application"  => $xz->a_id,
						"as_date"         => date('Y-m-d h:m:s'),
						"as_time"         => F::GetTime(),
					]);
				} else {
					//error
					Alert::set("success", "Gagal mengambil maklumat status.");
				}
					for ($x = 0; $x < count($arrlabel); $x++) {
						$dokumen_filename = "";
						$dokumen_name = $_FILES["titles"]["name"][$x];
						$dokumen_tmp = $_FILES["titles"]["tmp_name"][$x];
						$dokumen_filename = F::uniqKey() . F::URLSlugEncode($dokumen_name);
						if (!file_exists('assets/dokumen')) {
							mkdir('assets/dokumen', 0777, true);
						}
						move_uploaded_file($dokumen_tmp,  "assets/dokumen/$dokumen_filename");

						application_files::insertInto([
							"apf_application" => $xz->a_id,
							"apf_name" => $arr[$x],
							"apf_label" => $arrlabel[$x],
						]);
					}
				 
			} else {
				Alert::set("success", "Gagal menyimpan data permohonan.");
			}
			
			Alert::set(
				"success",
				"Maklumat permohonan gerai telah disimpan.",
				[
					"redirect"    => PORTAL . "permohonan/gerai"
				]
			);
		} else {
			Alert::set("error", "Data Tidak Lengkap");
		}

		break;

	case "edit":

		if (
			!empty(Input::post("name")) &&
			!empty(Input::post("email")) &&
			!empty(Input::post("ic"))
		) {
			applications::updateBy(
				["a_id" => url::get(3)],
				[
					"a_name"	=> 	Input::post("name"),
					"a_email"	=> 	Input::post("email"),
					"a_ic"		=> 	Input::post("ic"),
					"a_alamat"	=> 	Input::post("alamat"),
					"a_phone"	=> 	Input::post("phone"),
					"a_time"	=> 	F::GetTime(),
					"a_shop"	=> 	Input::post("shop_picked"),
					"a_gambar"	=> 	Input::post("gambar"),
					"a_date"    =>  date('Y-m-d h:m:s'),
					"a_mp"		=>	Input::post("maklumatPerniagaan"),
					"a_ssm"		=>	Input::post("ssm"),
				]
			);

			Alert::set(
				"success",
				"Maklumat permohonan gerai telah dikemaskini.",
				[
					"redirect"    => PORTAL . "permohonan/gerai"
				]
			);
		} else {
			Alert::set("error", "Maklumat diri adalah wajib!");
		}

		break;

	case "delete":

		applications::deleteBy(["a_id" => url::get(3)]);

		Alert::set(
			"success",
			"Maklumat gerai telah dipadam.",
			[
				"redirect"    => PORTAL . "permohonan/gerai"
			]
		);

		break;

		//"as" here means application status, so "edit_as" == edit application status
	case "edit_as":

		$as = application_status::getBy(["as_application" => url::get(3)]);
		
		application_status::updateBy(
			["as_id" => $as[0]->as_id],
			[
				"as_status"         => Input::post("status"),
				"as_description"    => Input::post("description"),
				"as_date"           => date("Y-m-d h:m:s"),
				"as_time"           => F::GetTime(),
				"as_user"           => $_SESSION["user"]->data->u_id,
			]
		);

		Alert::set(
			"success",
			"Maklumat status permohonan berjaya diubah.",
			[
				"redirect"    => PORTAL . "permohonan/gerai/edit/" . url::get(3)
			]
		);
		break;
}
