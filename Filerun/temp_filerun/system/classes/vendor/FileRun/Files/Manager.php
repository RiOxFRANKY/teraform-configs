<?php
namespace FileRun\Files;

use FileRun\Perms;
use FileRun\Versions;
use FileRun\Share;
use FileRun\Stars;
use FileRun\MetaFiles;
use FileRun\Paths;
use FileRun\Thumbs;
use FileRun\Preview;
use FileRun\WebLinks;
use FileRun\Collections;

class Manager {

	static function getAbsolutePath($relativePath, $uid = false) {//todo: replace with Utils\getPathInfo or prepares
		$pathInfo = Utils::parsePath($relativePath);
		if ($pathInfo['type'] == 'shared' && $pathInfo['share_id']) {
			$shareInfo = Share::getById($pathInfo['share_id']);
			if (!$shareInfo) {return false;}
			$fullPath = $shareInfo['path'];
			if (!$fullPath) {return false;}
			if ($pathInfo['relative_path']) {
				$fullPath = gluePath($fullPath, $pathInfo['relative_path']);
			}
		} else if ($pathInfo['type'] == 'trash') {
			$recordInfo = Trash::getInfo($pathInfo['trash_id']);
			if (!$recordInfo) {return false;}
			if ($uid) {if ($recordInfo['uid'] != $uid) {return false;}}
			$fullPath = Trash::getTrashPath($recordInfo);
		} else if ($pathInfo['type'] == 'home') {
			$homeFolderPath = Perms::getHomeFolder($uid);
			if (!$homeFolderPath) {exit('Error: No home folder path defined');}
			$fullPath = gluePath($homeFolderPath, str_replace("/ROOT/HOME", "", $relativePath));
		} else {
			exit('Error: Invalid relative path');
		}
		return $fullPath;
	}

	static function getRelativePath($fullPath, $uid = false, $shareInfo = false) {
		if ($shareInfo) {
			return gluePath('/ROOT/', $shareInfo['uid'], $shareInfo['id'], \FM::stripRoot($fullPath, $shareInfo['path']));
		}
		$providerHomeFolder = \addTrailingSlash(Perms::getHomeFolder($uid));
		$tmp = substr($fullPath, 0, strlen($providerHomeFolder));
		if ($tmp != $providerHomeFolder) {return false;}
		return substr_replace($fullPath, '/ROOT/HOME/', 0, strlen($providerHomeFolder));
		//todo: move to Files\Utils
		//todo: use \FileRun\Files\Utils::getRelativePath (not for shares)
		//todo: note that this function returns false if the full path is the same as the user home folder path
	}

	/* Upload and create */

	static function onNewFolder($fullPath, $userHomeFolderPath) {
		self::onNewEmptyFolder($fullPath, $userHomeFolderPath);
		Search\Queue::add($fullPath, "indexFolder");
	}

	static function onNewEmptyFolder($fullPath, $userHomeFolderPath = false) {
		Paths::addIfNotFound($fullPath);
		if ($userHomeFolderPath) {
			\FM::touchParentFolders($fullPath, $userHomeFolderPath);
		}
	}

	static function onNewFile($fullPath, $userHomeFolderPath = false, $uid = false) {
			Paths::deletePath($fullPath);
			Paths::insertPath($fullPath);
		Search\Queue::add($fullPath, 'index', $uid);
		Metadata\Utils::automaticExtraction($fullPath, $uid);
		if ($userHomeFolderPath) {
			\FM::touchParentFolders($fullPath, $userHomeFolderPath);
		}
	}

	static function onUpdateFile($fullPath, $userHomeFolderPath, $uid = false) {
			Paths::addIfNotFound($fullPath);
		Search\Queue::add($fullPath, 'index', $uid);
		Metadata\Utils::automaticExtraction($fullPath, $uid);
		\FM::touchParentFolders($fullPath, $userHomeFolderPath);
	}

	/* Rename */

	static function onRenamedFile($fromFullPath, $toFullPath, $userHomeFolderPath) {
		$newFilename = \FM::basename($toFullPath);
			Paths::addIfNotFound($fromFullPath);
		Versions::rename($fromFullPath, $newFilename);
		Share::renameItem($fromFullPath, $toFullPath);
		Search\Queue::add($fromFullPath, "delete");
		Search\Queue::add($toFullPath, "index");
			Paths::move($fromFullPath, $toFullPath);
		Thumbs\Cache::renameCacheItem($fromFullPath, $newFilename);
		Preview\Cache::renameCacheItem($fromFullPath, $newFilename);
		\FM::touchParentFolders($fromFullPath, $userHomeFolderPath);
	}

