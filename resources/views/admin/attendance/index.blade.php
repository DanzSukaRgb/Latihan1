@extends('layouts.app')

@section('title', 'Admin - Daftar Absensi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Absensi Karyawan</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Data Absensi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->user->name }}</td>
                                <td>{{ $attendance->date->format('d M Y') }}</td>
                                <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}</td>
                                <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') : '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $attendance->status === 'hadir' ? 'success' : ($attendance->status === 'izin' ? 'info' : 'warning') }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td>{{ $attendance->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data absensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
