<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'View Offers';

 //only accessible to sales
  
global $db;
get_header();

$db->runQuery(" select id as 'Offer ID', description as Description, value as Value,lead_type as 'Lead Type',
              criteria as Criteria,start_date as 'Start Date', end_date as 'End Date', employee_id as 'Employee ID'
             from discounts order by end_date");
 $columns = $db->result->field_count;

        echo "
                     <html>    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
                        <script type='text/javascript'>
                            function changeRowColor (Row,State)
                            {
                                if(State)
                                    {
                                        Row.style.backgroundColor = '#E0E0E0';
                                        Row.style.color = 'Black';
                                    }
                                else
                                    {
                                        Row.style.backgroundColor = '#f6f6f6';
                                        Row.style.color = 'Black';
                                    }
                            }

                            function pageRedirect(indexOfRow)
                            {
                                var offer = document.getElementById('offersTable').rows[indexOfRow].cells[0].innerHTML;
                                document.location.href = 'viewOffers.php?offerID='+offer;
                            }
                        </script>
                        </head>
            ";

         if(!isset($_POST['submit']))
           {
              echo"<form action='$PHP_SELF' method='POST'>
                        <table name ='offersTable' class='profile_sect' align='center'>
             ";

       $i=0;
       echo"<tr align = 'center'>";
       while($columns>0)
       {
           //echo $columns;
           $fieldHeader = $db->result->fetch_field_direct($i);
           $fieldName = $fieldHeader->name;
           //echo $fieldName;
           //$fieldOrgName = $fieldHeader->orgname;
           //echo $fieldOrgName;
           echo
           "<th class='field'>$fieldName</th>";
            $columns--;
            $i++;
       }

       echo"</tr align = 'center'>";
       $columns = $db->result->field_count;
       $counter=0;
       
       $todayD = date("Y-m-d");
       $today = strtotime($todayD);


       echo"<h1>Ongoing Offers </h1>";
       while ($rows = $db->result->fetch_assoc())
       {
            $eDAte = $rows['End Date'];
            //echo "End Date = ",$eDAte;
            $eDate = strtotime($eDAte);
           if($eDate > $today)
           {
                    $i=0;$counter+=1;
                    echo"<tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'
                         onclick='pageRedirect($counter);'>";
                    while($i<$columns)
                    {
                            $fieldHeader = $db->result->fetch_field_direct($i);
                            $fieldName = $fieldHeader->name;
                            echo"
                                <td>$rows[$fieldName]</td>
                                ";
                            $i++;
                    }
                    echo"</tr>";
                }
       }
       $i=0;
       echo"</table>";
       echo"<input type='submit' value='Past Offers' name='submit'>";
          }
       if(isset($_POST['submit']))
           {
       echo"<table name ='pastOffersTable' class='profile_sect' align='center'>";
       echo"<tr align = 'center'>";
       while($columns>0)
       {
           //echo $columns;
           $fieldHeader = $db->result->fetch_field_direct($i);
           $fieldName = $fieldHeader->name;
           //echo $fieldName;
           //$fieldOrgName = $fieldHeader->orgname;
           //echo $fieldOrgName;
           echo
           "<th class='field'>$fieldName</th>";
            $columns--;
            $i++;
       }
       
       echo"</tr align = 'center'>";
       $columns = $db->result->field_count;
       $counter=0;
       
       $todayD = date("Y-m-d");
       $today = strtotime($todayD);


       echo"<h1>Past Offers </h1>";
       while ($rows = $db->result->fetch_assoc())
       {
            $eDAte = $rows['End Date'];
            //echo "End Date = ",$eDAte;
            $eDate = strtotime($eDAte);
           if($eDate < $today)
           {
                    $i=0;$counter+=1;
                    echo"<tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'
                         onclick='pageRedirect($counter);'>";
                    while($i<$columns)
                    {
                            $fieldHeader = $db->result->fetch_field_direct($i);
                            $fieldName = $fieldHeader->name;
                            echo"
                                <td>$rows[$fieldName]</td>
                                ";
                            $i++;
                    }
                    echo"</tr>";
                }

            
         
       }
       
       echo"</table>";
       echo"<form><input type='submit' value='Back' onClick='history.go(-1);return true;'> </form>";
  
           }
echo"</body></html>";
get_footer();
?>
<!--<div id='profileBox'>-->