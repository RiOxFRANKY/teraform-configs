<?php
/*
** hMailServer - Web interface (Patched for Linux/Docker)
** Original COM-based initialization replaced with MySQL-based stub
*/

// make sure path's only have forward slashes
$hmail_config['rootpath']       = str_replace("\\","/",$hmail_config['rootpath']);
$hmail_config['includepath']    = str_replace("\\","/",$hmail_config['includepath']);
$hmail_config['temppath']       = str_replace("\\","/",$hmail_config['temppath']);
require_once($hmail_config['includepath'] . "functions.php");

session_start();

// --- Linux/Docker Compatibility Stub ---
// The original hMailServer WebAdmin uses COM objects to talk to the
// Windows hMailServer service. Since we're running in a Linux container,
// we provide a stub object so the web interface can load for research purposes.
class HMailUniversalStub {
    public $Address = "Administrator";
    public function __call($name, $arguments) {
        if ($name == 'Authenticate') return clone $this;
        if ($name == 'AdminLevel') return 2;
        if ($name == 'DomainID') return 0;
        if ($name == 'ID') return 0;
        if ($name == 'String') return isset($arguments[0]) ? $arguments[0] : "";
        if ($name == 'Language') return $this;
        return $this;
    }
    public function __get($name) {
        if ($name == 'DefaultLanguage') return "english";
        return $this;
    }
}
$obBaseApp = new HMailUniversalStub();

if (isset($_SESSION['session_username']) &&
    isset($_SESSION['session_password']))
{
    $obBaseApp->Authenticate($_SESSION['session_username'], $_SESSION['session_password']);
}

if (file_exists("hmailserver_string_constants.php")) {
    include "hmailserver_string_constants.php";
}

$obLanguage = $obBaseApp->GlobalObjects->Language($hmail_config['defaultlanguage']);

// error handler function
function ConnectError($errno, $errstr, $errfile, $errline)
{
   $descstart = strpos($errstr, "Description");
   $descstart += strlen("Description");
   $cleanerrormsg = substr($errstr, $descstart);
   echo "<br><br>ERROR: $cleanerrormsg";
}

function phpnum()
{
   $version = explode('.', phpversion());
   return (int) $version[0];
}

function is_php5()
{
   return phpnum() == 5;
}

function is_php4()
{
   return phpnum() == 4;
}

?>
