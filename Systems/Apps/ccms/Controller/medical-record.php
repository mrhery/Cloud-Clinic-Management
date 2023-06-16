<?php

switch(Input::post("action")){
	case "create":
		if(!empty(Input::post("name")) && !empty(Input::post("ic"))){
			
			if(Session::get("admin")){
				$c = customers::getBy(["c_ic" => Input::post("ic")]);
			}else{
				$c = customers::getBy(["c_ic" => Input::post("ic"), "c_id" => function($cl){
					return "$cl IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = '". Session::get("clinic")->c_id ."')";
				}]);
			}
			
			if(count($c) > 0){
				$c = $c[0];
				
				customer_record::insertInto([
					"cr_customer" 		=> $c->c_id,
					"cr_date"			=> F::GetDate(),
					"cr_time"			=> F::GetTime(),
					"cr_user"			=> Session::get("user")->u_id,
					"cr_title"			=> Input::post("title"),
					"cr_description"	=> Input::post("description"),
					"cr_clinic"			=> Session::get("clinic")->c_id
				]);
				
				Alert::set("success", "Appointment record has been created.");
			}else{
				Alert::set("error", "Fail registering customer's information.");
			}
		}else{
			Alert::set("error", "Customer name and IC Number is required.");
		}
	break;
}