	static function onRenamedFolder($fromFullPath, $toFullPath, $userHomeFolderPath) {
			Paths::addIfNotFound($fromFullPath);
		Share::rename($fromFullPath, $toFullPath);
		Search\Queue::add($fromFullPath, "deleteFolder");
		Search\Queue::add($toFullPath, "indexFolder");
			Paths::move($fromFullPath, $toFullPath);
		Thumbs\Cache::renameCustomCacheFolder($fromFullPath, \FM::basename($toFullPath));
		Preview\Cache::renameCustomCacheFolder($fromFullPath, \FM::basename($toFullPath));
		@touch($toFullPath);
		\FM::touchParentFolders($fromFullPath, $userHomeFolderPath);
	}

	/* Copy *///todo: test

	static function onNewFileThroughFolderCopy($fullPath, $uid = false) {
			Paths::deletePath($fullPath);
			Paths::insertPath($fullPath);
		Metadata\Utils::automaticExtraction($fullPath, $uid);
	}

	static function onNewFolderThroughFolderCopy($fullPath) {
		Paths::addIfNotFound($fullPath);
	}

	/* Move */

	static function onMovedFile($fromFilePath, $toFilePath, $userHomeFolderPath) {
		$errors = [];
		$rs = Versions::move($fromFilePath, $toFilePath);
		if (!$rs && Versions::$error) {$errors[] = Versions::$error;}
		Share::renameItem($fromFilePath, $toFilePath);
		Search\Queue::add($fromFilePath, "delete");
		Search\Queue::add($toFilePath, "index");
		Paths::move($fromFilePath, $toFilePath);
		Thumbs\Cache::moveCacheItem($fromFilePath, $toFilePath);
		Preview\Cache::moveCacheItem($fromFilePath, $toFilePath);
		\FM::touchParentFolders($fromFilePath, $userHomeFolderPath);
		\FM::touchParentFolders($toFilePath, $userHomeFolderPath);
		return $errors;
	}

	static function onMovedFileThroughFolderMove($fromFilePath, $toFilePath) {
		$errors = [];
		//$rs = Versions::move($fromFilePath, $toFilePath);
		//if (!$rs && Versions::$error) {$errors[] = Versions::$error;}
		//old versions are moved with the parent folder
		Share::renameItem($fromFilePath, $toFilePath);
		Paths::addIfNotFound($fromFilePath);
		Paths::updatePath($fromFilePath, $toFilePath);
		//Thumbs\Cache::moveCacheItem($fromFilePath, $toFilePath);
		//the thumbs are moved with the parent folder
		return $errors;
	}
	static function onMoveFolderThroughFolderMove($fromFilePath, $toFilePath) {
		Share::renameItem($fromFilePath, $toFilePath);
		Paths::addIfNotFound($fromFilePath);
		Paths::updatePath($fromFilePath, $toFilePath);
	}
	static function onMovedFolder($fromFilePath, $toFilePath, $userHomeFolderPath) {
		Share::renameItem($fromFilePath, $toFilePath);
		Search\Queue::add($fromFilePath, "deleteFolder");
		Search\Queue::add($toFilePath, "indexFolder");
		Paths::updatePath($fromFilePath, $toFilePath);
		\FM::touchParentFolders($fromFilePath, $userHomeFolderPath);//todo: what if not moved from same user?
		\FM::touchParentFolders($toFilePath, $userHomeFolderPath);
	}

	/* Delete */

	static function onMoveFileToTrash($fullPath, $trashStoredPath, $userHomeFolderPath) {
		$errors = [];
		$rs = Versions::move($fullPath, $trashStoredPath);
		if (!$rs && Versions::$error) {$errors[] = Versions::$error;}
		Share::clear($fullPath, false);
		WebLinks::deleteByPath($fullPath);
		Collections\Items::removeByPath($fullPath);
		Stars::removeByPath($fullPath);
		Thumbs\Cache::moveCacheItem($fullPath, $trashStoredPath);
		Preview\Cache::moveCacheItem($fullPath, $trashStoredPath);
		Search\Queue::add($fullPath, "delete");
			Paths::move($fullPath, $trashStoredPath);
		\FM::touchParentFolders($fullPath, $userHomeFolderPath);
		return $errors;
	}

