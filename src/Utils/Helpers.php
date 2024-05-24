<?php

if (!function_exists('env')) {
    /**
     * Get the value of an environment variable, or return a default value.
     *
     * @param string $key The environment variable key.
     * @param mixed $default The default value to return if the environment variable does not exist.
     * @return mixed The environment variable value or the default value.
     */
    function env(string $key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        return $value;
    }
}