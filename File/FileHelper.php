<?php

namespace Wame\Utils\File;

use Nette\Utils\Strings;

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
}