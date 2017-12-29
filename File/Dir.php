<?php

namespace Wame\Utils;


class Dir
{
    /**
     * Create dir recursive
     *
     * @param string $dir
     * @param int $chmod permission
     * @return string
     */
    public static function createDir($dir, $chmod = 0777)
    {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $dir);

        if (!file_exists($path)) {
            mkdir($path, $chmod, true);
        }

        return $path;
    }


    /**
     * Empty directory
     *
     * @param string|array $dirPaths
     * @param bool $deleteDir delete main folder
     */
    public static function emptyDir($dirPaths, $deleteDir = false)
    {
        if (!is_array($dirPaths)) {
            $dirPaths = [$dirPaths];
        }

        foreach ($dirPaths as $dirPath) {
            if (is_dir($dirPath)) {
                if (substr($dirPath, strlen($dirPath) - 1, 1) == '/') {
                    $dirPath = substr($dirPath, 0, -1);
                }

                foreach (scandir($dirPath) as $file) {
                    if (in_array($file, ['.', '..'])) continue;

                    $dir = $dirPath . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR;

                    if (is_dir($dir)) {
                        self::emptyDir($dir, true);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $file);
                    }
                }

                if ($deleteDir) rmdir($dirPath);
            }
        }
    }


    /**
     * Copy directory with files
     *
     * @param string $from
     * @param string $to
     * @param bool $empty
     */
    public static function copyDir($from, $to, $empty = false)
    {
        if ($empty) self::emptyDir($to);

        foreach (scandir($from) as $file) {
            if (in_array($file, ['.', '..'])) continue;

            $pathFrom = $from . DIRECTORY_SEPARATOR . $file;
            $pathTo = $to . DIRECTORY_SEPARATOR . $file;

            if (is_dir($pathFrom)) {
                self::createDir($pathTo);
                self::copyDir($pathFrom, $pathTo, $empty);
            } elseif (is_file($pathFrom)) {
                copy($pathFrom, $pathTo);
            }
        }
    }



    /**
     * Get dir list
     *
     * @param string $dir
     * @return array
     */
    public static function getList($dir)
    {
        $return = [];

        foreach (new \DirectoryIterator($dir) as $file) {
            if ($file->isDot()) continue;

            if ($file->isDir()) {
                $return[$file->getFilename()] = $file;
            }
        }

        return $return;
    }


    /**
     * Get dirname parents
     * http://php.net/manual/en/function.dirname.php#118477
     *
     * PHP 7 use dirname($path, $level)
     * PHP 5.6 dirname(dirname($path))
     *
     * @param string $path
     * @param int $levels
     * @return string
     */
    public static function dirnameWithLevels($path, $levels = 1)
    {
        while ($levels--) {
            $path = dirname($path);
        }

        return $path;
    }

}
