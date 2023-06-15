<?php
/***********************************************
;"Hery PHP Framework (HPF) v3";
;"Designed and Developed at Min September 2018";
;"Intelligent Hosting Pte. Ltd. (1158583-U)";
;"Master Hery (iamhery.com)";
************************************************/

define("HFA", true);
require_once(__DIR__ . "/Systems/init.php");

define("ASSET", __DIR__ . "/assets/");

(new App("Cloud Clinic Management System - CCMS", "ccms"))->run();
