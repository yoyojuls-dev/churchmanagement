<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=Generator content="microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.msoNormal, li.msoNormal, div.msoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:8.0pt;
	margin-left:0in;
	line-height:107%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.msoAcetate, li.msoAcetate, div.msoAcetate
	{mso-style-link:"Balloon Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char";
	mso-style-link:"Balloon Text";
	font-family:"Tahoma","sans-serif";}
.msoChpDefault
	{font-family:"Calibri","sans-serif";}
.msoPapDefault
	{margin-bottom:8.0pt;
	line-height:107%;}
@page WordSection1
	{size:13.0in 8.5in;
	margin:48.25pt .5in .5in .75in;}
div.WordSection1
	{page:WordSection1;}
.summary-box {
	background-color: #f8f9fa;
	border: 1px solid #dee2e6;
	border-radius: 5px;
	padding: 15px;
	margin: 20px 0;
}
.total-amount {
	font-size: 18px;
	font-weight: bold;
	color: #28a745;
}
@media print {
	.no-print { display: none; }
	.summary-box { 
		background-color: #f0f0f0 !important; 
		-webkit-print-color-adjust: exact;
	}
}
-->
</style>
<?php include('print_header.php'); ?>
<?php include('session.php'); ?>
<?php error_reporting(0)?>
</head>

<body lang=EN-US>
<div class="empty">
<?php include('#'); ?>
<div class="container">
  <div class="row-fluid">
      
    </div>
  </div>
 </div>
</div>

 <div class="container">
 <div class="row-fluid">
 <div class="block">
<div class="row-fluid">

<div class=WordSection1>

<p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span style='font-size:14.0pt;
font-family:"Times New Roman","serif"'><img width=100 height=20 id="Picture 1"
src="images/pmanlogos.png"></span></b></p>

<p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span style='font-size:12.0pt;
font-family:"Times New Roman","serif"'>Deeshealy Do Parish</span></b></p>

<p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span style='font-size:10.0pt;
font-family:"Times New Roman","serif"'>Parish Management System - Givings Report <?php
 $date = new DateTime();
 echo $date->format('Y');
 ?></span></b></p>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><b><span style='font-size:10.0pt;font-family:"Times New Roman","serif"'>&nbsp;</span></b></p>

<div class="container">
<div class="container-fluid">
<div class="row-fluid">
<div class="pull-left"> 
<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
"Times New Roman","serif"'>GIVINGS REPORT - ALL CONTRIBUTIONS<o:p></o:p></span></p>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:10.0pt;mso-bidi-font-size:11.0pt;font-family:
"Times New Roman","serif"'>REPORT DATE: <?php
 $date = new DateTime();
 echo $date->format('l, F jS, Y');
 ?><o:p></o:p></span></p>

<div class="pull-right no-print">
   <div class="empty">
           <p class=msoNormal style='margin-bottom:0in; margin-left:-110px; margin-top:-30px; margin-bottom:.0001pt;line-height:
           normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
           "Times New Roman","serif"'>
		   <a href="#" onClick="window.print()" class="btn btn-info" id="print" data-placement="top" title="Click to Print"><i class="icon-print icon-large"></i> Print Report</a></p>		      
		   <script type="text/javascript">
		     $(document).ready(function(){
		     $('#print').tooltip('show');
		     $('#print').tooltip('hide');
		     });
		   </script> 
            <p class=msoNormal style='margin-bottom:0in; margin-top:-30px; margin-bottom:.0001pt;line-height:
            normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
           "Times New Roman","serif"'>
			<a id="return" data-placement="top" class="btn btn-success" title="Click to Return" href="giving.php"><i class="icon-arrow-left"></i> Back</a></p>		
			<script type="text/javascript">
			$(document).ready(function(){
			$('#return').tooltip('show');
			$('#return').tooltip('hide');
			});
			</script>       	   
    </div>
</div>

<?php
// Calculate summary statistics
$total_amount_query = mysqli_query($conn, "SELECT SUM(CAST(g.Amount AS DECIMAL(10,2))) as total_amount, COUNT(*) as total_records FROM giving g");
$total_stats = mysqli_fetch_array($total_amount_query);

