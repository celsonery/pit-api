<?php
if (!function_exists('initials')) {
    function initials(string $name): ?string
    {
        if (!empty(trim($name))) {
            $arr = explode(' ', trim($name));

            return mb_substr($arr[0], 0, 1) . mb_substr($arr[1], 0, 1);
        }
        return null;
    }
}
