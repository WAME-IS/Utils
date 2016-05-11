<?php

namespace Wame\Utils;

use Nette\Utils\FileSystem;

class Files
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
}