	static function onMoveFolderToTrash($fullPath, $trashStoredPath, $userHomeFolderPath) {
		//todo: should we move items individually, to marked as with a regular move?
		Share::clear($fullPath);
		WebLinks::deleteAllByPath($fullPath);
		Collections\Items::removeByFolder($fullPath);
		Stars::removeByPath($fullPath);
			Paths::move($fullPath, $trashStoredPath);
		Thumbs\Cache::clearCustomCacheFolder($fullPath);
		Preview\Cache::clearCustomCacheFolder($fullPath);
		\FM::touchParentFolders($fullPath, $userHomeFolderPath);
	}

	static function onRestoreFileFromTrash($trashStoredPath, $toFullPath) {
		$errors = [];
		$rs = Versions::move($trashStoredPath, $toFullPath);
		if (!$rs && Versions::$error) {$errors[] = Versions::$error;}
		Thumbs\Cache::moveCacheItem($trashStoredPath, $toFullPath);
		Preview\Cache::moveCacheItem($trashStoredPath, $toFullPath);
			Paths::move($trashStoredPath, $toFullPath);
		\FM::touchParentFolders($toFullPath, Perms::getHomeFolder());
		return $errors;
	}

	static function onRestoreFolderFromTrash($trashStoredPath, $toFullPath) {
		Paths::move($trashStoredPath, $toFullPath);
		\FM::touchParentFolders($toFullPath, Perms::getHomeFolder());
	}

	static function onDeleteFile($fullPath, $userHomeFolderPath = false) {
		Versions::clear($fullPath);
		WebLinks::deleteByPath($fullPath);
		Collections\Items::removeByPath($fullPath);
		Share::clear($fullPath, false);
		Search\Queue::add($fullPath, "delete");
		MetaFiles::deleteByPath($fullPath);
		Logging\Utils::clearByPath($fullPath);
			Paths::deletePath($fullPath);
		Thumbs\Cache::clearCacheItem($fullPath);
		Preview\Cache::clearCacheItem($fullPath);
		if ($userHomeFolderPath) {
			\FM::touchParentFolders($fullPath, $userHomeFolderPath);
		}
	}

	static function onDeleteFileFromTrash($fullPath) {
		Versions::clear($fullPath);
		MetaFiles::deleteByPath($fullPath);
		Logging\Utils::clearByPath($fullPath);
			Paths::deletePath($fullPath);
		Thumbs\Cache::clearCacheItem($fullPath);
		Preview\Cache::clearCacheItem($fullPath);
	}

	static function onDeleteFolder($fullPath, $userHomeFolderPath = false) {
		Share::clear($fullPath);
		WebLinks::deleteAllByPath($fullPath);
		Collections\Items::removeByFolder($fullPath);
		Search\Queue::add($fullPath, "deleteFolder");
		MetaFiles::deleteByFolder($fullPath);
		Logging\Utils::clearByPath($fullPath, true);
			Paths::deletePath($fullPath, true);
		Thumbs\Cache::clearCustomCacheFolder($fullPath);
		Preview\Cache::clearCustomCacheFolder($fullPath);
		if ($userHomeFolderPath) {
			\FM::touchParentFolders($fullPath, $userHomeFolderPath);
		}
	}

	static function onDeleteFolderFromTrash($fullPath) {
		MetaFiles::deleteByFolder($fullPath);
		Logging\Utils::clearByPath($fullPath, true);
			Paths::deletePath($fullPath, true);
	}


	/* User management */

	static function onHomeFolderChange($uid, $oldHomeFolderPath) {
		if (!strlen($oldHomeFolderPath)) {return false;}
		Share::clearOneUserShares($uid);//todo: should clean everything related to the deleted shares
		Search\Queue::clearForUser($uid);
		WebLinks::deleteAllByPathAndUserId($oldHomeFolderPath, $uid, true);
		Collections\Collections::removeByUserId($uid);
		Stars::deleteAllByPath($oldHomeFolderPath, $uid, true);
		Notifications::deleteAllByPathAndUserId($oldHomeFolderPath, $uid, true);
	}

	static function onDeleteUser($uid) {
		Share::clearAllSharesRelatedToUser($uid);
		WebLinks::deleteByUserId($uid);
		Collections\Collections::removeByUserId($uid);
		Trash::emptyTrashBin($uid);
		Search\Queue::clearForUser($uid);
	}
}