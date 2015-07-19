<?php
$files = 0;
$created = 0;
$updated = 0;
$url = "https://github.com/mevdschee/MindaPHP/archive/master.zip";
$zipDir = 'MindaPHP-master/';
$archive = __DIR__.'/master.zip';
$path = realpath(__DIR__.'/..');
$prefixes = array(
  '.htaccess',
  'web/.htaccess',
  'web/index.php',
  'web/debugger/',
  'vendor/mindaphp/',
  'tools/'
);

echo "Downloading: $url\n";
//if (!copy($url,$archive)) {
	//die("Error loading URL ($url)\n");
//}
echo "Unzipping: $archive\n";

$zip = new ZipArchive;

if (!$zip->open(__DIR__.'/master.zip') === true) {
	die("Error opening archive ($archive)\n");
}
	 
for($i = 0; $i < $zip->numFiles; $i++) {

	$filename = substr($zip->getNameIndex($i),strlen($zipDir));
	
	$match = false;
	foreach ($prefixes as $prefix) {
		if (substr($filename,0,strlen($prefix))===$prefix) {
			$match = true;
			break;
		}
	}
	if (!$match) continue;
	
	$files++;
	if (file_exists("$path/$filename")) {
		$old = sha1(file_get_contents("$path/$filename"));
	} else {
		$old = false;
		$created++;
	}
	
	$dir = pathinfo($filename,PATHINFO_DIRNAME);
	$base = pathinfo($filename,PATHINFO_BASENAME);
	
	if (!$zip->extractTo("$path/$dir", array($zipDir.$filename))) {
		echo "$filename (ERROR)\n";
	}
	
	$new = sha1(file_get_contents("$path/$filename"));
	
	if ($old!=$new) {
		$version = substr($new, 0, 10);
		if ($old) $updated++;
		echo "$filename ($version)\n";
	}
	
}
	
$zip->close();
echo "$files checked $updated updated $created created\n";