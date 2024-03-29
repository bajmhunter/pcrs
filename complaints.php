<?php

include('includes/_.php');
check_auth();
$_SESSION['view'] = 'Complaints';

//set customer id
//a customer may only view his/her complaints so uid defaults to session id
$cust_id = ($_SESSION['access_level']==1) ? $_SESSION['user_id'] : $_GET['cid'];

//set ajax mode
$ajaxmode = (isset($_GET['ajaxmode']) ) ? true : false;

//response
$response = new stdClass();

if( isset( $_GET['action'] ) ){
	switch($_GET['action']){

		case 'add_complaint' :
			addComplaint();
			exit();
			break;
			
		case 'update_complaint' :
			updateComplaint();
			exit();
			break;
		

		default :
			listComplaints();
			break;

	}
}
else{
	listComplaints();
}
/*-------------------------------------------------------------
    @name:    getComplaint
    @purpose: Returns a single complaint specified by its id
  ------------------------------------------------------------*/
function getComplaint(){
	global $db;

	$query = sprintf("select * from customer_complaints where id = %s;",1);
	$db->runQuery($query);

	//while( $row = $db->result->fetch_object() ){

	//echo json_encode( $db->result->fetch_object() );

	if($ajaxmode) exit();
}


function addComplaint(){
	global $db, $cust_id, $response,$ajaxmode;
	$title = $db->escape($_GET['title']);
	$details = $db->escape($_GET['details']);
	$query = sprintf("insert into customer_complaints(customer_id,title,details) values(%s,'%s','%s');",$cust_id,$title,$details);
	$db->runQuery($query);

	//successful insert
	if($db->result){
		if($ajaxmode){
			$response->status = 1;
			$response->text = '<div class="message">Complaint submitted successfully</div>';
			echo json_encode($response);
			exit();
		}
		else{

		} //pr
	}
	//unsuccessful insert
	else{
		if($ajaxmode){
			$response->status = 0;
			$response->text = '<div class="message error">Error adding Comlaint...Try again</div>';
			echo json_encode($response);
			exit();
		}
	}

	//if($ajaxmode) exit();
}

function updateComplaint(){
	global $db, $cust_id, $response, $ajaxmode;
	$id = $_GET['id'];
	$new_stat = $_GET['stat'];
	//UPDATE  `pcrs`.`customer_complaints` SET  `status` =  '1' WHERE  `customer_complaints`.`id` =2;
	$query = "update customer_complaints set status = '$new_stat' where id = $id;";
	
	$db->runQuery($query);
	if($db->result){
		$response->status= 1;
		$response->text = '<div class="message">Complaint updated</div>';
	}
	else{
		$response->status = 0;
		$response->text = '<div class="message error">Error updating complaint</div>';
	}
	echo json_encode($response);
	exit();
	
}

function listComplaints(){
	global $db, $cust_id, $response, $ajaxmode;

	$where = ($_SESSION['access_level']==1) ? " where c.id = $cust_id" : '';
	$query =
<<<Q
SELECT concat(c.first_name, ' ', c.last_name) as fullname, c.id as cid, cc.id as id, cc.status as status, cc.time as time, cc.title as title, cc.details as details
FROM `customer_complaints`as cc inner join `customers` as c on c.id = cc.customer_id
$where
order by cc.time desc;
Q;

	$db->runQuery($query);

	$list = array();
	$curr = new stdClass();
	while( $row = $db->result->fetch_object() ){
		$curr->id = 'complaint-'.$row->id;
		$curr->stat = ($row->status==1) ? 'open' : 'closed';
		$curr->info = '<div class="header"><h4>'. $row->title .'</h4>';
		$cust = ($_SESSION['access_level'] == 4) ? '| by <a href="profile.php?domain=customers&id='.$row->cid.'">'.$row->fullname.'</a>' : '';
		$curr->info .= '<small>'. mysql_to_date( $row->time ) .$cust.'</small></div>';
		$curr->info .= '<p>'.$row->details.'</p>';
		if( $_SESSION['access_level'] == 4 ){
			$axn = ($row->status==1) ? 'Close Complaint' : 'Re-open Complaint';
			$curr->ctrl = '<p><a href="#" class="update" rel="'.$row->id.'">'.$axn.'</a></p>';
		}
		else $curr->ctrl = '';
		$list[] = $curr;
		unset($curr);
	}
	if($ajaxmode){
		echo json_encode( $list );
		exit();
	}
	$response->History = $list;
}


