<?php

// Generates a PHPUnit TestCase for the class at the given path
// with the given namespace prefix.
//
// Uses composer.json and reflection to generate the test
//
// @author Daniel Leech <daniel@dantleech.com>sc

function blowup($error)
{
    echo $error . PHP_EOL;
    exit(1);
}

$cwd = getcwd();

if (!isset($argv[1])) {
    blowup('You must provide a filename');
}
$file = dirname($argv[1]);
$composerFile = $cwd . '/composer.json';
$autoloadFile = $cwd . '/vendor/autoload.php';

if (!file_exists($composerFile)) {
    blowup(sprintf('Could not find composer file in current directory (%s)', $cwd));
}

if (!file_exists($autoloadFile)) {
    blowup('Could not find autoload.php in vendor directory. Have you installed the dependencies for the project?');
}

if (!file_exists($file)) {
    blowup(sprintf('Could not find file "%s"', $file));
}

require_once($autoloadFile);

$composer = json_decode(file_get_contents($composerFile), true);

if (!$composer) {
    blowup('Could not decode composer.json');
}

function get_autoload_meta($file, $composer)
{
    $autoloadMeta = null;
    $autoloadLen = 0;
    foreach (array('autoload', 'autoload-dev') as $autoloadType) {
        if (false === isset($composer[$autoloadType])) {
            continue;
        }
        foreach ($composer[$autoloadType] as $autoloadStd => $pathPrefix) {
            foreach ($pathPrefix as $prefix => $path) {
                if (0 === strpos($file, rtrim($path, '/')) && strlen($path) > $autoloadLen) {
                    $autoloadMeta = array(
                        'type' => $autoloadStd,
                        'path' => $path,
                        'prefix' => $prefix
                    );

                    $autoloadLen = strlen($path);
                }
            }
        }
    }

    if (null === $autoloadMeta) {
        blowup(sprintf('Could not find autload entry for "%s"', $file));
    }

    return $autoloadMeta;
}

function get_psr4_namespace($file, $autoload)
{
    $subPath = substr($file, strlen($autoload['path']));
    $subPath = $autoload['prefix'] . $subPath;
    $namespace = str_replace('/', '\\', $subPath);
    $namespace = str_replace('.php', '', $namespace);
    return $namespace;
}

function get_psr0_namespace($file, $autoload)
{
    $subPath = substr($file, strlen($autoload['path']));
    $namespace = str_replace('/', '\\', $subPath);
    $namespace = str_replace('.php', '', $namespace);

    return $namespace;
}

$autoload = get_autoload_meta($file, $composer);

switch ($autoload['type']) {
    case 'psr-4':
        $namespace = get_psr4_namespace($file, $autoload);
        break;
    case 'psr-0':
        $namespace = get_psr0_namespace($file, $autoload);
        break;
    default:
        blowup(sprintf('Unknown autoload type "%s"', $autoload['type']));
}

echo rtrim($namespace, '\\');
exit(0);
