<?php

return function() {
	return trim(
		$this->proc_exec("git rev-parse HEAD")[0]
	);
};
