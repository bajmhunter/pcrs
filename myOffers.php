<?php

 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'My Offers';
 $uid = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : $_SESSION['user_id'];
 if( $_SESSION['access_level'] == 1 && $_SESSION['user_id'] != $uid ) die("Unauthorized!");
 get_header();
 $customerID = $uid;
?>
<?php

if(!isset($_GET['offerID']))
    {
echo "

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
                                var order = document.getElementById('offersTable').rows[indexOfRow].cells[0].innerHTML;
                                document.location.href = 'myOffers.php?offerID='+order;
                                
                            }


                        </script>
                        

    <h1> You have been offered the following discounts</h1></br>
      Click to view the details of the offer:

    ";

    
        echo"<div id='profileBox'></div>
                        <form action='$PHP_SELF' method='GET'>
                            <table  align='center' id='offersTable' class='profile_sect'>
                                <tr align = 'center'>
                                    <th class ='field'> &nbsp &nbsp Discount ID &nbsp &nbsp </th>
                                    <th class ='field'> &nbsp &nbsp Start Date &nbsp &nbsp </th>
                                    <th class ='field'> &nbsp &nbsp End Date &nbsp &nbsp </th>
                                    <th class ='field'> &nbsp &nbsp Value &nbsp &nbsp </th>
                                </tr>";
        $db->runQuery("select CD.discount_id as discount_id,
            D.start_date as start_date, D.end_date as end_date, D.value as value
            from customer_discounts CD, discounts D where customer_id=$customerID and CD.discount_id = D.id;");

        $counter=0;
        while($rows = $db->result->fetch_row())
        {
            $counter+=1;
            echo "<tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);'
                        onmouseout = 'changeRowColor(this,false);' onClick='pageRedirect($counter);'>
                                    <td>  $rows[0]  </td>
                                    <td>  $rows[1]  </td>
                                    <td>  $rows[2]  </td>
                                    <td>  $rows[3]  </td>
                                </tr>";
            //print_r($rows);
        }

}
if(isset($_GET['offerID']))
    {
   // echo"<h1>I AM HERE</h1>";
        $offerID = $_GET['offerID'];
       
                $db->runQuery("select CD.discount_id, CD.date,
                                D.description, D.start_date,D.end_date,D.value,D.criteria
                                 from customer_discounts CD, discounts D
                                 where CD.discount_id = $offerID and CD.discount_id = D.id
                                and CD.customer_id = $customerID;
                                ");
                $rows = $db->result->fetch_assoc();
        //    print_r($rows);
        echo
                "
                    <div id='profileBox'></div>
                    <h3>Offer Information</h3>
                    <table class='profile_sect'>
                        <tr><td class='field'>Discount ID</td><td>$rows[discount_id]</td></tr>
                        <tr><td class='field'>Description</td><td>$rows[description]</td></tr>
                        <tr><td class='field'>Start Date</td><td>$rows[start_date]</td></tr>
                        <tr><td class='field'>End Date</td><td>$rows[end_date]</td></tr>
                        <tr><td class='field'>Value &nbsp [%Discount]</td><td>$rows[value]</td></tr>
                        <tr><td class='field'>Criteria &nbsp [No. Of Orders] </td><td>$rows[criteria]</td></tr>
                        <tr><td class='field'>Offered On</td><td>$rows[date]</td></tr>
                        </table>





";
                    


                    

   } ?>

   <?php echo "</table></form></body></html>";
get_footer(); ?>