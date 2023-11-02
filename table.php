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
 
 
 $demo_data = [
        'in' => "930",
        'out' => "1830",
        'ot' => "30",
        'bonus' => '0',
        'shift' => 'G',
        'nsa' => '0'
    ];
    $start_date = "2023-08-28";
    $end_date = '2023-10-01';
    $data = [];

    $current_date = $start_date;
    while (strtotime($current_date) <= strtotime($end_date)) {
        $data[$current_date] = $demo_data;
        $current_date = date("Y-m-d", strtotime($current_date . " +1 day"));
    }


    $emp = [
        [
            "ticket_no" => '12345',
            "personal_no" => 123456,
            'name' => "prasad neve",
            "design" => 'director',
            'data' => $data
        ],
        [
            "ticket_no" => '54321',
            "personal_no" => 654321,
            'name' => "Demo",
            "design" => 'manager',
            'data' => $data
        ],
        [
            "ticket_no" => '99999',
            "personal_no" => 888888,
            'name' => "Jane Smith",
            "design" => 'engineer',
            'data' => $data
        ]
    ];
    
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