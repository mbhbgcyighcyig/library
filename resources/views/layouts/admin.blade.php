<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<title>@yield('title','Admin - Bookify')</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
background:#f5f5f5;
font-family:'Inter',sans-serif;
min-height:100vh;
overflow-x:hidden;
color:#1f2e5a;
}

.dash-wrap{
display:flex;
min-height:100vh;
}



/* ================= SIDEBAR ================= */

.sidebar{
width:240px;
background:#A8CAD7;
padding:25px 15px;
border-radius:0 35px 35px 0;
display:flex;
flex-direction:column;
min-height:100vh;
}

.sidebar-logo{
display:flex;
justify-content:center;
margin-bottom:55px;
}

.logo-circle{
width:60px;
height:60px;
border-radius:50%;
background:#1f2e5a;
display:flex;
align-items:center;
justify-content:center;
font-size:30px;
font-weight:bold;
color:white;
font-family:'DM Serif Display',serif;
}


.nav-item{
display:flex;
align-items:center;
gap:15px;
padding:15px;
margin-bottom:10px;
text-decoration:none;
color:white;
font-size:16px;
border-radius:12px;
transition:.3s;
}

.nav-item i{
width:25px;
font-size:18px;
}

.nav-item:hover{
background:#B9DDBB;
padding-left:22px;
}

.nav-item.active{
background:#B9DDBB;
}


.nav-logout{
margin-top:auto;
padding-top:50px;
}

.nav-logout button{
background:none;
border:none;
color:white;
display:flex;
align-items:center;
gap:15px;
font-size:17px;
cursor:pointer;
padding:15px;
font-family:'Inter';
}



/* ================= MAIN ================= */

.main-content{
flex:1;
padding:30px;
background:#f8f8f8;
}



/* ================= TOPBAR ================= */

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

.search-wrap{
position:relative;
width:420px;
}

.search-wrap i{
position:absolute;
left:15px;
top:50%;
transform:translateY(-50%);
color:#444;
}

.search-wrap input{
width:100%;
height:45px;
border-radius:8px;
border:1px solid #888;
padding-left:45px;
background:white;
font-size:15px;
outline:none;
}


.topbar-right{
display:flex;
align-items:center;
gap:12px;
font-size:18px;
}

.topbar-avatar{

width:45px;
height:45px;
border-radius:50%;
background:#ddd;

display:flex;
justify-content:center;
align-items:center;
font-weight:bold;
}


/* ================= HEADER ================= */

.page-header{
text-align:center;
margin-bottom:35px;
}

.page-header h1{
font-family:'DM Serif Display',serif;
font-size:42px;
color:#173B67;
}

.page-subtitle{
display:none;
}



/* ================= CARD STAT ================= */

.stats-row{

display:flex;
justify-content:center;
gap:30px;
margin-bottom:35px;
}

.stat-card{

width:240px;
background:#B9DDBB;
padding:15px;
border-radius:15px;
border:1px solid #777;
text-align:center;
}

.stat-label{

font-size:18px!important;
font-family:'DM Serif Display',serif;
color:black!important;

text-transform:none!important;
letter-spacing:0!important;
margin-bottom:5px;
}

.stat-num{

font-size:34px!important;
font-weight:bold;
color:#173B67!important;

}



/* ================= CARD ================= */

.card-box{

background:white;
border-radius:18px;
border:1px solid #888;
padding:20px;
margin-bottom:20px;
box-shadow:none;

}

.card-title{

font-size:28px;
font-family:'DM Serif Display',serif;
margin-bottom:20px;

}



/* ================= TABLE ================= */

.tbl{

width:100%;
border-collapse:separate;
border-spacing:0 10px;

}

.tbl thead{
display:none;
}

.tbl td{

background:white;
padding:14px;
border:1px solid #ddd;
font-size:14px;
border-bottom:none;
}


.tbl td:first-child{
border-radius:10px 0 0 10px;
}

.tbl td:last-child{
border-radius:0 10px 10px 0;
}


/* ================= BADGE ================= */


