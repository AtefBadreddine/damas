<?php
/**
 * Re-apply PHP 8.2 compatibility tweaks after composer install (Laravel 5.1).
 */
function php82_normalize($src)
{
    return str_replace("\r\n", "\n", $src);
}

$file = __DIR__ . '/../vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php';
if (!is_file($file)) {
    fwrite(STDERR, "HandleExceptions.php not found\n");
    exit(0);
}

$src = php82_normalize(file_get_contents($file));
$changed = false;

if (strpos($src, 'error_reporting(-1);') !== false) {
    $src = str_replace(
        'error_reporting(-1);',
        'error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_STRICT & ~E_NOTICE);',
        $src
    );
    $changed = true;
    echo "Patched HandleExceptions error_reporting for PHP 8.2\n";
}

if (strpos($src, 'PHP 8.2: Laravel 5.1 emits deprecations') !== false) {
    echo "HandleExceptions already patched\n";
} else {
    $patched = preg_replace(
        '/public function handleError\(\$level, \$message, \$file = \'\'\, \$line = 0, \$context = \[\]\)\s*\{\s*if \(error_reporting\(\) & \$level\) \{\s*throw new ErrorException\(\$message, 0, \$level, \$file, \$line\);\s*\}\s*\}/s',
        "public function handleError(\$level, \$message, \$file = '', \$line = 0, \$context = [])\n    {\n        // PHP 8.2: Laravel 5.1 emits deprecations that must not become exceptions.\n        \$ignored = E_DEPRECATED | E_USER_DEPRECATED | E_STRICT | E_NOTICE;\n        if (\$level & \$ignored) {\n            return true;\n        }\n\n        if (error_reporting() & \$level) {\n            throw new ErrorException(\$message, 0, \$level, \$file, \$line);\n        }\n    }",
        $src,
        1,
        $count
    );

    if (!$count) {
        fwrite(STDERR, "HandleExceptions.php pattern not found; skip patch\n");
    } else {
        $src = $patched;
        $changed = true;
        echo "Patched HandleExceptions handleError for PHP 8.2\n";
    }
}

if ($changed) {
    file_put_contents($file, $src);
}

$carbon = __DIR__ . '/../vendor/nesbot/carbon/src/Carbon/Carbon.php';
if (is_file($carbon)) {
    $csrc = php82_normalize(file_get_contents($carbon));
    if (strpos($csrc, 'private static function setLastErrors(array $lastErrors)') !== false) {
        $csrc = preg_replace(
            '/private static function setLastErrors\(array \$lastErrors\)\s*\{\s*static::\$lastErrors = \$lastErrors;\s*\}/s',
            "private static function setLastErrors(\$lastErrors)\n    {\n        if (!is_array(\$lastErrors)) {\n            \$lastErrors = array(\n                'warning_count' => 0,\n                'warnings' => array(),\n                'error_count' => 0,\n                'errors' => array(),\n            );\n        }\n        static::\$lastErrors = \$lastErrors;\n    }",
            $csrc,
            1,
            $ccount
        );
        if ($ccount) {
            file_put_contents($carbon, $csrc);
            echo "Patched Carbon::setLastErrors for PHP 8.2\n";
        } else {
            fwrite(STDERR, "Carbon setLastErrors pattern not found; skip patch\n");
        }
    }
}
