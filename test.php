<?php 
	
	include 'FileManager.class.php';

	$root_path = 'C:/wamp/www/PHP3/arbo';
	$elem_path = 'test';
	$file = $elem_path;
	$path = $root_path.'/'.$elem_path;
	
	$test = new FileManager($root_path,$elem_path);
	
	echo 'appel de whatis_elem<br /><br />';
	$test->whatis_elem();
	
	echo '<br /><br />appel de inside_elem<br /><br />';
	$test->inside_elem();
	
	echo '<br /><br />appel de show_arbo<br />';
	$test->show_arbo($root_path,$elem_path);
	
	echo '<br />appel de lose_dir<br />';
	//$test->lose_dir($path);
	
	$add = ' Pedo Bear ';
	echo '<br /><br />apel de add';
	$test->add($path, $add);
	
	$change = 'Do I really need to code?';
	echo '<br /><br />apel de change';
	$test->change($path, $change);
	
	$dir = 'eve';
	echo '<br />apel de create_dir<br />';
	$test->create_dir($path, $dir);
	
	echo '<br />apel de suppr_all<br />';
	//$test->suppr_all($path);
	
	$new_name = 'unik';
	echo'<br />appel de rename<br />';
	//$test->rename($path, $root_path, $new_name);
	
	$new_path = 'arbo/others';
	echo '<br />appel de move<br />';
	//$test->move($path, $root_path, $new_path, $file);
	
	echo '<br />appel de upload<br />';
	echo '<form method="post" action="test.php" enctype="multipart/form-data">';
	echo '<br /><input type="file" name="uploaded" /><br />';
	echo '<br /><input type="submit" /><br />';
	echo '</form>';
	$test->upload($_FILES, $root_path);
	
	echo '<br />appel de download<br />';
	echo '<form method="post" action="test.php"> 
			<input type="hidden" name="is_on" value="done" />
			<input type="submit" value="download test.txt" />
		  </form>';
		  
	$file = 'test.txt';
	
	if(isset($_POST['is_on']) && ($_POST['is_on'] == 'done'))
		$test->download($file, $root_path);


	
?>