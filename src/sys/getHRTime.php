<?php

return function() {
	$millis = 0;

	//[seconds, nanoseconds]
	list($seconds, $nanoseconds) = hrtime(false);

	$millis += ($seconds * 1E3);
	$millis += ($nanoseconds / 1E6);

	return (int)$millis;
};
