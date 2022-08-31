<?php

return function($host, $username, $identity_file, $command) {
	$ssh_login = escapeshellarg("$username@$host");
	$ssh_identity_file = escapeshellarg($identity_file);
	$ssh_command = escapeshellarg($command);

	$ssh_flags = "-o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";

	$ssh_command = "ssh $ssh_flags -i $ssh_identity_file $ssh_login -- $ssh_command 2>&1";

	return $this->proc_exec($ssh_command);
};
