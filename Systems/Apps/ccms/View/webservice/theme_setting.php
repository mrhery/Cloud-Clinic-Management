<?php

switch(Input::post("action")){
	case "toggle_sidebar":
		Session::set("hide_sidebar", !Session::get("hide_sidebar"));
	break;
}