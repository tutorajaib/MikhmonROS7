<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {

  $getprofile = $API->comm("/ppp/profile/print");
  $srvlist = $API->comm("/ip/hotspot/print");

  if (isset($_POST['name'])) {
    $server = ($_POST['server']);
    $name = ($_POST['name']);
    $password = ($_POST['pass']);
    $profile = ($_POST['profile']);
    $disabled = ($_POST['disabled']);
    $timelimit = ($_POST['timelimit']);
    $datalimit = ($_POST['datalimit']);
    $comment = ($_POST['comment']);
    $chkvalid = ($_POST['valid']);
    $mbgb = ($_POST['mbgb']);
    if ($timelimit == "") {
      $timelimit = "0";
    } else {
      $timelimit = $timelimit;
    }
    if ($datalimit == "") {
      $datalimit = "0";
    } else {
      $datalimit = $datalimit * $mbgb;
    }
    if ($name == $password) {
      $usermode = "vc-";
    }else{
      $usermode = "up-";
    }
    
      $comment = $usermode.$comment;
    
    $API->comm("/ppp/secret/add", array(
      "name" => "$name",
      "password" => "$password",
      "profile" => "$profile",
      "disabled" => "no",
      "comment" => "$comment",
    ));
    $getuser = $API->comm("/ppp/secret/print", array(
      "?name" => "$name",
    ));
    $uid = $getuser[0]['.id'];
    echo "<script>window.location='./?ppp=" . $uid . "&session=" . $session . "'</script>";
  }
}
?>
<div class="row">
<div class="col-8">
<div class="card box-bordered">
  <div class="card-header">
    <h3><i class="fa fa-user-plus"></i> Add PPP Secret <small id="loader" style="display: none;"><i class='fa fa-circle-o-notch fa-spin'></i> Processing </i></small></h3>
  </div>
  <div class="card-body">
<form autocomplete="off" method="post" action="">  
  <div>
    <a class='btn bg-warning' href='./?ppp=secrets&session=<?= $session; ?>'> <i class='fa fa-close'></i> Close</a>
    <button type="submit" onclick="loader()" class="btn bg-primary" name="save"><i class="fa fa-save"></i> Save</button>
  </div>

<table class="table">
  <tr>
    <td class="align-middle">Username</td><td><input class="form-control" type="text" autocomplete="off" name="name" required autofocus></td>
  </tr>
  <tr>
    <td class="align-middle">Password</td><td>
        <div class="input-group">
          <div class="input-group-11 col-box-10">
            <input class="group-item group-item-l" id="passUser" type="password" name="pass" autocomplete="new-password" required>
          </div>
          <div class="input-group-1 col-box-2">
            <div class="group-item group-item-r pd-2p5 text-center">
              <input title="Show/Hide Password" type="checkbox" onclick="PassUser()">
            </div>
          </div>
        </div>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Service</td><td>
      <select class="form-control" name="service" required>
        <option value="pppoe">PPPoE</option>
        <option value="pptp">PPTP</option>
        <option value="l2tp">L2TP</option>
        <option value="ovpn">OVPN</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Profile</td><td>
      <select class="form-control" name="profile" required>
        <?php foreach ($getprofile as $profile) { echo "<option value='" . $profile['name'] . "'>" . $profile['name'] . "</option>"; } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Remote Address</td><td><input class="form-control" type="text" name="remote_address"></td>
  </tr>
  <tr>
    <td class="align-middle">Comment</td><td><input class="form-control" type="text" name="comment"></td>
  </tr>
</table>
</form>
</div>
</div>
</div>
</div>

<script>
  function PassUser() {
    var x = document.getElementById('passUser');
    x.type = (x.type === 'password') ? 'text' : 'password';
  }
</script>
