<?php
// Hide all errors
error_reporting(0);
ini_set('max_execution_time', 300);

if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
} else {
    $getuser = $API->comm("/ppp/secret/print");
    $TotalReg = count($getuser);

    $counttuser = $API->comm("/ppp/secret/print", array(
        "count-only" => ""
    ));

    $getprofile = $API->comm("/ppp/profile/print");
    $TotalReg2 = count($getprofile);
}
?>

<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3><i class="fa fa-users"></i> PPP Secrets
      <span style="font-size: 14px">
        <?php if ($counttuser == 0) {
          echo "<script>window.location='./?ppp=secrets&session=" . $session . "'</script>";
        } ?>
         &nbsp; | &nbsp; <a href="./?ppp=addsecret&session=<?= $session; ?>" title="Add Secret"><i class="fa fa-user-plus"></i> Add</a>
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
    <th>Password</th>
    <th>Service</th>
    <th>Profile</th>
    <th>Local Address</th>
    <th>Remote Address</th>
    <th>Comment</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
<?php
for ($i = 0; $i < $TotalReg; $i++) {
  $userdetails = $getuser[$i];
  $uid = $userdetails['.id'];
  $uname = $userdetails['name'];
  $upass = $userdetails['password'];
  $uservice = $userdetails['service'];
  $uprofile = $userdetails['profile'];
  $ulocal = $userdetails['local-address'];
  $uremote = $userdetails['remote-address'];
  $ucomment = $userdetails['comment'];

  echo "<tr>";
  echo "<td>" . ($i + 1) . "</td>";
  echo "<td>" . $uname . "</td>";
  echo "<td>" . $upass . "</td>";
  echo "<td>" . $uservice . "</td>";
  echo "<td>" . $uprofile . "</td>";
  echo "<td>" . $ulocal . "</td>";
  echo "<td>" . $uremote . "</td>";
  echo "<td>" . $ucomment . "</td>";
  echo "<td><a href='./?remove-pppsecret=" . $uid . "&session=" . $session . "' title='Remove'><i class='fa fa-trash text-danger'></i></a></td>";
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
