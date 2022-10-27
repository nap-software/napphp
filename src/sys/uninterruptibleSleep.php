<?php

return function($amount) {
	$start = $this->sys_getHRTime();

	while (true) {
		$elapsed = $this->sys_getHRTime() - $start;

		if ($elapsed >= $amount) {
			break;
		}

		$this->sys_delay(250);
	}
};
