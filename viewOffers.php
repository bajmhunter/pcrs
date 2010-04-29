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

                            function pageRedirect(table,indexOfRow,accessLevel)
                            {
                                var offer = document.getElementById(table).rows[indexOfRow].cells[0].innerHTML;
                                switch(accessLevel)
                                {
                                    case 1: 
                                            if(table=='offersTable' || table=='pastOffersTable')
                                                {document.location.href = 'viewOffers.php?offerID='+offer;}
                                        break;
                                    case 2:
                                            if(table=='offersTable' || table=='pastOffersTable' || table=='upcomingOffersTable')
                                                {document.location.href = 'viewOffers.php?offerID='+offer;}
                                        break;

                                    case 3:
                                            if(table=='offersTable')
                                                {document.location.href = 'offerDiscounts.php?offerID='+offer;}
                                            if(table=='upcomingOffersTable')
                                                {document.location.href = 'offerDiscounts.php?upcomingOfferID='+offer;}
                                            if(table=='pastOffersTable')
                                                {document.location.href = 'offerDiscounts.php?pastOfferID='+offer;}
                                        break;
                                    case 4: 
                                            if(table=='offersTable' || table=='upcomingOffersTable' || table=='pastOffersTable')
                                                {document.location.href = 'editDiscounts.php?offerID='+offer;}
                                             
                                             
                                        break;
                               }
                                //alert('table = '+table+' offer = '+offer);
                            }
                       
                            
                        </script>
                        </head>
            ";

    if((!isset($_GET['offerID'])) && (!isset($_POST['past'])) && (!isset($_POST['upcoming'])))
    {

        /* show on-going offers */


         if(isset($_GET['offerDiscounts']))
             echo"<h1>Select offer to see elgible customers</h1>";
         else
             echo"<h1>Ongoing Offers </h1>";

              echo"<form action='$PHP_SELF' method='POST'>
                        <table id ='offersTable' class='profile_sect' align='center'>
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

       echo"</tr>";
       $columns = $db->result->field_count;
       $counter=0;
       
       $today = date("Y-m-d");

       
       while ($rows = $db->result->fetch_assoc())
       {
            $eDate = $rows['End Date'];
            //echo "End Date = ",$eDAte;
            $sDate = $rows['Start Date'];
           if($eDate >= $today && $sDate<=$today)
           {
                    $i=0;$counter+=1;
                    $accessLevel = $_SESSION['access_level'];
                    echo"<tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'
                         onClick='pageRedirect(\"offersTable\",$counter,$accessLevel);'>";
                   // echo $counter;
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
       if ( $_SESSION['access_level'] < 2)
       {
            ;
       }
       else
        {
            echo"<input type='submit' value='Upcoming Offers' name='upcoming'>";
        }

       echo"&nbsp &nbsp <input type='submit' value='Past Offers' name='past'>";
          
    }
       if(isset($_POST['past']))
           {

            echo"<form action='' method='POST'>";

       echo"<table id ='pastOffersTable' class='profile_sect' align='center'>";
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
                    $accessLevel = $_SESSION['access_level'];
                    echo"<tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'
                         onClick='pageRedirect(\"pastOffersTable\",$counter,$accessLevel);'>";
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

           if(isset($_POST['upcoming']))
           {

                if ( $_SESSION['access_level'] < 2)
                {
                    die('<h1>Unauthorized</h1>');
                }
        else{

        echo"<form action='' method='POST'>";
       echo"<table id ='upcomingOffersTable' class='profile_sect' align='center'>";
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

       $today = date("Y-m-d");
       


       echo"<h1>Upcoming Offers </h1>";
       while ($rows = $db->result->fetch_assoc())
       {
            $sDate = $rows['Start Date'];
            //echo "End Date = ",$eDAte;
            //echo "start = ",$sDate,"and today =",$today,"<br/>";
           if($sDate > $today)
           {
                    $i=0;$counter+=1;
                    $accessLevel = $_SESSION['access_level'];
                    echo"<tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'
                         onclick='pageRedirect(\"upcomingOffersTable\",$counter,$accessLevel);'>";
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
           }

if(isset($_GET['offerID']))
    {
        
        $offerID = $_GET['offerID'];
        $db->runQuery("select * from discounts where id=$offerID;");
        $rows = $db->result->fetch_assoc();
        
        echo
        "
            <div id=\"profileBox\">
            <h3>Offer Details</h3><table class=\"profile_sect\">
            <tr>
                <td class = 'field'>Offer ID</td>
                <td class = field'>$rows[id]</td>
            </tr>
            <tr>
                <td class = 'field'>Description</td>
                <td class = field'>$rows[description]</td>
            </tr>
            <tr>
            <tr>
                <td class = 'field'>Value [% Discount]</td>
                <td class = field'>$rows[value]</td>
            </tr>
            <tr>
                <td class = 'field'>Criteria [No. of Orders]</td>
                <td class = field'>$rows[criteria]</td>
            </tr>
            <tr>
                <td class = 'field'>Lead Type</td>
                <td class = field'>$rows[lead_type]</td>
            </tr>
                <td class = 'field'>Start Date</td>
                <td class = field'>$rows[start_date]</td>
            </tr>
            <tr>
                <td class = 'field'>End Date</td>
                <td class = field'>$rows[end_date]</td>
            </tr>

           
        ";
         echo"</table></div><form><input type='submit' value='Back' onClick='history.go(-1);return true;'> </form>";
    }
echo"</body></html>";
get_footer();
?>
<!--<div id='profileBox'>-->