<?php

return function($file, $data) {
	$data_length = strlen($data);
	$bytes_written = file_put_contents($file, $data);

	if ($data_length !== $bytes_written) {
		$this->raiseError(
			"Impartial write operation (expected=$data_length,actual=$bytes_written)."
		);
	}
};
