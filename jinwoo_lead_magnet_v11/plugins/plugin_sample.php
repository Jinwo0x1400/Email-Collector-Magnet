<?php
function plugin_score_modifier($name, $email, $ip) {
    if (strpos($email, '.edu') !== false) return 15;
    return 0;
}
?>
