<table class="statisticsbox">
    <tr>
    <th>الدرجة</th>
    <th>المقدار</th>
    <th>التاريخ</th>
    </tr>

    <?php 
        $stmt = $con->prepare("SELECT reading, reading_grade, date,isPLus FROM wird_two WHERE user_id = '$userid' ORDER BY wird_id desc");
        $stmt->execute();
        $late=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $isPlus = $row['isPLus'];

            echo '<tr>';


            echo "<td class = 'reading_grade'>" . $row['reading_grade'] ."</td>"; 

            // if($isPlus == 'set'){
            //     echo "<td class = 'good'>" . $row['reading_grade'] . "</td>";
            //     $late -= $row['reading_grade'];
            // }

            // if ($isPlus != 'set' && ((float)$row['reading'] > 5)){
            //     echo "<td class = 'reading_grade good'>" . $row['reading_grade'] . "</td>";
            //     $ajz = $row['reading'];
            //     $late -= $ajz;
            // }

            // else if ($isPlus != 'set' && ((float)$row['reading'] < 5)){
            //     echo "<td class = 'reading_grade bad'>" . $row['reading_grade'] ."</td>"; 
            //     $ajz = $row['reading'] -5;
            //     $late -= $ajz;
            // }
            // else if ($isPlus != 'set' && ((float)$row['reading'] == 5)){
            //     echo "<td class = 'reading_grade'>" . $row['reading_grade'] ."</td>"; 
            // }


            echo "<td class>" .$row['reading'] ."</td>";
            echo "<td class = 'date'>" .$row['date'] ."</td>";


            echo '</tr>';
        }
        echo "<div style='font-weight:bold; text-align:center'>";
        
        // echo "<div class='ajz'>";
        // if ($late>0 && $late < 20){
        //     echo
        //         '<p class="late"> ' .$late .' :مقدار العجز  </p>';
        // }
        // else if ($late>=20){
        //     $helperDiv = '<div class="helpermessage">لديك عجز عالي، استعن بالله ولا تعجز</div>';
        //     echo
        //         '<p class="biglate"> '.$late. ' :مقدار العجز  </p>';
        // }
        // else{
        //     $late=0;
        //     echo
        //         '<p class="nolate"> '.$late. ' :مقدار العجز  </p>';
        // }

        echo '
            <p>احصائيات القراءة</p>
        </div>';
        // if(isset($helperDiv)){
        //     echo $helperDiv;
        // }

    ?>



</table>
