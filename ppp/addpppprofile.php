<?php
session_start();
error_reporting(0);

if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {

  $getallsecrets = $API->comm("/ppp/secret/print");
  $getprofiles = $API->comm("/ppp/profile/print");

  if (isset($_POST['name'])) {
    $name = preg_replace('/\s+/', '-', $_POST['name']);
    $localaddress = $_POST['localaddress'];
    $remoteaddress = $_POST['remoteaddress'];
    $rate_limit = $_POST['ratelimit'];
    $dns_servers = $_POST['dns_servers'];
    $price = $_POST['price'] ?: "0";
    $sprice = $_POST['sprice'] ?: "0";
    
$response = $API->comm("/ppp/profile/add", array(
  "name" => $name,
  "remote-address" => $remoteaddress,
  "rate-limit" => $rate_limit,
  "dns-server" => $dns_servers,
  "comment" => "Price: $price, Selling Price: $sprice"
));

print_r($response);

   // echo "<script>window.location='./?ppp=profiles&session=" . $session . "'</script>";
   
  }
}
?>
<div class="row">
<div class="col-8">
<div class="card box-bordered">
  <div class="card-header">
    <h3><i class="fa fa-plus"></i> Add PPP Profile <small id="loader" style="display: none;"><i><i class='fa fa-circle-o-notch fa-spin'></i> Processing...</i></small></h3>
  </div>
  <div class="card-body">
<form method="post" action="">
  <div>
    <a class="btn bg-warning" href="./?ppp=profiles&session=<?= $session; ?>"> <i class="fa fa-close btn-mrg"></i> Close</a>
    <button type="submit" name="save" class="btn bg-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Save</button>
  </div>
<table class="table">
  <tr>
    <td class="align-middle">Profile Name</td><td><input class="form-control" type="text" name="name" required autofocus></td>
  </tr>
  <tr>
    <td class="align-middle">Local Address</td>
    <td><input class="form-control" type="text" name="localaddress" ></td>
  </tr>
  <tr>
    <td class="align-middle">Remote Address</td>
    <td><input class="form-control" type="text" name="remoteaddress" ></td>
  </tr>
  <tr>
    <td class="align-middle">Rate Limit (up/down)</td>
    <td><input class="form-control" type="text" name="ratelimit" placeholder="Example: 512k/1M"></td>
  </tr>
  <tr>
    <td class="align-middle">DNS Servers</td>
    <td><input class="form-control" type="text" name="dns_servers"></td>
  </tr>
  <tr>
    <td class="align-middle">Price</td>
    <td><input class="form-control" type="text" name="price"></td>
  </tr>
  <tr>
    <td class="align-middle">Selling Price</td>
    <td><input class="form-control" type="text" name="sprice"></td>
  </tr>
</table>
</form>
</div>
</div>
</div>
</div>
