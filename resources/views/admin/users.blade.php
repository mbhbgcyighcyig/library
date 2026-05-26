@extends('layouts.admin')

@section('title', 'Pengguna - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Data Pengguna</h1>
</div>

<div class="card-box">
    <div class="card-title">Daftar Pengguna ({{ $users->count() }} pengguna)</div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $user->name }}</td>
                <td>{{ $user->username ?? '-' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td><span class="badge-green">User</span></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#aaa;padding:30px;">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
