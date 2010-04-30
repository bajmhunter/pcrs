<?php

     include('includes/_.php');
     check_auth();
     $_SESSION['view'] = 'Add Customer';

     /*
      * Only Sales Person Can Add Customers
      */
     if ( $_SESSION['access_level'] < 3)
        {
            die('<h1>Unauthorized</h1>');
        }

     /*
      *  Function call to get the navigation menu and header information
      */
     get_header();

    /*
     * If the User has clicked on Submit Button, prepare query and create new customer with the
     * posted information.
     */
     if(isset($_POST['submit']))
            {
                   $fName = "'".$_POST['fName']."'" ;
                   $lName = "'".$_POST['lName']."'" ;
                   $eMail = "'".$_POST['eMail']."'" ;
                   $street = "'".$_POST['street']."'" ;
                   $suite = "'".$_POST['suite']."'" ;
                   $city = "'".$_POST['city']."'" ;
                   $state = "'".$_POST['state']."'" ;
                   $zipCode = $_POST['zipCode'];
                   $type = "'".$_POST['type']."'" ;
                   $password = "'".$_POST['password']."'" ;

                    $db->runQuery("insert into customers values (null,$fName,$lName,$eMail,$street,$suite,$city,$state,$zipCode,$type,'a',null,$password);");

                    if($db->result)
                    {
                        $_SESSION['msg'] = '<div class="message">Customer Profile Created!</div>';
                        $customerID = $db->getLastInsertID();

                        /*
                         * If the customer type is 'Business - b' then add additional details to the business_customers table
                         */
                        if(isset($_POST['bName']))
                        {
                            $bName = "'".$_POST['bName'] ."'";
                            $cTitle = "'".$_POST['cTitle'] ."'";
                            $url = "'".$_POST['url'] ."'";
                            $db->runQuery("insert into business_customers values($customerID,$bName,$cTitle,$url);");
                        }
                        $_SESSION['msg'] = '<div class="message">Customer Profile Created!</div>';
                    }

                    else
                    {
                            $_SESSION['msg'] = '<div class="message error">Customer Profile Creation Failed!</div>';
                    }

                    /*
                     * If the customer type is 'Business - b' then fetch additional details from the business_customers table
                     */
                    if(isset($_POST['bName']))
                        {
                             $db->runQuery(" select c.id as 'Customer ID', c.first_name as 'First Name', c.last_name as 'Last_Name',
                                 c.email as 'E-Mail', c.street as Street, c.suite as Suite, c.city as City, c.state as State, c.zipcode as 'Zip Code',
                                 c.type as 'Type (b-Business, i-Home)', c.status as 'Status (a-Active,i-Inactive)' , c.last_access as 'Last Accessed On',
                                 B.business_name as 'Business Name', B.contact_title as 'Contact Title', B.url as 'URL'
                                 from customers C, business_customers B where id = $customerID and c.id = B.customer_id");
                        }

                     /*
                     * Else Fetch only customer details from DB if the customer type is Individual
                     */
                     else
                        {
                     $db->runQuery(" select id as 'Customer ID', first_name as 'First Name', last_name as 'Last_Name',
                             email as 'E-Mail', street as Street, suite as Suite, city as City, state as State, zipcode as 'Zip Code',
                             type as 'Type (b-Business, i-Home)', status as 'Status (a-Active,i-Inactive)' , last_access as 'Last Accessed On'
                             from customers where id = $customerID ");
                        }

                                    $columns = $db->result->field_count;
                    /*
                     * Display Created Customer's Information.
                     */
                     echo "
                            <h1> Customer Profile Created! </h1>
                            <div id='profileBox'></div>
                            <ul class='search-criteria-list'>
                                <li><a>Account Details</a>
                                    <table class='profile_sect'>
                         ";

                     $i=0;
                     $rows = $db->result->fetch_assoc();
                     while($columns>0)
                     {

                       $fieldHeader = $db->result->fetch_field_direct($i);
                       $fieldName = $fieldHeader->name;
                       echo
                       "<tr>
                           <td class='field'>$fieldName</td> <td>$rows[$fieldName]</td>
                        </tr>";
                        $columns--;
                        $i++;
                     }
                     echo"</li></ul></table></div></body></html>";
                     unset($_SESSION['msg']);
            }
    /*
     * If the User has NOT clicked on submit. Show the form to create customers
     */
     else
         {
            echo"<html>
                    <body>
                    <h1> Add New Customer </h1>
                    <div id='customer-search-wrap'>
                        <form id='create-customer' method='POST' action=$PHP_SELF>
                            <ul class='search-criteria-list'>
                            <li><a>Account Details</a>

                            <table id='#details' class='table2'>
                                <tr>
                                <td>First Name</td><td><input type='text' class='mid' name='fName'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>Last Name</td><td><input type='text' class='mid' name='lName'/></td>

                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>Login e-Mail</td><td><input type='text' class='full' name='eMail'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>Re-enter e-Mail</td><td><input type='text' class='full' name='rEMail'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>Password</td><td><input type='password' class='mid' name='password'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>Re-enter Password</td><td><input type='password' class='mid' name='rPassword'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>Street</td><td><input type='text' class='full' name='street'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>Suite</td><td><input type='text' class='mid' name='suite'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>City</td><td><input name='city' type='text' class='mid'/></td>
                                </tr>
                                <tr><td><br/></td></tr>
                                <tr>
                                <td>State</td><td><select name ='state'><optgroup label='U.S. States'>
                                <option name='AK' value='AK'>Alaska</option>
                                <option name='AL' value='AL'>Alabama</option>
                                <option name='AR' value='AR'>Arkansas</option>
                                <option name='AZ' value='AZ'>Arizona</option>
                                <option name='CA' value='CA'>California</option>
                                <option name='CO' value='CO'>Colorado</option>
                                <option name='CT' value='CT'>Connecticut</option>
                                <option name='DC' value='DC'>District of Columbia</option>
                                <option name='DE' value='DE'>Delaware</option>
                                <option name='FL' value='FL'>Florida</option>
                                <option name='GA' value='GA'>Georgia</option>
                                <option name='HI' value='HI'>Hawaii</option>
                                <option name='IA' value='IA'>Iowa</option>
                                <option name='ID' value='ID'>Idaho</option>
                                <option name='IL' value='IL'>Illinois</option>
                                <option name='IN' value='IN'>Indiana</option>
                                <option name='KS' value='KS'>Kansas</option>
                                <option name='KY' value='KY'>Kentucky</option>
                                <option name='LA' value='LA'>Louisiana</option>
                                <option name='MA' value='MA'>Massachusetts</option>
                                <option name='MD' value='MD'>Maryland</option>
                                <option name='ME' value='ME'>Maine</option>
                                <option name='MI' value='MI'>Michigan</option>
                                <option name='MN' value='MN'>Minnesota</option>
                                <option name='MO' value='MO'>Missouri</option>
                                <option name='MS' value='MS'>Mississippi</option>
                                <option name='MT' value='MT'>Montana</option>
                                <option name='NC' value='NC'>North Carolina</option>
                                <option name='ND' value='ND'>North Dakota</option>
                                <option name='NE' value='NE'>Nebraska</option>
                                <option name='NH' value='NH'>New Hampshire</option>
                                <option name='NJ' value='NJ'>New Jersey</option>
                                <option name='NM' value='NM'>New Mexico</option>
                                <option name='NV' value='NV'>Nevada</option>
                                <option name='NY' value='NY'>New York</option>
                                <option name='OH' value='OH'>Ohio</option>
                                <option name='OK' value='OK'>Oklahoma</option>
                                <option name='OR' value='OR'>Oregon</option>
                                <option name='PA' value='PA'>Pennsylvania</option>
                                <option name='PR' value='PR'>Puerto Rico</option>
                                <option name='RI' value='RI'>Rhode Island</option>
                                <option name='SC' value='SC'>South Carolina</option>
                                <option name='SD' value='SD'>South Dakota</option>
                                <option name='TN' value='TN'>Tennessee</option>
                                <option name='TX' value='TX'>Texas</option>
                                <option name='UT' value='UT'>Utah</option>
                                <option name='VA' value='VA'>Virginia</option>
                                <option name='VT' value='VT'>Vermont</option>
                                <option name='WA' value='WA'>Washington</option>
                                <option v='WI' value='WI'>Wisconsin</option>
                                <option name='WV' value='WV'>West Virginia</option>
                                <option name='WY' value='WY'>Wyoming</option>
                                </optgroup>
                                </select>
                                </tr>
                                <tr><td><br/></td></tr>

                                <tr>
                                <td>Zip Code</td><td><input name='zipCode' type='text' maxlength = 6/></td>
                                </tr>
                                <tr><td><br/></td></tr>



                                <tr>
                                <td>Type</td><td><select name='type' id='type' onChange=\"showBusiness('type','business')\"/><option name='i' value='i' id='i'>Individual</option><option name='b' value='b' id='b'>Business</option></select></td>
                                </tr>

                            </table>
                                <div id='business' style='display:none'>
                                <table class='table2'>
                                <tr>
                                <td>Business Name</td><td><input type='text' class='mid' name='bName'/></td>
                                </tr>

                                <tr><td><br/></td></tr>

                                <tr>
                                <td>Contact Title</td><td><input type='text' class='mid' name='cTitle'/></td>
                                </tr>

                                <tr><td><br/></td></tr>

                                <tr>
                                <td>Url</td><td><input type='text' class='mid' name='url'/></td>
                                </tr>

                                <tr><td><br/></td></tr>
                            </table>
                            </div>


                            </li>
                        </ul>
                        &nbsp; &nbsp; <input type='submit' value='Create Account' name='submit'>
                    </form>
                </div>
            </body>";
        /*
        * Javascript to  show a datePicker [calender] to enter date
        */
        echo"
        <script type='text/javascript'>
        function showBusiness(id,div)
        {
        var selectedNode = document.getElementById(id);
        var showHide = selectedNode.options[selectedNode.selectedIndex].value;
        if (showHide == 'b')
        document.getElementById(div).style.display = 'block';
        else
        document.getElementById(div).style.display = 'none';
        //alert(showHide);
        }

        </script>
        <?
        </html>";
    }
    get_footer();?>
