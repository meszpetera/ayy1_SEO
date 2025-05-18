<?php

  if(!loggedin() && !isauth())
  {
    redirect_in_site("?page=$default_page&amp;lang=$lang");
  }
  else
  {
    $editable = ismain();
    
    $template = new Template();

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
      
	  if (isset($_REQUEST['sortby']))
	  {
	    if ($_REQUEST['sortby'] == "make")
		  $sort = "`truck_make`";
		else if ($_REQUEST['sortby'] == "model")
		  $sort = "`truck_model`";
		else if ($_REQUEST['sortby'] == "datedesc")
		  $sort = "`truck_date` ASC";
		else if ($_REQUEST['sortby'] == "saxonid")
		  $sort = "`truck_saxon-id`";		
	  }
	  else
	    $sort = "`truck_saxon-id`";
	  
    $stmt = $mysql->prepare($sql['truckman_viewsold:get_list']);
    $stmt->bind_params($sort);  
    if($stmt->execute())
    {
      $trucks = $stmt->fetch_all();
      $list = '<table>';
      $i = 0;
      foreach ($trucks as $truck)
      {
        if ($i % 30 == 0)
          $list .= '<tr style="background-color:#fff; font-weight:bold">' . 
                    /* '<td style="width:20px">' . $language['truckman_edit:public'] . '</td>' . */
                     '<td style="width:80px">' . $language['truckman_edit:saxon-id'] . '</td>' . 
                     '<td style="width:340px">' . $language['truckman_edit:make_and_model'] . '</td>' . 
                     '<td style="width:300px">' . $language['truckman_edit:actions'] . '</td>' . 
                   '</tr>';
                   
        $bgcolor = (($i % 2 == 1) ? '#77a096' : '#88BBB3');
          
        $msg = "";

        
        $list .= '<tr style="background-color:' . $bgcolor . '">' . 
                  /* '<td style="width:20px">' . $truck['truck_public'] . '</td>' . */
                   '<td style="width:50px">' . $truck['truck_saxon-id'] . '</td>' . 
                   '<td style="width:300px">' . $truck['truck_make'] . ' ' . $truck['truck_model'] . '</td>' . 
                   '<td style="width:230px">' . 
                     '<a href="sys/aktualis_truckdetails_createpdf.php?truckid=' . $truck['truck_id'] . '" style="margin-right:10px">Adatlap megtekintése</a>' . 
                 '</td></tr>'."\r\n";
        $i++;
      }
      $list .= "</table>";
    }
	
	$filter = 0;
    if (isset($_REQUEST['filter']) ) {
        $filter = substr($_REQUEST['filter'], -1);
    }
    
    $variables = array (
                 "LIST" => $list,
                 "ERROR" => $error,
				 "SORT" => isset($_REQUEST['sortby']) ? $_REQUEST['sortby'] : "saxonid",
				 "FILTER" => $filter == 0 ? 0 : $filter,
               );
               
    $template->assign_var_array($variables);
    
    $main_content = $template->compile("sys/lang/hun/truckman_edit.tpl");  //WARNING: Language hardcoded, no other languages needed    
    include("sys/tpl/main.tpl");
  }
?>