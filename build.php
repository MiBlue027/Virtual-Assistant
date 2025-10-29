<?php

putenv('ENV=dev');

exec('npm run build', $output, $return_var);

if ($return_var === 0) {
    echo "Build success!\n";
} else {
    echo "Build failed. Output: " . implode("\n", $output);
}
