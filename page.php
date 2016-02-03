<?php 
	include_once 'config.php';
	//Display 10 rows first
	$per_page = 10;
	$adjacents=10;
	//Count id how many rows in this table
	$pages_query = mysql_query("SELECT count(*) AS id from markers");
	if($pages_query){
			//echo "Get Total number of pages to be shown from total result";
			$pages=ceil(mysql_result($pages_query, 0)/$per_page);
			//get current page from URL, f not present set it to 1
			$page= (isset($_GET['page']))? (int)$_GET['page'] : 1;

			//calculate actual page with respect to Mysql
			$start = ($page - 1) * $per_page;

			//execute a mysql query to retrieve all result from current page by using LIMIT keyword
			//if query fails stop further execution and show mysql error
			$query = mysql_query("SELECT *from markers LIMIT $start, $per_page");
			$pagination = "Pagination";
			//if current page is first show first only else reduce 1 by current page
			$Prev_page = ($page==1) ? 1 : ($page-1);
			//if current page is last show only else add 1 to current page
			$Next_Page = ($page>=$pages)?$page:$page + 1;

			//if we are not on first page show first link

			if($page!=1) $pagination .= "<a href='?page=1'> First</a>";
			//if we are not on first page show previous link
			if($page!=1) $pagination.= '<a href="?page="'. $Prev_page. ">Previous</a>";
			//we are going to display 5 links on pagination bar
			$numberoflinks =5;

			//find the number of links to show on right of current page
			$upage = ceil(($page)/$numberoflinks)*$numberoflinks;

			//find the number of linsk to show on left og current page
			$lpage = floor(($page)/$numberoflinks)*$numberoflinks;

			//if number of links on left of current page are zero we start from 2
			$lpage=($lpage==0)?1:$lpage;
			//find the number of links to show on right og current page and make usre it must be less
			$upage=($lpage==$upage)?$upage+$numberoflinks:$upage;
			if($upage>$pages)$upage=($pages-1);
			//start builfing links from left to right of current page 
			for ($i=$lpage; $i <=$upage ; $i++) { 
				//if current building link is current page we don't show link as text else we show
				$pagination.=($i == $page) ? '<strong>'.$i.'</strong>' : '<a href="?page='.$i. '">' . $i . '</a>';
			}
			//we show next link and last link  if user doesn't on last page
			if ($page!=$pages) $pagination .= '<a href="?page=' . $Next_Page . '">Next</a>';

			if ($page != $pages) $pagination .= '<a href="?page=' . $pages . '">Last</a>';
		}
		else{
			echo "Not Yet";
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device=width, initial-scale=1">
	<title>Format: Pagination Data From Mysql</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container-fluid">
		<h3>Display Name and Location of Various Fancy Places</h3>
		<div class="table-responsive">
			<table class="table table-hover">
				<tr>
					<th>Name</th>
					<th>Address</th>
					<th>Latitute</th>
					<th>Longitude</th>
					<th>Type</th>
				</tr>
				
					<?php 
					while($row = mysql_fetch_array($query)){
						//$f1 = $row['id'];
						$f1 = $row['name'];
						$f2 = $row['address'];
						$f3 = $row['lat'];
						$f4 = $row['lng'];
						$f5 = $row['type'];
						?>
						<tr>
							<td><?php echo $f1;?></td>
							<td><?php echo $f2;?></td>
							<td><?php echo $f3;?></td>
							<td><?php echo $f4;?></td>
							<td><?php echo $f5;?></td>
						</tr><?php
						}
					?>
				</tr>
			</table>
		</div>
		<nav>
			<ul class="pager">
				<li><a href="#"><?php echo $pagination;?><a></li>
				<!--<li><a href="#">Next</a></li>-->
			</ul>
		</nav>
	</div>
	<script src="jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>