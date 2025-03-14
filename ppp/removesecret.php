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
// Hide all error
error_reporting(0);

if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
    exit;
}

if (isset($removesecr) && !empty($removesecr)) {
    $uids = explode("~", $removesecr);
    foreach ($uids as $id) {
        $API->comm("/ppp/secret/remove", array(
            ".id" => $id,
        ));
    }
    echo "<script>window.location='./?ppp=secrets&session=" . $session . "'</script>";
} elseif (isset($removesecr) && !empty($removesecr)) {
    $API->comm("/ppp/secret/remove", array(
        ".id" => $removesecr,
    ));
    echo "<script>window.location='./?ppp=secrets&session=" . $session . "'</script>";
} else {
    echo "<script>alert('No PPP Secret selected for removal.'); window.history.back();</script>";
}
?>
