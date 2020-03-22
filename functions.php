<?php
    // function to create dynamic treeview menus
    function createTreeView($parent, $menu) {
    $html = "";
    if (isset($menu['parents'][$parent])) {
        $html .= "
        <ol class='tree'>";
        foreach ($menu['parents'][$parent] as $itemId) {
            if(!isset($menu['parents'][$itemId])) {
                $html .= "<li><label for='subfolder2'><a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a></label> <input type='checkbox' name='subfolder2'/></li>";
            }
            if(isset($menu['parents'][$itemId])) {
                $html .= "
                <li><label for='subfolder2'><a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a></label> <input type='checkbox' name='subfolder2'/>";
                $html .= createTreeView($itemId, $menu);
                $html .= "</li>";
            }
        }
        $html .= "</ol>";
    }
    return $html;
    }

	// Adds pretty filesizes
	function pretty_filesize($file) {
        @$size=filesize($file);
        if($size==0){$size="Directory";} 
		elseif(($size<1024)&&($size>0)){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
    }
    
    function search_path($dirPath) {

    if (file_exists($dirPath)) {
    
	 // Opens directory
	 $myDirectory=opendir($dirPath);

	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;
	   
	}

	// Closes directory
	closedir($myDirectory);

	// Counts elements in array
	$indexCount=count($dirArray);

	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {

	// Decides if hidden files should be displayed, based on query above.
	   

	// Resets Variables
	    $class="file";

	// Gets File Names
		$name=$dirArray[$index];
		$namehref=$dirArray[$index];

	// Gets Date Modified
		@$modtime=date("M j Y g:i A", filemtime($dirPath.$dirArray[$index]));
	
	// Gets file extension
	$extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);

	// Separates directories, and performs operations on those directories
		if($extn=="")
		{
			
		}

	
			// Gets and cleans up file size
				$size=pretty_filesize($dirPath.$dirArray[$index]);
				
		
		// Output
		if($extn==""){ 
				
				$size="&lt;Directory&gt;";
				$class="dir";

		
			// Cleans up . and .. directories
				if($name=="."){$name=". (Current Directory)";  }
				if($name==".."){$name=".. (Parent Directory)"; }

				$size="Directory";
				$result_array[$index]=("
				<tr class='$class'>
					<td><a href='index.php?directory=".$namehref."&parent_directory=".$dirPath."' class='name'>$name</a></td>
					<td><a href='index.php?directory=".$namehref."&parent_directory=".$dirPath."'>$size</a></td>
					<td><a href='index.php?directory=".$namehref."&parent_directory=".$dirPath."'>$modtime</a></td>
				</tr>");

			}else{

				$result_array[$index]=("
				<tr class='$class'>
					<td ><a id=".$extn."  class='name'>$name</a></td>
					<td><a >$size</a></td>
					<td><a >$modtime</a></td>
				</tr>");

			};
			}
			return $result_array;
		
		} 
		else 
		{ 
			return"not_exist"; 
		} 

    }
 
?>

