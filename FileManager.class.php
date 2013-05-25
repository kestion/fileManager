<?php

	class FileManager
	{
			
		private $root_path;	
		private $elem_path;	
		private $path; 
		
		function __construct($root_path, $elem_path) 
		{
			$this->root_path = $this->getRoot($root_path);
			$this->elem_path = $this->getElem($elem_path);
	        $this->path = $root_path.'/'.$elem_path;
    	}
		
		public function setRoot($root_path)
		{
			$this->root_path = $root_path;
		}
		
		public function getRoot($rooth_path)
		{
			return $this->root_path;
		}
		
		public function setElem($elem_path)
		{
			$this->root_path = $elem_path;
		}
		
		public function getElem($rooth_path)
		{
			return $this->elem_path;
		}
		
		public function whatis_elem()
		{
			
			if (file_exists($this->path) && is_file($this->path) == TRUE )
			{
				if($handle = fopen($this->path, 'r'))
				{
					$filename = (basename($this->path));
					echo $filename.' is a file <br />';
					
					if(($filesize = filesize($this->path)) != false)
					{
						echo $filename.' is '.$filesize.' bytes long <br />';
					}
					
					if(($readable = is_readable($this->path)) != false)
					{
						echo 'readable';
					}
					else 
					{
						echo 'not readable';	
					}
					
					if(($writable = is_writable($this->path)) != false)
					{
						echo ' | writable ';
					}
					else 
					{
						echo ' | not writable';	
					}
	
					if(($executable = is_executable($this->path)) != false)
					{
						echo ' | executable <br />';
					}
					else 
					{
						echo ' | not executable <br />';	
					}
				
					$file_details = array(
						'filename' => $filename,
						'filesize' => $filesize,
						'readable' => $writable,
						'writable' => $writable,
						'executable' => $executable
					);
					
					echo '<br />array $file_details complet <br />';
					print_r($file_details);
					
					fclose($handle);
				}	
			}
			elseif (file_exists($this->path) && is_dir($this->path) == TRUE )
			{
				if ($dh = opendir($this->path)) 
				{
					$dirname = (basename($this->path));
					echo $dirname.' is a directory <br />';
					
					if(($ds = disk_total_space($this->path)) != false)
					{
						echo $dirname.' is '.$ds.' bytes long <br />';
					}
					
					if(($readable = is_readable($this->path)) != false)
					{
						echo 'readable';
					}
					else 
					{
						echo 'not readable';	
					}
					
					if(($writable = is_writable($this->path)) != false)
					{
						echo ' | writable';
					}
					else 
					{
						echo ' | not writable';	
					}
	
					if(($executable = is_executable($this->path)) != false)
					{
						echo ' | executable <br />';
					}
					else 
					{
						echo ' | not executable <br />';	
					}
				
					$dir_details = array(
						'dirname' => $dirname,
						'dirsize' => $ds,
						'readable' => $readable,
						'writable' => $writable,
						'executable' => $executable
					);
					
					
					echo '<br />array $dir_details complet <br />';
					print_r($dir_details);
					
				    closedir($dh);
					return true;
				}
					
			}
			else 
			{
				$error = 'File does not exist';
				return false;
			}
			
		}

		public function inside_elem()
		{
			if (file_exists($this->path) && is_file($this->path) == TRUE )
			{
				if($handle = fopen($this->path, 'r'))
				{
					$filename = (basename($this->path));
					echo $filename.' contains :';
					$contents = fread($handle, filesize($this->path));
					echo '<br />"'.$contents.'"';
					fclose($handle);
				}
			}
			elseif (file_exists($this->path) && is_dir($this->path) == TRUE )
			{
				if ($dh = opendir($this->path)) 
				{
					$dirname = (basename($this->path));
					echo $dirname.' contains :';
					while (($file = readdir($dh)) !== false) 
				    {
				    	$complete_path = $this->path.'/'.$file;
				    	$filesize = filesize($complete_path);
						if ($file != "." && $file != "..")
						{
				    		echo "<br /> filename : ".$file." | filesize : ".$filesize;
						}
				    }
					echo '<br /><br />';
				 closedir($dh);
					return true;
				}
					
			}
			else 
			{
				$error = 'file does not exist';
				return false;
			}
		}
		
		
		public function show_arbo($root_path, $elem_path)
		{
			if(is_dir($elem_path))
			{
				if ($elem_path != 'animals')
				{
					echo '<div style="border: 1px solid black; margin-left:15px;">'.$elem_path.' contains : <br />';
				}
				else 
					echo '<div>'.$elem_path.' contains : <br />';	
				
				$path = $root_path.'/'.$elem_path;	
				$arbo = array();
				if($dir_resource = opendir($path))
				{ 
					while (($elem = readdir($dir_resource)) !== FALSE)
					{
						if ($elem != "." && $elem != "..")
						{
							if(is_file($path."/".$elem))
							{
								$elem_data = array(	'name' => $elem,
													'full_path' => $path."/".$elem,
													'type' => 'file');
								array_push($arbo, $elem_data);
								echo 'file | '.$elem.'<br />';
							}
							elseif(is_dir($path."/".$elem))
							{	echo 'dir | '.$elem.'<br />';
								$dir_content = $this->show_arbo($path, $elem);
								$elem_data = array(	'name' => $elem,
													'full_path' => $path."/".$elem,
													'type' => 'dir',
													'content' => $dir_content);
								
							}
							echo '</div>';
						}
					}
					closedir($dir_resource);
				}
				return true;
			}
			else
			{
				$error = 'Directory does not exist';
				return false;
			}
		}
		
		public function add($path, $add)
		{
			if(is_file($path))
			{
				$file = $path;
				$current = file_get_contents($file);
				$current .= $add;
				file_put_contents($file, $current);
				echo '<br />fonction add : done';
				return true;
			}
			else
			{
				$error = 'File does not exist';
				return false;
			}
		}
		
		public function change($path, $change)
		{
			if(is_file($path))
			{
				$file = $path;
				$current = $change;
				file_put_contents($file, $current);
				echo '<br />fonction change : done';
				return true;
			}
			else
			{
				$error = 'File does not exist';
				return false;
			}
		}
		
		public function create_dir($path, $dir)
		{
			$new_path = $path.'/'.$dir;
			if(is_dir($path))
			{
				if(!file_exists($new_path))
				{
					mkdir($new_path, 0700);
					echo '<br />fonction create_dir : done';
					return true;
				}
				else 
					return false;					
			}
			else
			{
				$error = 'Impossible to create the directory';
				return false;		
			}
		}
		
		function lose_dir($dir)
		{
			if(file_exists($dir))
			{
				foreach(glob($dir . '/*') as $file) 
				{
	        		if(is_dir($file))
	            	{
	            		$this->lose_dir($file);
	            		rmdir($file);
					}
	        		else
	        		    unlink($file);
	    			
	    			return true;
				}
			}
			else
			{
				$error = 'File does not exist';
				return false;
			}	
		}
		
		function suppr_all($dir)
		{
			if(is_dir($dir))
			{
				foreach(glob($dir . '/*') as $file) 
				{
        			if(is_dir($file))
            		{
            			$this->suppr_all($file);
            			rmdir($file);
					}
        			else
        		    	unlink($file);
    			}
				rmdir($dir);
				return true;
			}
			elseif (is_file($dir)) 
			{
				unlink($dir);
				return true;
			}
			else 
			{
				$error = 'Directory or file does not exist';
				return false;
			}
		}
		
		function rename($path, $root_path, $new_name)
		{
			if(file_exists($path))
			{	
				if(is_dir($path))
					$new_path = $root_path.'/'.$new_name;
				else
					$new_path = $root_path.'/'.$new_name.'.txt';
				
				rename($path, $new_path);
				return true;
			}
			else
			{
				$error = 'File does not exist';
				return false;
			}
		}
		
		function move($elem_path, $root_path, $new_path, $file)
		{
			$path = $elem_path;
			
			if(file_exists($path))
			{	
				if(is_file($path))
				{	
					$new_location = $new_path.'/'.$file;
					if (copy($path, $new_location))
					{
						unlink($path);
						return true;
					}
				}
				elseif(is_dir($path))
				{
					$new_location = $new_path.'/'.$file;
					if(file_exists($new_path) && is_dir($new_path))
						if(!file_exists($new_location))
						{	echo $new_location;
							mkdir($new_location, 0777, true);
						}
					return true;
				}
				else 
				{
					$error = 'File is corrupted';
					return false;
				}	
			}
			else 
			{	
				$error = 'File does not exist';
				return false;
			}
		}
		
		function upload($_FILES, $root_path)
		{
			$up_path = $root_path.'/upload';
			
			if(!empty($_FILES['uploaded']))
			{
				if($_FILES['uploaded']['error'] > 0) 
				{
					$error = "The file couldn't be transfered";
					return false;
				}
				else 
				{
					if(!file_exists($up_path))
					{
						mkdir($up_path);
					}
					
					$tmp_name = $_FILES["uploaded"]["tmp_name"];
	       			$name = $_FILES["uploaded"]["name"];
	       			move_uploaded_file($tmp_name, $up_path.'/'.$name);
					return true;
				}
			}
			else
			{
				$error = 'File does not exist';
				return false;	
			}
		}
		
		function download($file, $root_path)
		{
			$file = $root_path.'/'.$file;
			if (file_exists($file)) 
			{
				echo 'downoading';
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename='.basename($file));
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    ob_clean();
			    flush();
			    readfile($file);
			    exit;
				return true;
			}
			else
			{	
				$error = 'File does not exist';
				return false;
			}

		}
		
	}

?>