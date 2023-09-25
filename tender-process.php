<?php
session_start();

require_once('functions/functions.php');

require_once('Mail.php');

select_db();

$_SESSION['winner_id'] = array();

$query = mysql_query("SELECT SUM(Total) AS Total_1, BidderId FROM tbl_tender_fields GROUP BY BidderId")or die(mysql_error());
while($row = mysql_fetch_array($query)){
	
	$id = $row['BidderId'];
	$total = $row['Total_1'];
	
	mysql_query("UPDATE tbl_tender_fields SET OverallTotal = '$total' WHERE BidderId = '$id'")or die(mysql_error());
	
}

$query = mysql_query("SELECT * FROM tbl_tenders")or die(mysql_error());
while($row = mysql_fetch_array($query)){
	
	$closingdate = $row['ClosingDate'];
	
	if(time() > $closingdate){
		
		$tenderid = $row['Id'];
		
		$sum_totals = array();
		
		$query2 = mysql_query("SELECT OverallTotal AS Total_1 FROM tbl_tender_fields WHERE TenderId = '$tenderid' AND Complete = '1' GROUP BY BidderId")or die(mysql_error());
		$numrows = mysql_num_rows($query2);
		while($row2 = mysql_fetch_array($query2)){
			
			$total = $row2['Total_1'];
			
			array_push($sum_totals, $total);
		}
		
		$sum = array_sum($sum_totals);
		
		$average = number_format(($sum / $numrows),2);
		
		$query3 = mysql_query("SELECT * FROM  tbl_tender_fields WHERE TenderId = '$tenderid' AND OverallTotal < '$average' AND Complete = '1' GROUP BY BidderId ORDER BY Id DESC LIMIT 1")or die(mysql_error());
		$row3 = mysql_fetch_array($query3);
		
		$min = $row3['OverallTotal'];
		
		$min_difference = $average - $min;
		
		$query4 = mysql_query("SELECT * FROM  tbl_tender_fields WHERE TenderId = '$tenderid' AND OverallTotal > '$average' AND Complete = '1' GROUP BY BidderId ORDER BY Id ASC LIMIT 1")or die(mysql_error());
		$row4 = mysql_fetch_array($query4);
		
		$max = $row4['OverallTotal'];
		
		$max_difference = $max - $average;
		
		$query5 = mysql_query("SELECT * FROM  tbl_tender_fields WHERE TenderId = '$tenderid' AND OverallTotal = '$average' AND Complete = '1' GROUP BY BidderId ORDER BY RAND() LIMIT 1")or die(mysql_error());
		$numrows2 = mysql_num_rows($query5); 
		$row5 = mysql_fetch_array($query5);
		
		if($numrows2 == 1){
			
			$winning_total = $row5['OverallTotal'];
			$winning_bidder = $row5['BidderId'];
				
		} else {
			
			if($min_difference > $max_difference){
				
				$winning_total = $max;
				$winning_bidder = $row4['BidderId'];
			
			} else {
				
				$winning_total = $min;
				$winning_bidder = $row3['BidderId'];
			
			}
			
			if($min_difference == $max_difference){
				
				$winning_total = $min;

			}
					
		}
		
		$expirydate =  date('Y-m-d H:i:s', time() + 60 * 60 * 24);
		
		mysql_query("INSERT INTO tbl_winning_bids (TenderId,WinnerId,Total,ExpiryDate) VALUES ('$tenderid','$winning_bidder','$winning_total','$expirydate')")or die(mysql_error());
		
		$query6 = mysql_query("SELECT tbl_invitation_list.ContactPerson AS ContactPerson_1, tbl_invitation_list.Email AS Email_1, tbl_invitation_list.CompanyName AS CompanyName_1, tbl_tenders.Id, tbl_tenders.TenderName,
							  tbl_registered_users.CompanyName, tbl_registered_users.ContactPerson, tbl_registered_users.Email, tbl_registered_users.Telephone, tbl_registered_users.Address, tbl_registered_users.Suburb, 
							  tbl_registered_users.City, tbl_registered_users.Country, tbl_tender_fields.OverallTotal, tbl_invitation_list.CompanyId, tbl_tender_fields.BidderId
							  FROM (((tbl_tenders
									  LEFT JOIN tbl_tender_fields ON tbl_tender_fields.TenderId=tbl_tenders.Id)
									  LEFT JOIN tbl_registered_users ON tbl_registered_users.Id=tbl_tenders.UserId)
									  LEFT JOIN tbl_invitation_list ON tbl_invitation_list.Id=tbl_tender_fields.BidderId)
							  WHERE tbl_tender_fields.BidderId = '$winning_bidder' ")or die(mysql_error());
		$row6 = mysql_fetch_array($query6);
		
		$host = "mail.kwd.co.za"; 
		$username = "info@kwd.co.za"; 
		$password = "kwd001"; 
		$port = "587";
		$type = "text/html; charset=utf-8";
		$FromName = 'Tender Bank'; 
		$FromEmail = 'test@kwd.co.za'; 
		$ToName = $guardian_name ." ". $guardian_surname;
		$ToEmail = $row6['Email_1']; 
		$subject = 'Tender Bank';
		
		$body = '<body style="font-family:Arial; font-size:12px; color:002a76">
		<table width="800" border="0" cellpadding="2" cellspacing="3" style="font-family:Arial; font-size:12px; color:002a76">
  		<tr>
    		<td colspan="2"><img src="http://www.tenderbank.co.za/images/mail-logo.jpg" width="193" height="39" /></td>
  		</tr>
  		<tr>
    		<td colspan="2">&nbsp;</td>
  		</tr>
  		<tr>
    		<td colspan="2">&nbsp;</td>
  		</tr>
  		<tr>
    		<td colspan="2">Hi '. $row6['ContactPerson_1'] .'<br />
      		<br />
      		You&nbsp;have been awarded the following tender<br />
    		<br /></td>
  		</tr>
  		<tr>
    		<td width="100">Reference No</td>
    		<td width="683">'. $row6['Id'] .'</td>
  		</tr>
  		<tr>
    		<td>Procurement For</td>
    		<td>'. $row6['TenderName'] .'</td>
  		</tr>
  		<tr>
    		<td>Company</td>
    		<td>'. $row6['CompanyName'] .'</td>
  		</tr>
  		<tr>
    		<td>Contact Person</td>
    		<td>'. $row6['ContactPerson'] .'</td>
  		</tr>
  		<tr>
    		<td>Telephone No</td>
    		<td>'. $row6['Telephone'] .'</td>
  		</tr>
  		<tr>
    		<td>Email</td>
    		<td>'. $row6['Email'] .'</td>
  		</tr>
  		<tr>
    		<td>&nbsp;</td>
    		<td>&nbsp;</td>
  		</tr>
		</table>
		</body>';

$from = "$FromName<$FromEmail>"; 
$to = $row6['Email_1']; 
$headers = array ('From' => $from, 
'To' => $to,
'Content-type' => $type,
'Subject' => $subject); 
$smtp = Mail::factory('smtp', 
array ('host' => $host,
'port' => $port,
'auth' => true, 
'username' => $username, 
'password' => $password)); 
$mail = $smtp->send($to, $headers, $body); 
if (PEAR::isError($mail)) { }else{}

array_push($_SESSION['winner_id'], $winning_bidder);

header('Location: fpdf/notification-pdf.php');

	}
}



	
?>