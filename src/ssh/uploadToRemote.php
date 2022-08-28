<?php

return function($host, $username, $identity_file, $local_file, $remote_path) {
	$scp_identity_file = escapeshellarg($identity_file);
	$scp_source = escapeshellarg($local_file);
	$scp_destination   = escapeshellarg(
		"$username@$host:$remote_path"
	);

	$scp_flags = "-o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";

	$scp_command = "scp $scp_flags -i $scp_identity_file $scp_source $scp_destination 2>&1";

	return $this->invoke(
		"proc_exec", $scp_command
	);
};