$monthly_query = mysqli_query($conn, "SELECT MONTH(g.paytime) as month, YEAR(g.paytime) as year, SUM(CAST(g.Amount AS DECIMAL(10,2))) as monthly_total FROM giving g WHERE YEAR(g.paytime) = YEAR(CURDATE()) GROUP BY YEAR(g.paytime), MONTH(g.paytime) ORDER BY year DESC, month DESC LIMIT 12");

// Get total count for report header
$count_giving = mysqli_query($conn, "SELECT COUNT(*) as total FROM giving");
$count_result = mysqli_fetch_array($count_giving);
$total_givings = $count_result['total'];
?>

<div class="summary-box">
<p class=msoNormal style='margin-bottom:5pt;line-height:normal'>
<span style='font-size:11.0pt;font-family:"Times New Roman","serif"'><strong>REPORT SUMMARY:</strong></span></p>
<p class=msoNormal style='margin-bottom:5pt;line-height:normal'>
<span style='font-size:10.0pt;font-family:"Times New Roman","serif"'>
Total Contributions: <strong><?php echo number_format($total_stats['total_records']); ?></strong> records</span></p>
<p class=msoNormal style='margin-bottom:5pt;line-height:normal'>
<span class="total-amount" style='font-size:12.0pt;font-family:"Times New Roman","serif"'>
Grand Total Amount: ₱<?php echo number_format($total_stats['total_amount'], 2); ?></span></p>
</div>
    
<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<table class=msoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0in 5.4pt 0in 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:23.25pt'>
  <td width=120 style='width:90pt;border:solid windowtext 1.0pt;mso-border-alt:
  solid windowtext .5pt;background:#BFBFBF;mso-background-themecolor:background1;
  mso-background-themeshade:191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>Member Name<o:p></o:p></span></b></p>
  </td>
  <td width=100 style='width:75pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>Mobile No.<o:p></o:p></span></b></p>
  </td>
  <td width=80 style='width:60pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>Amount<o:p></o:p></span></b></p>
  </td>
  <td width=110 style='width:82.5pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>Transaction Code<o:p></o:p></span></b></p>
  </td>
  <td width=120 style='width:90pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>Purpose/For<o:p></o:p></span></b></p>
  </td>
  <td width=100 style='width:75pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>Date & Time<o:p></o:p></span></b></p>
  </td>
  </tr>
  
   <!-- mysqli FETCH ARRAY for Givings Data -->
