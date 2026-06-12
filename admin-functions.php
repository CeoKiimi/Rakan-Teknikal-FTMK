<?php
function admin_short_name($name) {
    $name = trim((string)$name);
    if ($name === '') {
        return 'Admin';
    }

    $parts = preg_split('/\s+/', $name);
    return $parts[0] ?? $name;
}

function admin_short_text($value, $length = 34) {
    $value = trim((string)$value);

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($value) <= $length) {
            return $value;
        }
        return mb_substr($value, 0, $length - 3) . '...';
    }

    if (strlen($value) <= $length) {
        return $value;
    }

    return substr($value, 0, $length - 3) . '...';
}

function admin_allowance_amount($allowance) {
    $allowance = (string)$allowance;

    if (preg_match('/(\d+(?:\.\d+)?)/', $allowance, $matches)) {
        return (float)$matches[1];
    }

    return null;
}

function admin_status_class($status) {
    return strtolower((string)$status);
}
?>
