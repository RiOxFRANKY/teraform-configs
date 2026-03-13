<?php
namespace FileRun\Files;
use FileRun\Perms;
use \FileRun\Utils\DP;

class HandlersManager {

	static $table = 'df_file_handlers';
	static $map = [
		'txt' => 'Plain text files',
		'code' => 'Source code files',
		'office' => 'Microsoft Office documents',
		'ooffice' => 'OpenOffice documents',
		'cad' => 'AutoCAD projects',
		'3d' => '3D model files',
		'mp3' => 'Web-playable audio files',
		'audio' => 'Audio files',
		'wvideo' => 'Web-playable video files',
		'video' => 'Video files',
		'arch' => 'Archive files',
		'img' => 'Image files',
		'img2' => 'Various image files',
		'raw' => 'Raw image files',
		'noext' => 'Files without extension'
	];

	static function getTable() {
		return DP::factory(self::$table);
	}

	static function getForFilename($fileName) {
		return self::getForFileTypeInfo(\FM::fileTypeInfo($fileName));
	}

	static function getForFileTypeInfo($fileTypeInfo) {
		$d = self::getTable();
		$byExt = $d->selectOne('*', ['ext', '=', $d->q($fileTypeInfo['extension'])]);
		if ($byExt) {return $byExt;}
		if ($fileTypeInfo['type']) {
			return $d->selectOne('*', ['type', '=', $d->q($fileTypeInfo['type'])]);
		}
		return false;
	}

	static function nicerFileType($type) {
		return self::$map[$type];
	}

	static function getEditableTypes() {
		$d = self::getTable();
		$filterCriteria = [['handler_edit', 'IS', 'NOT NULL'], ['handler_edit', '!=', '\'-\'']];
		/*
		if (Perms::isIndependentAdmin()) {
			global $auth;
			$filterCriteria[] = ["uid", "=", $d->q($auth->currentUserInfo['id'])];
		}
		*/
		$rs = $d->select(['type', 'ext', 'handler_edit'], $filterCriteria, ['ext' => 'ASC', 'type' => 'ASC']);
		if (!$rs) {return [];}
		$list = [
			'byExt' => [],
			'byType' => []
		];
		foreach($rs as $r) {
			if ($r['type']) {
				$list['byType'][] = $r['type'];
			} else {
				$list['byExt'][] = $r['ext'];
			}
		}
		return $list;
	}
}