if( $_SESSION['access_level'] == 1 ){
$response->Add = <<<ADDFORM
<h3>File a new complaint</h3>
<form id="acf" class="form1" action="#">
<div id="errors"></div>
<ul>
<li>
<label>Subject</label>
<input type="text" class="full" name="title" id="title"/>
</li>
<li>
<label>Details</label>
<textarea name="details" id="details"></textarea>
</li>
<li>
<input type="hidden" action="add_complaint" />
<input type="submit" value="Submit" onClick="doACS();return false;"/>
</li>
</ul>
</form>
ADDFORM;
}

get_header(); ?>

<div id="complaints">
<h1 id="complaints-h1">Complaints</h1>
</div>
<script type="text/javascript">
var data = <?php echo json_encode( $response ); ?>;
var list = ['<ul class="complaint-list">'];
var ogHTML = '';

if( data['History'].length == 0 )
	list.push('<li><h3 style="text-align:center">You have not filed any complaints</h3></li>');
	
for(var i=0; i<data['History'].length;  i++){
	var curr = data['History'][i];
	list.push('<li id="',curr['id'],'" class="',curr['stat'],'">',curr['info'],curr['ctrl'],'</li>');
}
list.push('</ul>');
ogHTML += list.join('');

if( data['Add']!=null ){
	$stage = $('#complaints');
	$('#complaints-h1').addClass('wtabselect');
	$stage.append('<ul class="tabselect"><li><a href="#complaints-list">Recent</a></li><li><a href="#add-complaint">Add Complaint</a></li></ul><div id="complaints-list" class="tab-content"></div><div id="add-complaint" class="tab-content"></div>');
	$('#complaints-list').html(ogHTML);
	$('#add-complaint').html(data['Add']);
	$stage.tabs();
	ogHTML = $stage.html();
}
else{
	ogHTML = '<div id="compalaints-list">'+ogHTML+'</div>';
	$('#complaints').append( ogHTML );
}

/*Submit add complaints form*/
$('#acf').submit( doACS );
function doACS(){

	$title = $('#title');
	$details = $('#details');
	$errorDiv = $('#errors').toggle();
	$form = $('#acf');
	var Errors = [];

	//clear form
	$('input, textarea', $form).removeClass("invalid").each( function(){
		$(this).val( $.trim( $(this).val() ) );
	});

	if( $title.val().length < 5 ){
		Errors.push('<li>Please enter a more descriptive title</li>');
		$title.addClass('invalid');
	}
	if( $details.val().length < 20 ){
		Errors.push('<li>Please enter a more details</li>');
		$details.addClass('invalid');
	}
	if( Errors.length > 0 ){
		$errorDiv.html( '<div class="error-list"><h5>' + Errors.length + ' error(s) encountered!</h5><ul>' + Errors.join('') + '</ul></div>' ).show();
		return false;
	}
	
	var arg = 'complaints.php?' + $('#acf').serialize() + '&action=add_complaint&ajaxmode=1';
	$.getJSON(arg,{},function(response){

		if(response.status==1){
			showMsg(response.text);
			$('#acf')[0].reset();
			setTimeout('window.location.reload()',3000);
		}
		else{
			showMsg(response.text);
		}
	});
	return false;
}

$('.update').click(function (){
	var nstatus = 0; //closed stat
	if($(this).text() == 'Re-open Complaint') nstatus = 1;
	
	var id = $(this).attr('rel');
	var arg = 'complaints.php?&action=update_complaint&ajaxmode=1&stat='+nstatus+'&id='+id;

	
	$.getJSON(arg,{},function(response){

		if(response.status==1){
			showMsg(response.text);
			setTimeout('window.location.reload()',3000);
			$('#complaint-'+id).toggleClass('open');
			if( nstatus == 1 ) $(this).text('Close Complaint');
			else $(this).text('Re-open Complaint');
		}
		else{
			showMsg(response.text);
		}
	});
	return false;
});
</script>


<?php get_footer(); ?>
