<?php
class Cache {
    public static function set($key, $value) {
        global $cache_path;
        $path = $cache_path . '/' . $key;
        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, sprintf("<?php\nreturn %s;", var_export($value, true)));
    }

    public static function get($key)
    {
        global $cache_path;

        $path = $cache_path . '/' . $key;

        if (is_file($path)) {
            return include $path;
        }

        return null;
    }

    public static function has($key)
    {
        global $cache_path;

        $path = $cache_path . '/' . $key;

        return is_file($path);
    }

    public static function reset($key)
    {
        global $cache_path;

        $path = $cache_path . '/' . $key;

        if (is_file($path)) {
            unlink($path);
        }
    }
}