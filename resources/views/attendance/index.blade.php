@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Absensi Hari Ini</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Check In</h6>
                </div>
                <div class="card-body text-center">
                    @if($attendance && $attendance->check_in)
                        <h1 class="display-4 text-gray-800">
                            {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') }}
                        </h1>
                        <p class="text-success">
                            <i class="fas fa-check-circle"></i> Sudah melakukan check in
                        </p>
                        <button class="btn btn-outline-primary" disabled>
                            <i class="fas fa-fingerprint"></i> Check In
                        </button>
                    @else
                        <h1 class="display-4 text-gray-500">--:--:--</h1>
                        <p class="text-muted">Belum melakukan check in</p>
                        <form action="{{ route('attendance.checkIn') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-fingerprint"></i> Check In
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Check Out</h6>
                </div>
                <div class="card-body text-center">
                    @if($attendance && $attendance->check_out)
                        <h1 class="display-4 text-gray-800">
                            {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') }}
                        </h1>
                        <p class="text-success">
                            <i class="fas fa-check-circle"></i> Sudah melakukan check out
                        </p>
                        <button class="btn btn-outline-secondary" disabled>
                            <i class="fas fa-sign-out-alt"></i> Check Out
                        </button>
                    @elseif($attendance && $attendance->check_in)
                        <h1 class="display-4 text-gray-500">--:--:--</h1>
                        <p class="text-muted">Silahkan lakukan check out</p>
                        <form action="{{ route('attendance.checkOut') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt"></i> Check Out
                            </button>
                        </form>
                    @else
                        <h1 class="display-4 text-gray-500">--:--:--</h1>
                        <p class="text-muted">Harap check in terlebih dahulu</p>
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-sign-out-alt"></i> Check Out
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Absensi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $record)
                            <tr>
                                <td>{{ $record->date->format('d M Y') }}</td>
                                <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i:s') : '-' }}</td>
                                <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i:s') : '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $record->status === 'hadir' ? 'success' : ($record->status === 'izin' ? 'info' : 'warning') }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                                <td>{{ $record->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data absensi</td>
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
