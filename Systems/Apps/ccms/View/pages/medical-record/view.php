<?php

if(empty(url::get(3))){
	Page::Load("pages/medical-record/record/view");
}else{
	Page::Load("pages/medical-record/record/view-record");
}


?>

