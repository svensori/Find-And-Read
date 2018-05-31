<?php
	/**
	 * Reads specific files throughout the entire directory, and subdirectories.
	 *
	 * PHP version 5
	 *
	 * LICENSE: This source file is subject to version 3.01 of the PHP license
	 * that is available through the world-wide-web at the following URI:
	 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
	 * the PHP License and are unable to obtain it through the web, please
	 * send a note to license@php.net so we can mail you a copy immediately.
	 *
	 * find-and-read.php
	 *
	 * @author     Steven Soriano
	 * @copyright  2018 Steven Soriano
	 */


	/*********INITIALIZATION*********/
	ini_set('max_execution_time', 3000);
	$path = getcwd();				 //Path to get all subdirectories and contents
	$target = "error_log";			 //Target file to find (!full file name including extension)
	main($path, $target);			 //Main function
	/********************************/

	function scan_file($fpath){
		$FILE = fopen($fpath, "r");
		if($FILE){
			echo $fpath . "\n";
			while(!feof($FILE)){
				$line = fgets($FILE);
				echo $line;
			}
			echo "END OF FILE " . $fpath . "\n\n";
			fclose($FILE);
			//recreate_file($fpath); /*RECREATES FILE AFTER READING*/
			//delete_file($fpath); 	 /*DELETES FILE AFTER READING*/
		}
	}

	function recreate_file($fpath){
		$handle = fopen($fpath, "w");
		fclose($handle);
	}

	function delete_file($fpath){
		unset($fpath);
	}

	function get_dir_contents($dir, &$results = array()){
	    $files = scandir($dir);

	    foreach($files as $key => $value){
	        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
	        if(!is_dir($path)) {
	            $results[] = $path;
	        } else if($value != "." && $value != "..") {
	            get_dir_contents($path, $results);
	            $results[] = $path;
	        }
	    }
	    return $results;
	}

	function main($path, $target){
		foreach (get_dir_contents($path) as $file) {
			if(basename($file) == $target){
				scan_file($file);
			}else{
				continue;
			}
		}
	}
 ?>
