<?php
require_once("condb.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
if(!isset($_SESSION['username'])){
 header('location:login.php');
 exit;
}

$subjsql = "
SELECT * FROM `register`,`subject`,`schedule`
WHERE 
`subject`.`subject_id`=`register`.`subject_id` 
AND `subject`.`subject_id`=`schedule`.`subject_id` 
AND `subject`.`term` = `register`.`subject_term`
AND `subject`.`year` = `register`.`subject_year`
AND `subject`.`section` = `register`.`subject_section`
AND `subject`.`term` = `schedule`.`subject_term`
AND `subject`.`year` = `schedule`.`subject_year`
AND `subject`.`section` = `schedule`.`subject_section`
AND `register`.`std_id` = '".$_SESSION["std_id"]."'
AND `register`.`reg_term` = '".$_SESSION["term"]."'
AND `register`.`reg_level` = '".$_SESSION["level"]."'
ORDER BY `schedule`.`time_start` ASC";

$subjqr = $conn->query($subjsql);
while ($subjresult = $subjqr->fetch_assoc()){
  $row[] = $subjresult;
}

if (!isset($row)) {
  $row[] = null;
}

function showtb($day,$row)
{
  $countspan=0;
  $j = new DateTime('08:00:00');
  for ($i=0; $i < count($row); $i++) {
    if ($row[$i]['day']==$day){
      while ($countspan<26) {
        if ($row[$i]['time_start']==$j->format('H:i:s')){
          $time1 = strtotime($row[$i]['time_start']);
          $time2 = strtotime($row[$i]['time_end']);
          $span  = (($time2 - $time1)/3600)*2;
          
          echo "<td colspan=".$span." style='background-color: #e5989b;'><b><a href='http://reg.kku.ac.th/registrar/class_info_1.asp?coursecode=".$row[$i]['subject_id']."&Acadyear=".$row[$i]['year']."&semester=".$row[$i]['term']."' target='_bank'>".$row[$i]['subject_id']."</a><br>sec : ".$row[$i]['section']."</b></td>";
          $countspan+=$span;
          $j = new DateTime($row[$i]['time_end']);
          break;
        }
        else{
          $jp = new DateTime($j->format('H:i:s'));
          $jp->add(new DateInterval('PT30M'));
          if ($row[$i]['time_start']==$jp->format('H:i:s')){
              echo "<td colspan='1'></td>";
              $countspan+=1;
              $j->add(new DateInterval('PT30M'));
              $time1 = strtotime($row[$i]['time_start']);
              $time2 = strtotime($row[$i]['time_end']);
              $span  = (($time2 - $time1)/3600)*2;
              if ($span%2==1&&$countspan%2==0) {
                echo "<td colspan='1'></td>";
                $countspan+=1;
              }
              
              echo "<td colspan=".$span." style='background-color: #e5989b;'><b><a href='http://reg.kku.ac.th/registrar/class_info_1.asp?coursecode=".$row[$i]['subject_id']."&Acadyear=".$row[$i]['year']."&semester=".$row[$i]['term']."' target='_bank'>".$row[$i]['subject_id']."</a><br>sec : ".$row[$i]['section']."</b></td>";
              $countspan+=$span;
              $j = new DateTime($row[$i]['time_end']);
              break;
          }
          elseif($countspan%2==1){
            echo "<td colspan='1'></td>";
            $countspan+=1;
            $j->add(new DateInterval('PT30M'));

          }
          else{
            $countspan+=2;
            echo "<td colspan='2'></td>";
            $j->add(new DateInterval('PT60M'));
          }
        }
      }
    }
  }
  if($countspan%2==1){
    echo "<td colspan='1'></td>";
    $countspan+=1;
  }
  for ($countspan=$countspan; $countspan <26 ; $countspan+=2) { 
    echo "<td colspan='2'></td>";
  }
}
?>
<table class='table table-bordered table-striped table-hover text-center' border="1">
  <thead>
    <tr>
      <?php
      for ($i=7; $i < 21 ; $i++) { 
        echo "<th width='3.57%''></th><th width='3.57%''></th>";
      }?>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan='2' style='background-color:#feaa90'><b>วัน/เวลา</b></td>
      <?php
      for ($i=8; $i < 21 ; $i++) {
        printf("<td colspan='2' style='background-color:#feaa90'><b>%02d:00-%02d:00</b></td>",$i,$i+1);
      }
      ?>
    </tr>
    <tr  style='background-color:#ffcdb2'>
      <td colspan='2'><b>จันทร์</b></td>
      <?php showtb('จ',$row); ?>
    </tr>
    <tr style='background-color:#ffcdb2'>
      <td colspan='2'><b>อังคาร</b></td>
      <?php showtb('อ',$row); ?>
    </tr>
    <tr style='background-color:#ffcdb2'>
      <td colspan='2'><b>พุธ</b></td>
      <?php showtb('พ',$row); ?>
    </tr>
    <tr style='background-color:#ffcdb2'>
      <td colspan='2'><b>พฤหัสบดี</b></td>
      <?php showtb('พฤ',$row); ?>
    </tr>
    <tr style='background-color:#ffcdb2'>
      <td colspan='2'><b>ศุกร์</b></td>
      <?php showtb('ศ',$row); ?>
    </tr>
  </tbody>
</table>