<?php
	/**
	 * PHP script that finds and reads target file/s throughout the directory, and subdirectories.
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

	ini_set('max_execution_time', 3000);

	//Path to get all subdirectories and contents
	$path = getcwd();				 				
	//Target file to find (!full file name including extension, can be array of filenames or a string literal)
	$target = "error_log";							

	//Run script
	//@param string $path Path of the directory to be scanned.
	//@param string/array $target filename/filename array of target file/s.
	main($path, $target);						

	function scan_file($fpath){
		$FILE = fopen($fpath, "r");
		echo "FILE START " . $fpath . "\n";
		
		while (!feof($FILE)) {
			$line = fgets($FILE);
			echo $line;
		}
		
		echo "END OF FILE " . $fpath . "\n\n";
		fclose($FILE);
		//recreate_file($fpath); /*RECREATES FILE AFTER READING*/
		//delete_file($fpath); 	 /*DELETES FILE AFTER READING*/
	}

	function recreate_file($fpath){
		$handle = fopen($fpath, "w");
		fclose($handle);
	}

	function delete_file($fpath){
		unset($fpath);
	}

	function get_dir_contents($dir, $results = array()){
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

	/**
	*@param string $path Path of the directory to be scanned.
	*@param string/array $target filename/filename array of target file/s.
	*/
	function main(){
		if(func_num_args() != 0){
			$path = func_get_arg(0);
			$target = func_get_arg(1);
			foreach (get_dir_contents($path) as $file) {
				if(is_array($target)){
					if(in_array(basename($file), $target))
						scan_file($file);
					else
						continue;
				}else{
					if(basename($file) == $target)
						scan_file($file);
					else
						continue;
				}
			}
		}else{
			echo "Invalid argument/s";
		}
	}
 ?>
