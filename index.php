<?php 
include_once("functions.php");
?>
<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <title>Directory Contents</title>
   <link rel="stylesheet" href="./style.css">

</head>

<body>

<form method="post" class="search" action="./index.php">
  <input type="text" placeholder="Enter directory path..." name="path">
  <input type="submit" name="submit"  value="Search Path">
</form>

<?php 

		$directory_result="";
		
    	if(isset($_POST['submit'])){
			$directory_result=search_path($_POST["path"]);
		} 
		if (isset($_GET['directory']) && isset($_GET['parent_directory'])) {
			if($_GET['directory']=='..'  ){
				$directory_result=search_path(dirname($_GET['parent_directory']).'/');
			}elseif ($_GET['directory']=='.'){
				$directory_result=search_path($_GET['parent_directory']);
			}elseif($_GET['parent_directory']=='./'){
				$directory_result=search_path('./'.$_GET['directory'].'/');
			}elseif($_GET['parent_directory']=='..'){
				$directory_result=search_path('../'.$_GET['directory'].'/');
			}
			
			else{
				$directory_result=search_path($_GET['parent_directory'].$_GET['directory'].'/');
		  }
		}

	if($directory_result==""){
		return;

	}elseif ($directory_result=="not_exist"){
		echo ("<div id='container'>
				   <h1>Path doesn't exist</h1>
				</div");
	}else{			
		echo  (
		"<div id='container'>
		 <h1>Directory Contents</h1>
		 <table>
			<thead>
			<tr>
				<th>Filename</th>
				<th>Size</th>
				<th>Date Modified</th>
		    </tr>
		   </thead>");
		   foreach($directory_result as $value) {
			echo  (" <tbody>
		   	$value
		   </tbody>");
		   };
		   echo  (" </table></div>"
	  );
  };

?>
</body>
</html>
