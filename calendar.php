<?php
    $link = mysql_connect('localhost', 'root', '173965') or die('Could not connect: ' . mysql_error());
    mysql_select_db('calendary') or die('Could not select database!');
?>

<html>
    <head>
        <title>PHP Calendar</title>
    <script>
    
    function goPreviousMonth(month, year) {
        if(month == 1) {
            --year;
            month = 13;
        }
        --month
        
        var monthstring = ""+month+"";
        var monthlength = monthstring.length;
        
        if(monthlength <= 1) {
            monthstring = "0" + monthstring;
        }
        
        document.location.href ="<?php $_SERVER['PHP_SELF'];?>?month="+monthstring+"&year="+year;
    }
    
    function goNextMonth(month, year) {
        if(month == 12) {
            ++year;
            month = 0;
        }
        ++month
        
        var monthstring = ""+month+"";
        var monthlength = monthstring.length;
        
        if(monthlength <= 1){
            monthstring = "0" + monthstring;
        }
        
        document.location.href ="<?php $_SERVER['PHP_SELF'];?>?month="+monthstring+"&year="+year;
    }
    </script>
    
    <style>
    .today {
        background-color:#E9967A;
    }
    
    .event {
        background-color:#DDA0DD;
    }
    
    </style>
    </head>
    
    <body>
    <?php
      	include 'header.php';
        echo "<br>";
        
	if(isset($_GET['day'])) {
            $day = $_GET['day'];
        } 
        else {
            $day = date("j");
        }
        
        if(isset($_GET['month'])) {
            $month = $_GET['month'];
        }
        else {
            $month = date("n");
        }
        
        if(isset($_GET['year'])) {
            $year = $_GET['year'];
        }
        else {
            $year = date("Y");
        }
        
        $currentTimeStamp = strtotime("$day-$month-$year");
        $monthName = strtoupper(date("F", $currentTimeStamp));
        $numDays = date("t", $currentTimeStamp);
        $counter = 0;
    ?>
    
    <?php
        if(isset($_GET['add'])) {
            $title =$_POST['txttitle'];
	    $timestart =$_POST['txttimestart'];
            $timeend =$_POST['txttimeend'];
	    $location =$_POST['txtlocation'];
            $details =$_POST['txtdetails'];
	    $eventdate = $day."/".$month."/".$year;
            $sqlinsert = "INSERT INTO eventcal(Title, timeStart, timeEnd, Location, Details, eventDate) VALUES ('".$title."','".$timestart."','".$timeend."','".$location."','".$details."','".$eventdate."')";
            $resultinginsert = mysql_query($sqlinsert);
            
            if($resultinginsert ) {
                echo "Event was successfully Added...<br>";   
            }
            else {
                echo "Event Failed to be Added....<br>";
            }
        }
    ?>
    
    <table align="center" border='1'>
        <tr>
            <td><input style ='width:50px;' type ='button' value ='<'name ='previousbutton' onclick ="goPreviousMonth(<?php echo $month.",".$year?>)"></td>
            <td colspan='5'><?php echo $monthName.", ".$year; ?></td>
            <td><input style ='width:50px;' type ='button' value ='>'name ='nextbutton' onclick ="goNextMonth(<?php echo $month.",".$year?>)"></td>
        </tr>
        <tr>
            <td width ='50px'>Sun</td>
            <td width ='50px'>Mon</td>
            <td width ='50px'>Tue</td>
            <td width ='50px'>Wed</td>
            <td width ='50px'>Thu</td>
            <td width ='50px'>Fri</td>
            <td width ='50px'>Sat</td>
        </tr>
        
    <?php
        echo "<tr>";
        
        for($i = 1; $i < $numDays+1; $i++, $counter++) {
            $timeStamp = strtotime("$year-$month-$i");
            
            if($i == 1) {
                $firstDay = date("w", $timeStamp);
                
                for($j = 0; $j < $firstDay; $j++, $counter++) {
                    echo "<td>&nbsp;</td>";
                }
            }
            
            if($counter % 7 == 0) {
                echo"</tr><tr>";
            }
            
            $monthstring = $month;
            $monthlength = strlen($monthstring);
            $daystring = $i;
            $daylength = strlen($daystring);
            
            if($monthlength <= 1) {
                $monthstring = "0".$monthstring;
            }
            
            if($daylength <=1) {
                $daystring = "0".$daystring;
            }
            
            $todaysDate = date("d/m/Y");
            $dateToCompare = $daystring. '/' . $monthstring. '/' . $year;
            
            echo "<td align='center' ";
            
            if ($todaysDate == $dateToCompare) {
                echo "class ='today'";
            } 
            else {
                $sqlCount = "SELECT * FROM eventcal WHERE eventDate='".$dateToCompare."'";
                $noOfEvent = mysql_num_rows(mysql_query($sqlCount));
                
                if($noOfEvent >= 1) {
                    echo "class='event'";
                }
            }
            
            echo "><a href='".$_SERVER['PHP_SELF']."?day=".$daystring."&month=".$monthstring."&year=".$year."&v=true'>".$i."</a></td>";
        }
        
        echo "</tr>";
    ?>
    </table>
    
    <?php
        if(isset($_GET['v'])) {
            echo "<br>";
            echo "<hr>";
            echo "<a href='".$_SERVER['PHP_SELF']."?day=".$day."&month=".$month."&year=".$year."&v=true&f=true'>Add Event</a>";
            
            if(isset($_GET['f'])) {
                include("events.php");
            }
            
            $sqlEvent = "SELECT * FROM eventcal WHERE eventDate='".$day."/".$month."/".$year."'";
            $resultEvents = mysql_query($sqlEvent);
            
            echo "<hr>";
            echo "<br>";
	    echo "Events on ".$day." ".ucfirst(strtolower($monthName))." ".$year."<br><br>";

            while ($events = mysql_fetch_array($resultEvents)) {
                
                echo "Title: ".$events['Title']."<br>";
		echo "Time-Start: ".$events['timeStart']."<br>";
        	echo "Time-End: ".$events['timeEnd']."<br>";
		echo "Location: ".$events['Location']."<br>";
                echo "Desciption: ".$events['Details']."<br>";
                echo "<br>";
            }
        }
    ?>
    </body>
</html> 
