<?php

switch (input::post("action")) {

	case "edit":
		
		$c 	= contracts::getBy(["c_id" => url::get(3)]);
		$cs	= contracts_status::getBy(["cs_contracts" => url::get(3)]);
		
		if (
			!empty(Input::post("datestart")) &&
			!empty(Input::post("dateend")) 
		) {
			contracts::updateBy(
				["c_id" => url::get(3)],
				[
					"c_dateStart"	=> 	Input::post("datestart"),
					"c_dateEnd"		=> 	Input::post("dateend"),
				]
			);
			
			Alert::set(
				"success",
				"Maklumat tempoh kontrak berjaya dikemaskini.",
				[
					"redirect"    => PORTAL . "permohonan/pembaharuan"
				]
			);
		} 
		else {
			Alert::set("error", "Tarikh tempoh adalah wajib!");
		}

	break;

	case "edit_cs":

		$c 			= contracts::getBy(["c_id" => url::get(3)]);
		$cs 		= contracts_status::getBy(["cs_contracts" => url::get(3)]);
		$order 		= contracts::list(["order" => "c_id DESC"]);
		$status 	= Input::post("status");
		
		if($status == 1)
		{
			$ccc = current($order);
			$main = $ccc->c_id + 1;
			
			$newContract = contracts::insertInto([
				"c_shop"		=>	$c[0]->c_shop,
				"c_tenant"		=>	$c[0]->c_tenant,
				"c_pic"			=>	Session::get('user')->u_id,
				"c_council"		=>	$c[0]->c_council,
				"c_price"		=>	$c[0]->c_price,
				"c_deposit"		=>	$c[0]->c_deposit,
				"c_shopType"	=>	$c[0]->c_shopType,
				"c_key"			=>	F::UniqKey("CONTRACT_"),
				"c_refer"		=>	$c[0]->c_refer,
				"c_fail"		=>	$c[0]->c_fail,
				"c_main"		=>	$main,
				"c_after"		=>	0,
				"c_updateBy"	=>	Session::get('user')->u_id,
				"c_dateStart"	=>	$c[0]->c_dateStart,
				"c_dateEnd"		=>	$c[0]->c_dateEnd,
				
			]);
			
			if($newContract)
			{
				$cidNew = contracts::getBy(["c_id" => $main]);
				
				contracts_status::insertInto([
					"cs_contracts"		=> 	$cidNew[0]->c_id,
					"cs_status"			=>	1,
					"cs_user"			=>	$c[0]->c_tenant,
					"cs_date"			=>	date("Y-m-d h:m:s"),
					"cs_time"			=>	F::GetTime(),
					"cs_description"	=>	"Permohonan Lulus"
				]);
			}
			else{
				Alert::set(
				"success",
				"Maklumat kontrak tidak dijumpai.",
				[
					"redirect"    => PORTAL . "permohonan/pembaharuan"
				]
			);
			}
			
			Alert::set(
				"success",
				"Permohonan kontrak berjaya diperbaharui.",
				[
					"redirect"    => PORTAL . "permohonan/pembaharuan"
				]
			);
		}
		else
		{
			if($cs)
			{
				contracts_status::insertInto([
						"cs_contracts"		=> $c[0]->c_id,
						"cs_status"         => Input::post("status"),
						"cs_description"    => Input::post("description"),
						"cs_date"           => date("Y-m-d h:m:s"),
						"cs_time"           => F::GetTime(),
						"cs_user"           => $c[0]->c_tenant,
				]);

				Alert::set(
					"success",
					"Maklumat status permohonan berjaya diubah.",
					[
						"redirect"    => PORTAL . "permohonan/pembaharuan/edit/" . url::get(3)
					]
				);
			}
			else{
				Alert::set(
					"error",
					"Maklumat status tidak dijumpai.",
					[
						"redirect"    => PORTAL . "permohonan/pembaharuan/edit/" . url::get(3)
					]
				);
			}
		}
		
		
	break;
}
