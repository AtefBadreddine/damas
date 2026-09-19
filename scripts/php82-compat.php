<?php
/**
 * Re-apply PHP 8.2 compatibility tweaks after composer install (Laravel 5.1).
 */
$file = __DIR__ . '/../vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php';
if (!is_file($file)) {
    fwrite(STDERR, "HandleExceptions.php not found\n");
    exit(0);
}

$src = file_get_contents($file);
if (strpos($src, 'PHP 8.2: Laravel 5.1 emits deprecations') !== false) {
    echo "HandleExceptions already patched\n";
    exit(0);
}

$old = <<<'PHP'
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }
PHP;

$new = <<<'PHP'
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        // PHP 8.2: Laravel 5.1 emits deprecations that must not become exceptions.
        $ignored = E_DEPRECATED | E_USER_DEPRECATED | E_STRICT | E_NOTICE;
        if ($level & $ignored) {
            return true;
        }

        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }
PHP;

if (strpos($src, $old) === false) {
    fwrite(STDERR, "HandleExceptions.php pattern not found; skip patch\n");
    exit(0);
}

file_put_contents($file, str_replace($old, $new, $src));
echo "Patched HandleExceptions for PHP 8.2\n";

$carbon = __DIR__ . '/../vendor/nesbot/carbon/src/Carbon/Carbon.php';
if (is_file($carbon)) {
    $csrc = file_get_contents($carbon);
    if (strpos($csrc, 'private static function setLastErrors(array $lastErrors)') !== false) {
        $csrc = str_replace(
            "private static function setLastErrors(array \$lastErrors)\n    {\n        static::\$lastErrors = \$lastErrors;\n    }",
            "private static function setLastErrors(\$lastErrors)\n    {\n        if (!is_array(\$lastErrors)) {\n            \$lastErrors = array(\n                'warning_count' => 0,\n                'warnings' => array(),\n                'error_count' => 0,\n                'errors' => array(),\n            );\n        }\n        static::\$lastErrors = \$lastErrors;\n    }",
            $csrc
        );
        file_put_contents($carbon, $csrc);
        echo "Patched Carbon::setLastErrors for PHP 8.2\n";
    }
}
