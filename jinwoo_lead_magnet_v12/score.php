<?php
function score_lead($name, $email, $ip) {
    $score = 50;
    if (strpos($email, 'vip') !== false || strpos($email, '@company.com') !== false) $score += 30;
    if (strpos($email, 'test') !== false || strpos($email, 'temp') !== false) $score -= 50;

    // IP-country-based bonus
    $ipInfo = @json_decode(file_get_contents("http://ip-api.com/json/$ip"));
    if ($ipInfo && $ipInfo->status == "success") {
        if (in_array($ipInfo->country, ['Singapore', 'Malaysia', 'Thailand'])) $score += 20;
    }

    // Plugins (optional)
    foreach (glob("plugins/*.php") as $plugin) {
        include $plugin;
        if (function_exists("plugin_score_modifier")) {
            $score += plugin_score_modifier($name, $email, $ip);
        }
    }

    return max(0, min(100, $score));
}
?>
