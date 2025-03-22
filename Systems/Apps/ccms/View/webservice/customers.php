<?php

switch(Input::post("action")){
	case "search":
		$c = DB::conn()->query("SELECT c_name as name, c_ic as ic, c_phone as phone, c_email as email, c_ukey as id 
				FROM customers 
				WHERE (c_name LIKE ? OR c_ic LIKE ? OR c_phone LIKE ? OR c_email LIKE ?)", 
				[
					"%" . Input::post("skey") . "%",
					"%" . Input::post("skey") . "%",
					"%" . Input::post("skey") . "%",
					"%" . Input::post("skey") . "%"
				]
			)->results();
		
		die(json_encode([
			"status"		=> "success",
			"data"			=> $c
		]));
	break;
	
	case "get":
		$c = DB::conn()->query("SELECT c_name as name, c_ic as ic, c_phone as phone, c_email as email, c_ukey as id, c_id as idno FROM customers WHERE (c_ukey = ?) AND c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", // AND c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)
		[
			Input::post("c_id"),
			Session::get("clinic")->c_id
		])->results();
		
		if(count($c) > 0){
			$c = $c[0];
			
			$appointments = [];
			$as = DB::conn()->query("SELECT a_ukey as id, a_bookedDate as bookedDate, a_bookedTime as bookedTime, a_attendee as attendee, a_date, a_customer as customer, a_status as status, a_reason as reason FROM appointments WHERE a_clinic = ? AND a_customer = ?", [Session::get("clinic")->c_id, $c->idno])->results();
			
			foreach($as as $a){
				$dr = users::getBy(["u_id" => $a->attendee]);
			
				if(count($dr) > 0){
					$a->attendee = $dr[0]->u_name;
				}else{
					$a->attendee = "Unset";
				}
				
				$appointments[] = $a;
			}
			
			$c->appointments = $appointments;
			
			$invoices = [];
			$sales = DB::conn()->query("SELECT s_date as invoiceDate, s_total as total, s_paid as paid, s_remark as remark, s_doc as no FROM sales WHERE s_customer = ? AND s_clinic = ?", [$c->idno, Session::get("clinic")->c_id])->results();
			
			$c->sales = $sales;
			
			unset($c->idno);
			
			die(json_encode([
				"status"		=> "success",
				"data"			=> $c
			]));
		}else{
			die(json_encode([
				"status"		=> "error",
				"message"		=> "No customer information were found.",
				"data"			=> null
			]));
		}
	break;
}