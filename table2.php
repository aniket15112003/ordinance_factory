<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <?php
include 'database.php';
$db=new Database();
$emp_all_data=$db->select("sm_salmst","*");
$start_date = "2023-08-28";
$end_date = '2023-10-01';

$all_in_out_data= $db->query("SELECT *
FROM `m_inout`
WHERE `date` BETWEEN '$start_date' AND '$end_date'")->fetchAll();

    $emp_data = [
        'in' => "930",
        'out' => "1830",
        'ot' => "30",
        'bonus' => '0',
        'shift' => 'G',
        'nsa' => '0'
    ];

    //foreach($emp_data as $key => $emp){
    $emp=$emp_data;
    $data = [];
    $current_date = $start_date;
    $bonus_month=0;
    $bonus_week=0;
    while (strtotime($current_date) <= strtotime($end_date)) {
        $is_holiday=true;
        $is_leave_applied=false;
        $shift_asign='G';
        $shift_in_time='30';
        $shift_out_time= '21';
        $weekly_hours= '51';
        $emp_in_time= '32';
        $emp_out_time= '26';
        $is_saturday=false;
        $is_night_shift=false;
        $is_deputation=false;

        $late_come_hours= $shift_in_time-$emp_in_time;
        $early_out_hours=$shift_out_time-$emp_out_time;

        $ot=0;
        if($weekly_hours==51 and $late_come_hours>=0 and $early_out_hours <=0)
        {
            $ot=30;
        }else if($weekly_hours== 54  and $late_come_hours>=0 and $early_out_hours <=0)
        {
            $ot=100;
        }
        if($is_saturday)
        {
            $ot+=3.15;
        }

        if('present')
        {
            $bonus_week++;
        }


        $data[$current_date] = $emp_data;
        $current_date = date("Y-m-d", strtotime($current_date . " +1 day"));
    }


    $emp_data = array(
        'employee_data' => $emp,
        'data'=>$data
    );
    
    echo "<pre>";
    //print_r($emp);
    $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $transposedData = [];
    foreach ($data as $date => $values) {
        foreach ($values as $key => $value) {
            if (!isset($transposedData[$key])) {
                $transposedData[$key] = [];
            }
            $transposedData[$key][$date] = $value;
        }
    }

    echo '<table border="1">';
    $colspan = sizeof($data) + 6;
  
    echo "<tr><td colspan='" . $colspan . "'>TicketNo : 5201 $space Personnel No : 005321 $space Name : ANIKETJOSHI $space Design : DEMO $space Section : Q.c(P) $space Basic Pay: 3200</td></tr>";
   
    echo '<tr><th></th>';
    $count = 0;
    foreach (array_keys($data) as $date) {
        $day = date('D', strtotime($date));
        $d = date('j', strtotime($date));
        $dayAbbreviation = $day == 'Sat' ? substr($day, 0, 2) : substr($day, 0, 1);
        if ($count % 7 == 0 and $count > 0) {
            echo "<th rowspan=7>&nbsp;&nbsp;&nbsp;&nbsp;</th>";
        }
        echo '<th>' . $d . $dayAbbreviation . '</th>';

        $count++;
    }
    echo '<th>Total</th>';
    echo '</tr>';
    $total_ot = $total_bonus = $total_nsa = 0;
    foreach ($transposedData as $key => $values) {
        echo '<tr>';
        echo '<td>' . $key . '</td>';

        foreach ($values as $date => $value) {
            echo '<td>' . $value . '</td>';
            if ($key == 'ot') {
                $total_ot += (int) $value;
            } else if ($key == 'bonus') {
                $total_bonus += (int) $value;
            } else if ($key == 'nsa') {
                $total_nsa += (int) $value;
            }
        }
        if ($key == 'ot') {
            echo "<td>$total_ot</td>";
        } else if ($key == 'bonus') {
            echo "<td>$total_bonus</td>";
        } else if ($key == 'nsa') {
            echo "<td>$total_nsa</td>";
        } else {
            echo "<td></td>";
        }
        echo '</tr>';
    }
    echo "<tr><td colspan='" . $colspan . "'>DP : 10 $space CL : 10 $space EL : 15 $space HPL : 0</td></tr>";
    echo '</table>';
    ?>
</body>

</html>