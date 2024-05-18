<?php


switch(url::get(2)){
	case "dashboard":
		Page::Load("apis/dashboard", ["c" => $c]);
	break;
}