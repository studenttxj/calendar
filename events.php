<form name='events' method='POST' action="<?php $_SERVER['PHP_SELF']; ?>?month=<?php echo $month;?>&day=<?php echo $day;?>&year=<?php echo $year; ?>&v=true&add=true">

    <br>
    <table width='400px' border='0'>
        <tr>
            <td width='150px'>Title: </td>
            <td width='250px'><input type='text' name='txttitle'</td>
        </tr>
	<tr>
            <td width='150px'>Time-Start: </td>
            <td width='250px'><input type='text' name='txttimestart'</td>
        </tr>
	<tr>
            <td width='150px'>Time-End: </td>
            <td width='250px'><input type='text' name='txttimeend'</td>
        </tr>
	<tr>
            <td width='150px'>Location: </td>
            <td width='250px'><input type='text' name='txtlocation'</td>
        </tr>
        <tr>
            <td width='150px'>Description: </td>
            <td width='250px'><textarea rows="10" cols="40" name='txtdetails'></textarea></td>
        </tr>
        <tr>
            <td colspan='2' align='center'><input type='submit' name='btnadd' value='Submit'></td>
        </tr>
        </table>
</form>
