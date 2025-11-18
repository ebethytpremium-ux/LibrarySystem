<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Library Members</title>
<style>
body { font-family: Arial, sans-serif; background:#e3f2fd; margin:0; padding:0; }
.navbar { width:100%; background:#1565c0; color:white; padding:14px 20px; display:flex; justify-content:space-between; align-items:center; }
.nav-left { font-size:20px; font-weight:bold; }
.nav-item { cursor:pointer; padding:6px 10px; border-radius:4px; }
.nav-item:hover { background:#0d47a1; }
.container { width:95%; max-width:800px; background:white; padding:20px; margin:20px auto; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.05); }
table { width:100%; border-collapse:collapse; margin-top:15px; }
th, td { border:1px solid #ccc; padding:8px; text-align:center; }
th { background:#1976d2; color:white; }
</style>
</head>
<body>

<div class="navbar">
<div class="nav-left">🏛 Library Members</div>
<div class="nav-item" onclick="window.location.href='dashboard.html'">Dashboard</div>
<div class="nav-item" onclick="logout()">Logout</div>
</div>

<div class="container">
<h3>Registered Members</h3>
<table>
<thead><tr><th>#</th><th>Name</th><th>Occupation</th><th>Telephone</th><th>QR Code</th></tr></thead>
<tbody id="membersTable"></tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
let userId = localStorage.getItem("userId");
if(!userId) window.location.href="index.html";

function logout(){ localStorage.removeItem("loggedInUser"); localStorage.removeItem("userId"); window.location.href="index.html"; }

fetch(`api.php?action=getLibraryMembers`)
.then(res=>res.json())
.then(data=>{
    let tbody=document.getElementById("membersTable");
    tbody.innerHTML="";
    data.forEach((m,i)=>{
        tbody.innerHTML+=`<tr>
        <td>${i+1}</td>
        <td>${m.name}</td>
        <td>${m.occupation}</td>
        <td>${m.telephone}</td>
        <td><canvas id="qr${i}" width="80" height="80"></canvas></td>
        </tr>`;
        QRCode.toCanvas(document.getElementById(`qr${i}`), m.qr_code);
    });
});
</script>

</body>
</html>
