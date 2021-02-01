<?php 
	$connect = mysql_connect('localhost','root', 'your-password');
	if ($connect) {
		//echo "Done";
		$dbselect=mysql_select_db('population');
		if ($dbselect) {
			//echo "Database Selected";
		}else{
			//echo "Database Locked";
			}
		}else{
			//echo "Your Doomed";
		}

	?>
