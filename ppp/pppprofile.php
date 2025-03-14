<?php
// Hide all errors
error_reporting(0);
ini_set('max_execution_time', 300);

if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
} else {
    $getprofile = $API->comm("/ppp/profile/print");
    $TotalProfiles = count($getprofile);
}
?>

<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3><i class="fa fa-id-card"></i> PPP Profiles
      <span style="font-size: 14px">
        <?php if ($TotalProfiles == 0) {
          echo "<script>window.location='./?ppp=profiles&session=" . $session . "'</script>";
        } ?>
         &nbsp; | &nbsp; <a href="./?ppp=addprofile&session=<?= $session; ?>" title="Add Profile"><i class="fa fa-plus-circle"></i> Add</a>
      </span>
    </h3>
</div>
<div class="card-body">
<div class="overflow mr-t-10 box-bordered" style="max-height: 75vh">
<table id="dataTable" class="table table-bordered table-hover text-nowrap">
  <thead>
  <tr>
    <th class="align-middle text-center">#</th>
    <th>Name</th>
    <th>Local Address</th>
    <th>Remote Address</th>
    <th>Only One</th>
    <th>Rate Limit</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
<?php
for ($i = 0; $i < $TotalProfiles; $i++) {
  $profiledetails = $getprofile[$i];
  $pid = $profiledetails['.id'];
  $pname = $profiledetails['name'];
  $plocal = $profiledetails['local-address'] ?? '-';
  $premote = $profiledetails['remote-address'] ?? '-';
  $ponlyone = $profiledetails['only-one'] ?? '-';
  $pratelimit = $profiledetails['rate-limit'] ?? '-';

  echo "<tr>";
  echo "<td>" . ($i + 1) . "</td>";
  echo "<td>" . $pname . "</td>";
  echo "<td>" . $plocal . "</td>";
  echo "<td>" . $premote . "</td>";
  echo "<td>" . $ponlyone . "</td>";
  echo "<td>" . $pratelimit . "</td>";
  echo "<td><a href='./?remove-pppprofile=" . $pid . "&session=" . $session . "' title='Remove'><i class='fa fa-trash text-danger'></i></a></td>";
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
