<?php
// Hide all errors
error_reporting(0);
ini_set('max_execution_time', 300);

if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
} else {
    // Ambil daftar user PPP Active
    $pppActive = $API->comm("/ppp/active/print");
    $TotalActive = count($pppActive);
}
?>

<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3><i class="fa fa-signal"></i> PPP Active Users
      <span style="font-size: 14px">
        <?php if ($TotalActive == 0) {
          echo "<script>window.location='./?ppp=secrets&session=" . $session . "'</script>";
        } ?>
      </span>
    </h3>
</div>
<div class="card-body">
<div class="overflow mr-t-10 box-bordered" style="max-height: 75vh">
<table id="dataTable" class="table table-bordered table-hover text-nowrap">
  <thead>
  <tr>
    <th class="align-middle text-center">#</th>
    <th>Username</th>
    <th>Service</th>
    <th>Caller ID</th>
    <th>IP Address</th>
    <th>Uptime</th>
    <th>Encoding</th>
    <th>Interface</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
<?php
for ($i = 0; $i < $TotalActive; $i++) {
  $userdetails = $pppActive[$i];
  $uid = $userdetails['.id'];
  $uname = $userdetails['name'];
  $uservice = $userdetails['service'];
  $callerid = $userdetails['caller-id'];
  $uip = $userdetails['address'];
  $uptime = $userdetails['uptime'];
  $encoding = $userdetails['encoding'];
  $interface = $userdetails['via'];

  echo "<tr>";
  echo "<td class='text-center'>" . ($i + 1) . "</td>";
  echo "<td>" . $uname . "</td>";
  echo "<td>" . strtoupper($uservice) . "</td>";
  echo "<td>" . $callerid . "</td>";
  echo "<td>" . $uip . "</td>";
  echo "<td>" . $uptime . "</td>";
  echo "<td>" . $encoding . "</td>";
  echo "<td>" . $interface . "</td>";
  echo "<td><a href='./?disconnect-pppactive=" . $uid . "&session=" . $session . "' title='Disconnect'><i class='fa fa-times-circle text-danger'></i></a></td>";
  echo "</tr>";
}
?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
