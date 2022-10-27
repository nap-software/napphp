<?php

return function($fn, $interval) {
	$loop = true;

	$stop_loop_function = function() use (&$loop) {
		$loop = false;
	};

	while ($loop) {
		$start = $this->sys_getHRTime();

		$fn($stop_loop_function);

		$execution_time = $this->sys_getHRTime() - $start;

		$delta = $interval- $execution_time;

		if ($delta > 0) {
			$this->sys_uninterruptibleSleep($delta);
		}
	}
};
