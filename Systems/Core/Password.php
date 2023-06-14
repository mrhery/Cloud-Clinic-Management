<?php


class Password {
	public static function get($data){
		return hash("sha256", $data . '#@$VSV$$#F#$F3f43f434f34f#F$3f3$^#^%$^');
	}
}

