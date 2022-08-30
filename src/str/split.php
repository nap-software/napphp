<?php

return function($str, $delimiter, $limit = NULL) {
	if ($limit !== NULL) {
		return explode($delimiter, $str, $limit);
	} else {
		return explode($delimiter, $str);
	}
};
