<?php
include './adminheader.php';
if(isset($_GET['dbid'])) {
    $bid = $_GET['dbid'];
    mysqli_query($link, "update parking set status='available' where slot = (select slot from bookings where id='$bid')");
    mysqli_query($link, "delete from bookings where id='$bid'");
}
$result = mysqli_query($link, "select b.id,b.userid,u.name,u.regnno,u.mobile,b.slot,b.btime,b.hrs from bookings b,userregn u where b.userid=u.userid and b.status='pending'");
echo "<table class='center_tab'><thead><tr><th colspan='9' style='text-align:center;'>BOOKINGS";
echo "<tr><th>Name<th>Regn.No.<th>Mobile<th>Slot<th>Booked On<th>Booked Hours<th>Elapsed Hours<th>Status<th>Task</thead>";
while($row = mysqli_fetch_row($result)) {
    echo "<tr>";
    $ct = time()+19800;
    $booktime = date('Y-m-d h:i:s a',$row[6]);
    $hrs = round(($ct-$row[6])/3600,5);
    echo "<td>$row[2]<td>$row[3]<td>$row[4]<td>$row[5]<td>$booktime<td>$row[7]<td>$hrs";
    if($hrs>$row[7]) {
        echo "<td>Elapsed";
    } else {
        echo "<td>Valid";
    }
    echo "<td><a href='showbookings.php?dbid=$row[0]' onclick=\"javascript:return confirm('Are You Sure to Delete Record ?')\">Delete</a>";
}
echo "</table>";
mysqli_free_result($result);
include './footer.php';
?>