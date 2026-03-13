<?php
namespace FileRun\WebDAV;
use FileRun\Share;
use FileRun\Paths;

class Server {
	var $uid,
		$root,
		$pathInfo,
		$dstPathInfo,
		$destShareInfo,
		$destinationRelativePath,
		$FRDestRelativePath,
		$destAbsolutePath,
		$location,
		$absolutePath,
		$relativePath,
		$FRrelativePath,
		$shareInfo,
		$debug = false,
		$NextcloudChunkedTempFolderName,
		$NextcloudChunkedTempFolderPath,
		$requestURI,
		$destURI,
		$method
	;

	function __construct($root) {
		global $auth;
		$this->uid = $auth->currentUserInfo['id'];
		$this->root = $root;
	}

	function serve($webDavRoot) {

		$this->method = $_SERVER["REQUEST_METHOD"];

		$this->requestURI = rtrim(\S::fromHTML($_SERVER['REQUEST_URI'], 1), '/');
		$this->relativePath = \FM::stripRoot($this->requestURI, $webDavRoot, false);

		$this->destURI =  rtrim(\S::fromHTML($_SERVER['HTTP_DESTINATION'], 1), '/');
		$this->destinationRelativePath = \FM::stripRoot($this->destURI, $webDavRoot, false);


		/* NextCloud chunked upload protocol V2 */
		if ($GLOBALS['NextcloudMode'] == 'dav') {
			$section = \FM::firstname($this->relativePath);
			$this->relativePath = \FM::stripParents($this->relativePath, 2);
			$this->destinationRelativePath = \FM::stripParents($this->destinationRelativePath, 2);
			if ($section == 'uploads') {
				$transferId = \FM::firstname($this->relativePath);
				$this->NextcloudChunkedTempFolderName = '_temp-filerun.nextcloud-chunked-upload-'.$transferId;
				$this->NextcloudChunkedTempFolderPath = gluePath('/ROOT/HOME', $this->NextcloudChunkedTempFolderName);

				$this->relativePath = gluePath('@Home', $this->NextcloudChunkedTempFolderName, \FM::stripParents($this->relativePath, 1));

				if (in_array($this->method, ['MKCOL', 'PUT', 'MOVE'])) {
					if ($this->method == 'MOVE') {
						$this->beforeMethod();
					}
					$this->callMethod('NextcloudChunkedUpload\\'.$this->method);
					exit();
				}
				if ($this->method != 'PROPFIND') {
					$this->status('501 Method Not Implemented');
					exit();
				}
			}

		}
		/* End Nextcloud */

		if (!class_exists('\\FileRun\\WebDAV\\Methods\\'.$this->method)) {
			$this->status("501 Method Not Implemented");
			exit();
		}

		$this->beforeMethod();

		$this->callMethod($this->method);
	}

	function beforeMethod() {

		$this->pathInfo = self::parsePath($this->relativePath);
		$this->dstPathInfo = self::parsePath($this->destinationRelativePath);
		$this->location = $this->pathInfo['location'];
		if ($this->debug) {
			header("X-FR-Location: ".$this->location);
		}
		if ($this->location == 'invalid') {
			$this->status("404 Not Found");
			echo 'Invalid FileRun WebDAV path!';
			exit();
		}
		if ($this->location == "home") {
			$this->absolutePath = gluePath($this->root, $this->pathInfo['path']);
			$this->FRrelativePath = gluePath("/ROOT/HOME/", $this->pathInfo['path']);
		} else if ($this->location == "browse_share") {
			$this->shareInfo = Share::getInfoById($this->pathInfo['sid']);
			$this->absolutePath = gluePath($this->shareInfo['path'], $this->pathInfo['path']);
			$this->FRrelativePath = gluePath("/ROOT/", $this->pathInfo['uid'], $this->pathInfo['sid'], $this->pathInfo['path']);
		}

		if ($this->dstPathInfo['location'] == "home") {
			$this->destAbsolutePath = gluePath($this->root, $this->dstPathInfo['path']);
			$this->FRDestRelativePath = gluePath("/ROOT/HOME/", $this->dstPathInfo['path']);
		} else if ($this->dstPathInfo['location'] == "browse_share") {
			$this->destShareInfo = Share::getInfoById($this->dstPathInfo['sid']);
			$this->destAbsolutePath = gluePath($this->destShareInfo['path'], $this->dstPathInfo['path']);
			$this->FRDestRelativePath = gluePath("/ROOT/", $this->dstPathInfo['uid'], $this->dstPathInfo['sid'], $this->dstPathInfo['path']);
		}
	}

	function callMethod($method) {
		$class = '\\FileRun\\WebDAV\\Methods\\'.$method;
		//todo: check for class_exists and handle errors
		return $class::run($this);
	}
	
	static function splitPath($path) {
		$parts = explode("/", $path);
		return array_values(array_filter($parts, static function($part){
			return $part != '';
		}));
	}
	
	static function parsePath($path) {
		$parts = self::splitPath($path);
		if ($parts[0] == "@Home") {
			return [
				'location' => "home",
				'path' => implode("/", array_slice($parts, 1))
			];
		}
		if ($parts[0] == "@Shares") {
			$rs['location'] = "users_with_shares";
			if ($parts[1]) {
				$rs['location'] = "list_shares";
				$endBracketPos = strpos($parts[1], ")");
				if ($endBracketPos) {
					$rs['uid'] = substr($parts[1], 1, $endBracketPos-1);
				}
				if ($parts[2]) {
					$rs['location'] = "browse_share";
					$endBracketPos = strpos($parts[2], ")");
					if ($endBracketPos) {
						$rs['sid'] = substr($parts[2], 1, $endBracketPos-1);
					}
					if (count($parts) > 3) {
						$rs['path'] = implode("/", array_slice($parts, 3));
					}
				}
			}
			return $rs;
		}
		if (!$parts[0]) {
			return ['location' => "root"];
		}
		return ['location' => "invalid"];
	}
	
	function debugHeader($msg) {
		if ($this->debug) {
			header("FRDAV-DEBUG: \"".$msg."\"");
		}
	}

	function getETag($fullPath) {
		$stat = @stat($fullPath);
		return md5($stat['mtime'].$stat['ino'].$stat['dev'].$stat['size']);
	}

	function status($status) {
		header("HTTP/1.1 ".$status);
        header("X-WebDAV-Status: ".$status, true);
	}

	static function getFileId($fullPath) {
		$pathId = Paths::getId($fullPath, true);
		return sprintf('%08d', $pathId);
	}

	static function outputFileIdHeader($fullPath) {
		header('OC-FileId: '.self::getFileId($fullPath));
	}
}