<?php
// Enhanced query with better error handling and member info
$giving_query = mysqli_query($conn, "
    SELECT g.*, m.fname, m.lname, m.mobile 
    FROM giving g 
    LEFT JOIN members m ON g.na = m.id 
    ORDER BY g.paytime DESC
") or die("Database Error: " . mysqli_error($conn));

$row_count = 0;
$running_total = 0;

while($row = mysqli_fetch_array($giving_query)){
    $row_count++;
    $amount = floatval($row['Amount']);
    $running_total += $amount;
    
    // Handle member name display
    $member_name = 'Unknown Member';
    if (!empty($row['fname']) && !empty($row['lname'])) {
        $member_name = $row['fname'] . ' ' . $row['lname'];
    }
    
    // Handle mobile number
    $mobile = !empty($row['mobile']) ? $row['mobile'] : $row['na'];
    
    // Format date
    $date_formatted = date('M d, Y', strtotime($row['paytime']));
    $time_formatted = date('h:i A', strtotime($row['paytime']));
?>
 <tr style='mso-yfti-irow:<?php echo $row_count; ?>'>
  <td width=120 valign=top style='width:90pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:8.0pt;font-family:"Times New Roman","serif"'><?php echo htmlspecialchars($member_name); ?><o:p></o:p></span></p>
  </td>
  <td width=100 valign=top style='width:75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:8.0pt;font-family:"Times New Roman","serif"'><?php echo htmlspecialchars($mobile); ?><o:p></o:p></span></p>
  </td>
  <td width=80 valign=top style='width:60pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal;text-align:right'><span style='font-size:8.0pt;font-family:"Times New Roman","serif"'>₱<?php echo number_format($amount, 2); ?><o:p></o:p></span></p>
  </td>
  <td width=110 valign=top style='width:82.5pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:8.0pt;font-family:"Times New Roman","serif"'><?php echo htmlspecialchars($row['Trcode']); ?><o:p></o:p></span></p>
  </td>
  <td width=120 valign=top style='width:90pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:8.0pt;font-family:"Times New Roman","serif"'><?php echo htmlspecialchars($row['ya'] ? $row['ya'] : 'General Fund'); ?><o:p></o:p></span></p>
  </td>
  <td width=100 valign=top style='width:75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:7.0pt;font-family:"Times New Roman","serif"'><?php echo $date_formatted; ?><br><?php echo $time_formatted; ?><o:p></o:p></span></p>
  </td>
 </tr>
<?php } ?> 
  <!--End mysqli FETCH ARRAY-->

 <!-- Summary Row -->
 <tr style='mso-yfti-irow:<?php echo $row_count + 1; ?>;background:#F0F8FF'>
  <td colspan=2 valign=top style='border:solid windowtext 1.0pt;border-top:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#F0F8FF;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal;text-align:right'><b><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>TOTAL CONTRIBUTIONS:</span></b></p>
  </td>
  <td valign=top style='border:solid windowtext 1.0pt;border-top:none;border-left:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#F0F8FF;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal;text-align:right'><b><span style='font-size:10.0pt;font-family:"Times New Roman","serif";color:#28a745'>₱<?php echo number_format($running_total, 2); ?></span></b></p>
  </td>
  <td colspan=3 valign=top style='border:solid windowtext 1.0pt;border-top:none;border-left:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#F0F8FF;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b><span style='font-size:9.0pt;font-family:"Times New Roman","serif"'><?php echo $row_count; ?> Total Records</span></b></p>
  </td>
 </tr>

 <tr style='mso-yfti-irow:<?php echo $row_count + 2; ?>;mso-yfti-lastrow:yes'>
  <td width=630 colspan=6 valign=top style='width:472.5pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-family:"Times New Roman","serif"'>***END OF GIVINGS REPORT***<o:p></o:p></span></p>
  </td>
 </tr>
</table>

<!-- Monthly Summary (if needed) -->
<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><b><span style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Monthly Summary (Current Year):</span></b></p>

<table class=msoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0in 5.4pt 0in 5.4pt;width:400pt'>
<?php 
mysqli_data_seek($monthly_query, 0); // Reset query pointer
while($monthly = mysqli_fetch_array($monthly_query)){ 
    $month_name = date('F', mktime(0, 0, 0, $monthly['month'], 1));
?>
 <tr>
  <td width=200 style='width:150pt;border:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal'>
  <span style='font-size:9.0pt;font-family:"Times New Roman","serif"'><?php echo $month_name . ' ' . $monthly['year']; ?></span></p>
  </td>
  <td width=200 style='width:150pt;border:solid windowtext 1.0pt;border-left:none;
  mso-border-left-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal;text-align:right'>
  <span style='font-size:9.0pt;font-family:"Times New Roman","serif"'>₱<?php echo number_format($monthly['monthly_total'], 2); ?></span></p>
  </td>
 </tr>
<?php } ?>
</table>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<!-- Signature Section -->
<table class=msoTableGrid border=0 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-yfti-tbllook:1184;mso-padding-alt:
 0in 5.4pt 0in 5.4pt;mso-border-insideh:none;mso-border-insidev:none'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:44.85pt'>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman","serif"'>Prepared by:<o:p></o:p></span></p>
  </td>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman","serif"'>Reviewed by:<o:p></o:p></span></p>
  </td>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman","serif"'>Approved by:<o:p></o:p></span></p>
  </td>
 </tr>
 
 <?php $query= mysqli_query($conn,"SELECT * FROM admin WHERE admin_id = '$session_id'")or die(mysqli_error());
  $admin_row = mysqli_fetch_array($query);
?>
 <tr style='mso-yfti-irow:1;height:17.85pt'>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><u><span
  style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'><?php echo $admin_row['firstname']." ".$admin_row['lastname']; ?><o:p></o:p></span></u></b></p>
  </td>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><u><span
  style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>_____________________<o:p></o:p></span></u></b></p>
  </td>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><u><span
  style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>_______________________<o:p></o:p></span></u></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;mso-yfti-lastrow:yes'>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>System Administrator<o:p></o:p></span></p>
  </td>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>Finance Committee<o:p></o:p></span></p>
  </td>
  <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>Parish Priest<o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal'><span style='font-size:8.0pt;font-family:"Times New Roman","serif"'>
This report was generated on <?php echo date('F j, Y \a\t g:i A'); ?> | Parish Management System</span></p>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>	
<?php include('#'); ?>
</div>
<?php include('#'); ?>
 </body>
</html>