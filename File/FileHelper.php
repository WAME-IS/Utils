<?php

namespace Wame\Utils\File;

use Nette\Utils\Strings;
use Nette\Utils\FileSystem;
use Nette\Utils\Finder;


class FileHelper
{
	/**
	 * Rename file
	 *
	 * @param string $oldName		old name
	 * @param string $newName		new name
	 * @param string $hash			hash
	 * @param string $extension		extension
	 * @param string $version		version
	 */
	static function rename($oldName, $newName, $hash, $extension, $version = null)
	{
		$newFilename = './uploads/' . ($version?$version.'_':'') . $newName . '_' . $hash . '.' . $extension;
		$oldFilename = './uploads/' . ($version?$version.'_':'') . $oldName . '_' . $hash . '.' . $extension;

		FileSystem::rename($oldFilename, $newFilename);
	}


	/**
	 * Get file info
	 *
	 * @param File $file		file
	 * @return \SplFileInfo		SplFileInfo
	 */
	public static function getFileInfo($file)
	{
		return new \SplFileInfo(Strings::lower($file->getSanitizedName()));
	}


	/**
	 * Get file name
	 *
	 * @param File $file	file
	 * @return string		name
	 */
	public static function getFileName($file)
	{
		return Strings::substring(self::getFileInfo($file)->getBasename("." . self::getFileExtension($file)), 0, 50);
	}


	/**
	 * Get file extension
	 *
	 * @param File $file	file
	 * @return string		extension
	 */
	public static function getFileExtension($file)
	{
		return self::getFileInfo($file)->getExtension();
	}


	/**
	 * Get file hash
	 *
	 * @param File $file	file
	 * @return string		hash
	 */
	public static function getFileHash($file)
	{
		return Strings::substring(md5($file->getContents()), 0, 9);
	}


	/**
	 * Get mime-type
	 *
	 * @param File $file	file
	 * @return string		mime-type
	 */
	public static function getFileMimeType($file)
	{
		return $file->getContentType();
	}
    
    /**
     * Get file size
     * 
     * @param File $file    file
     * @param bool $human   human
     * @param int $decimals decimals
     * @return int|string
     */
    public static function getFileSize($file, $human = false, $decimals = 2)
    {
        $bytes = self::getFileInfo($file)->getSize();
        
        if(!$human) {
            return $bytes;
        } else {
            $sz = 'BKMGTP';
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
        }
    }


    /**
     * Empty dir
     *
     * @param string|array $dirPaths
     * @param boolean $deleteDir delete main folder
     * @throws \Nette\InvalidArgumentException
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
                    if (in_array($file, ['.', '..'])) {
                        continue;
                    }

                    $dir = $dirPath . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR;

                    if (is_dir($dir)) {
                        self::emptyDir($dir, true);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $file);
                    }
                }

                if ($deleteDir) {
                    rmdir($dirPath);
                }
            }
        }
    }


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
     * Find files in folder
     *
     * @param string|array $dir
     * @param string|array $mask file extension suffix e.g.: *.php, *.latte, *.neon ...
     * @param boolean $subFolders find in subfolders
     * @param string|array $excludeFiles
     * @param string|array $excludeFolders
     * @return array
     */
    public static function findFiles($dir, $mask, $subFolders = true, $excludeFiles = null, $excludeFolders = null)
    {
        $files = [];

        $where = Finder::findFiles($mask);

        if ($excludeFiles) {
            $where->exclude($excludeFiles);
        }

        if ($subFolders) {
            $where->from($dir);
        } else {
            $where->in($dir);
        }

        if ($excludeFolders) {
            $where->exclude($excludeFolders);
        }

        foreach ($where as $key => $file) {
            $files[$key] = $file;
        }

        return $files;
    }


    public static function findFolders($dir)
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
     * Move DIR with files
     *
     * @param string $from
     * @param string $to
     * @param boolean $empty
     */
    public static function moveDir($from, $to, $empty = false)
    {
        if ($empty) {
            self::emptyDir($to);
        }

        foreach (scandir($from) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $pathFrom = $from . DIRECTORY_SEPARATOR . $file;
            $pathTo = $to . DIRECTORY_SEPARATOR . $file;

            if (is_dir($pathFrom)) {
                self::createDir($pathTo);
                self::moveDir($pathFrom, $pathTo, $empty);
            } elseif (is_file($pathFrom)) {
                copy($pathFrom, $pathTo);
            }
        }
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