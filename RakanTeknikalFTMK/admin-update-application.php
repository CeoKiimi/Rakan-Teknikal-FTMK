<?php
require_once 'auth.php'; require_admin();
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: admin-pendingapplications.php');exit;}
$applicationId=(int)($_POST['application_id']??0); $action=$_POST['action']??''; $adminId=(int)($_SESSION['admin_db_id']??0); if($applicationId<=0){header('Location: admin-pendingapplications.php');exit;}
try{
 $conn->begin_transaction();
 if($action==='approve'||$action==='reject'){
  $status=$action==='approve'?'Approved':'Rejected';
  $stmt=$conn->prepare("UPDATE applications SET status=?, decided_by=?, decided_at=NOW() WHERE application_id=? AND status='Pending'"); $stmt->bind_param('sii',$status,$adminId,$applicationId); $stmt->execute();
 } elseif($action==='complete'){
  $stmt=$conn->prepare("SELECT a.student_id, COALESCE(j.allowance_amount, a.paid_amount, 0) amount FROM applications a INNER JOIN jobs j ON a.job_id=j.job_id WHERE a.application_id=? AND a.status='Approved' FOR UPDATE"); $stmt->bind_param('i',$applicationId); $stmt->execute(); $row=$stmt->get_result()->fetch_assoc();
  if($row){ $amount=(float)$row['amount']; $studentId=(int)$row['student_id']; $u=$conn->prepare("UPDATE applications SET status='Completed', paid_amount=?, decided_by=?, decided_at=NOW() WHERE application_id=?"); $u->bind_param('dii',$amount,$adminId,$applicationId); $u->execute(); $m=$conn->prepare("UPDATE students SET merit_score=LEAST(100, merit_score + 10) WHERE student_id=?"); $m->bind_param('i',$studentId); $m->execute(); }
 }
 $conn->commit();
}catch(Throwable $e){try{$conn->rollback();}catch(Throwable $x){}}
header('Location: admin-pendingapplications.php'); exit;
?>
