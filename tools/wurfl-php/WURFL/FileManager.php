<?php
/**
 * WURFL API
 *
 * LICENSE
 *
 * This file is released under the GNU General Public License. Refer to the
 * COPYING file distributed with this package.
 *
 * Copyright (c) 2008-2009, WURFL-Pro S.r.l., Rome, Italy
 * 
 * 
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

final class WURFL_FileManager {
	
	// prevent instantiation
	private function __construct() {
	}
	private function __clone() {
	}
	
	/**
	 * Returns a previously serialized data
	 *
	 * @param  string $fileName name of the file to unserialize
	 * @param  string $dir sub-directory where to find the file
	 * @return mixed
	 */
	public static function fetch($fileName, $dir) {
		if (! isset ( $fileName ) || is_null ( $fileName )) {
			return NULL;
		}
		
		$fullName = self::getFileName ( $fileName, $dir );
		if (! file_exists ( $fullName ))
			return NULL;
		$h = fopen ( $fullName, 'r' );
		
		if (! $h)
			return NULL;
			
		// Getting a shared lock
		flock ( $h, LOCK_SH );
		
		$data = file_get_contents ( $fullName );
		
		fclose ( $h );
		
		$data = @unserialize ( $data );
		if (! $data) {
			unlink ( $fullName );
			return NULL;
		}
		
		return $data;
	}
	
	/**
	 * Saves a serialized version of the given data
	 *
	 * @param string $key name of the file 
	 * @param mixed $data
	 * @param string $dir directory where to put the data
	 */
	public static function save($key, $data, $dir) {
		
		$fileName = self::getFileName ( $key, $dir );
		// Opening the file in read/write mode
		$h = fopen ( $fileName, 'w' );
		if (! $h) {
			throw new WURFL_WURFLException ( 'Could not write to File' );
		}
		
		// exclusive lock, will get released when the file is closed
		flock ( $h, LOCK_EX );
		
		// Serializing and Saving
		if (fwrite ( $h, serialize ( $data ) ) === false) {
			throw new WURFL_WURFLException ( 'Could not write to File' );
		}
		fclose ( $h );
	}
	
	/**
	 * Removes the file identified by $key
	 *
	 */
	public static function remove($key) {
	
	}
	
	/**
	 * Utility method for creating a file
	 *
	 * @param String $fileName
	 */
	public static function createFile($fileName) {
		$handle = fopen ( $fileName, "w" );
		if ($handle == NULL) {
			throw new WURFL_WURFLException ( "Can't create file." );
		}
		fclose ( $handle );
	}
	
	/**
	 * Utility method for creating a directory
	 *
	 * @param string $dirName
	 */
	public static function createDir($dirName) {
		if (isset ( $dirName )) {
			if (! is_dir ( $dirName )) {
				mkdir ( $dirName );
			}
		}
	
	}
	
	/**
	 * Utility method for deleting the content of a directory
	 *
	 * @param String $dirName
	 */
	public static function deleteContent($dirName) {
		self::deleteRecursive ( $dirName );
	}
	
	public static function removeDir($dirName) {
		self::deleteRecursive ( $dirName );
	}
	
	private static function deleteRecursive($dirName) {
		if (! file_exists ( $dirName )) {
			return;
		}
		
		// Simple delete for a file
		if (is_file ( $dirName ) || is_link ( $dirName )) {
			return unlink ( $dirName );
		}
		$dir = dir ( $dirName );
		while ( false !== $entry = $dir->read () ) {
			if ($entry != '.' && $entry != '..') {
				self::deleteRecursive ( $dirName . DIRECTORY_SEPARATOR . $entry );
			}
		}
		// Clean up
		$dir->close ();
		rmdir ( $dirName );
	}
	
	/**
	 * Checks if the specified file exists
	 *
	 * @param string $fileName full path to the file 
	 * @return boolean
	 */
	public static function fileExists($fileName) {
		return file_exists ( $fileName );
	}
	
	private static function getFileName($name, $dir) {
		return $dir . '/' . md5 ( $name );
	}

}

?>