.badge-green,
.badge-yellow,
.badge-red,
.badge-blue,
.badge-gray{

background:#B9DDBB;
color:#2f5c31;

padding:6px 14px;
border-radius:30px;
font-size:12px;
font-weight:500;

}



/* ================= BUTTON ================= */

.btn-primary{

background:#173B67;
color:white;
border:none;
padding:10px 20px;
border-radius:8px;
cursor:pointer;
}


.btn-success{

background:#B9DDBB;
color:black;
border:none;
padding:10px 20px;
border-radius:8px;
cursor:pointer;
}


.btn-danger{

background:#ff6b6b;
color:white;
border:none;
padding:10px 20px;
border-radius:8px;
cursor:pointer;
}

.btn-secondary{

background:#A8CAD7;
color:#173B67;
border:none;
padding:10px 20px;
border-radius:8px;
text-decoration:none;
}



/* ================= FORM ================= */

.form-field{

width:100%;
padding:12px;
border-radius:8px;
border:1px solid #bbb;
outline:none;
}



/* ================= ALERT ================= */

.alert-success{

background:#B9DDBB;
padding:15px;
border-radius:10px;
margin-bottom:15px;
}


.alert-error{

background:#ffd3d3;
padding:15px;
border-radius:10px;
margin-bottom:15px;
}



/* ================= GRID ================= */

.grid-2{

display:grid;
grid-template-columns:1fr 1fr;
gap:20px;

}



/* ================= MOBILE ================= */

@media(max-width:900px){

.sidebar{
width:95px;
}

.nav-item{
justify-content:center;
}

.nav-item span{
display:none;
}

.stats-row{
flex-direction:column;
}

.grid-2{
grid-template-columns:1fr;
}

.search-wrap{
width:100%;
}

}

</style>

@stack('styles')
</head>

<body>

<div class="dash-wrap">

<div class="sidebar">

<div class="sidebar-logo">
<div class="logo-circle">B</div>
</div>


<a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active':'' }}">
<i class="fas fa-th-large"></i>
<span>Dashboard</span>
</a>


<a href="{{ route('admin.books') }}" class="nav-item {{ request()->routeIs('admin.books*') ? 'active':'' }}">
<i class="fas fa-folder-open"></i>
<span>Data Buku</span>
</a>


<a href="{{ route('admin.borrows') }}" class="nav-item {{ request()->routeIs('admin.borrows*') ? 'active':'' }}">
<i class="fas fa-arrow-right-arrow-left"></i>
<span>Peminjaman & Pengembalian</span>
</a>


<a href="{{ route('admin.reports.books') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active':'' }}">
<i class="fas fa-chart-simple"></i>
<span>Generate Laporan</span>
</a>


<a href="{{ route('admin.categories') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active':'' }}">
<i class="fas fa-tags"></i>
<span>Kategori</span>
</a>


<a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active':'' }}">
<i class="fas fa-users"></i>
<span>Pengguna</span>
</a>


<a href="{{ route('admin.staff') }}" class="nav-item {{ request()->routeIs('admin.staff') ? 'active':'' }}">
<i class="fas fa-user-tie"></i>
<span>Petugas</span>
</a>


<a href="{{ route('admin.reviews') }}" class="nav-item {{ request()->routeIs('admin.reviews') ? 'active':'' }}">
<i class="fas fa-star"></i>
<span>Ulasan</span>
</a>



<div class="nav-logout">

<form action="{{ route('logout') }}" method="POST">

@csrf

<button type="submit">
<i class="fas fa-right-from-bracket"></i>
Log out
</button>

</form>

</div>

</div>




<div class="main-content">

<div class="topbar">

<div class="search-wrap">

<i class="fas fa-search"></i>

<input type="text" placeholder="Search">

</div>


<div class="topbar-right">

<div class="topbar-avatar">

{{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}

</div>

<span>
{{ auth()->user()->name ?? 'Petugas' }}
</span>

</div>

</div>


@if(session('success'))

<div class="alert-success">
{{session('success')}}
</div>

@endif


@if(session('error'))

<div class="alert-error">
{{session('error')}}
</div>

@endif


@yield('content')


</div>

</div>

@stack('scripts')

</body>
</html>