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
    <h3><i class="fa fa-id-card"></i> MAP Pelanggan
      <span style="font-size: 14px">
        <?php if ($TotalProfiles == 0) {
          echo "<script>window.location='./?ppp=profiles&session=" . $session . "'</script>";
        } ?>
         &nbsp; | &nbsp; <a href="./?ppp=addprofile&session=<?= $session; ?>" title="Add Profile"><i class="fa fa-plus-circle"></i> Add</a>
      </span>
    </h3>
</div>
<div class="card-body">
    Halaman Map Advance Dengan Map Tile Google
    
<input type="text" id="lokasi"></input>
<div class="overflow mr-t-10 box-bordered" style="max-height: 75vh">
    
<div id="map"></div>

<?php
include_once('./leaflet.php');

?>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.js"></script>
    <script>
        var map = L.map('map', { preferCanvas: true }).setView([-6.200000, 106.816666], 13);

        // Tambahkan tile layer
        L.tileLayer('https://map.tkjsakti.my.id/map.php?lyrs=s&x={x}&y={y}&z={z}', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan fitur fullscreen (PERBAIKAN)
        L.control.fullscreen().addTo(map);

        var marker;
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('lokasi').value = e.latlng.lat + ',' + e.latlng.lng;
        });

        // Fungsi untuk mendapatkan lokasi pengguna
        document.getElementById("btn-lokasi").addEventListener("click", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    // Setel tampilan peta ke lokasi pengguna
                    map.setView([userLat, userLng], 17);

                    // Tambahkan marker di lokasi pengguna
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    marker = L.marker([userLat, userLng]).addTo(map)
                        .bindPopup("Lokasi Anda").openPopup();

                    // Masukkan koordinat ke dalam input lokasi
                    document.getElementById('lokasi').value = userLat + ',' + userLng;
                }, function(error) {
                    alert("Gagal mendapatkan lokasi. Pastikan GPS aktif.");
                });
            } else {
                alert("Browser Anda tidak mendukung geolokasi.");
            }
        });
    </script>
</table>
</div>
</div>
</div>
</div>
</div>
