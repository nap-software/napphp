<?php

return function($str, $search, $replace) {
	return str_replace($search, $replace, $str);
};
