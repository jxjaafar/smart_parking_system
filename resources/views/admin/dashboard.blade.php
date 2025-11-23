<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-container {
            padding: 20px;
        }
        .header-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .stat-card {
            background: white;
            border: none;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }
        .icon-primary { background: #e3f2fd; color: #2196F3; }
        .icon-success { background: #e8f5e9; color: #4CAF50; }
        .icon-warning { background: #fff3e0; color: #FF9800; }
        .icon-info { background: #e1f5fe; color: #00BCD4; }
        
        .action-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .action-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            font-weight: 500;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .logout-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
        }
        .recent-reservations {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .badge-active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 6px 12px;
            border-radius: 6px;
            color: white;
        }
        .badge-completed {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            padding: 6px 12px;
            border-radius: 6px;
            color: #1e3a8a;
        }
        .badge-cancelled {
            background: #f8d7da;
            color: #842029;
            padding: 6px 12px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-speedometer2 me-2" style="color: #667eea;"></i>
                        Admin Dashboard
                    </h2>
                    <p class="text-muted mb-0">Smart Parking System Management</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <p class="mb-0 fw-bold">{{ Auth::user()->fullName }}</p>
                        <small class="text-muted">Administrator</small>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn logout-btn">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label mb-2">Total Users</p>
                                <h3 class="stat-number text-primary">{{ $stats['total_users'] }}</h3>
                                <small class="text-muted">Registered Drivers</small>
                            </div>
                            <div class="icon-wrapper icon-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('parking-slots.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label mb-2">Total Slots</p>
                                <h3 class="stat-number text-success">{{ $stats['total_slots'] }}</h3>
                                <small class="text-muted">Parking Spaces</small>
                            </div>
                            <div class="icon-wrapper icon-success">
                                <i class="bi bi-p-square-fill"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reservations.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label mb-2">Active Bookings</p>
                                <h3 class="stat-number text-warning">{{ $stats['active_reservations'] }}</h3>
                                <small class="text-muted">Current Reservations</small>
                            </div>
                            <div class="icon-wrapper icon-warning">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('parking-slots.index') }}?status=Available" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label mb-2">Available Slots</p>
                                <h3 class="stat-number text-info">{{ $stats['available_slots'] }}</h3>
                                <small class="text-muted">Ready to Book</small>
                            </div>
                            <div class="icon-wrapper icon-info">
                                <i class="bi bi-p-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="action-card">
            <h5 class="mb-4"><i class="bi bi-lightning-charge-fill me-2" style="color: #667eea;"></i>Quick Actions</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('parking-slots.index') }}" class="action-btn w-100">
                        <i class="bi bi-p-square me-2"></i>
                        Manage Parking Slots
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.reservations.index') }}" class="action-btn w-100">
                        <i class="bi bi-calendar-check me-2"></i>
                        View All Reservations
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.users.index') }}" class="action-btn w-100">
                        <i class="bi bi-people me-2"></i>
                        Manage Users
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Reservations -->
        <div class="recent-reservations">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2" style="color: #667eea;"></i>Recent Reservations</h5>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Slot</th>
                            <th>Start Time</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_reservations as $reservation)
                        <tr>
                            <td><strong>#{{ $reservation->reservationID }}</strong></td>
                            <td>{{ $reservation->user->fullName ?? 'N/A' }}</td>
                            <td><span class="badge bg-dark">{{ $reservation->parkingSlot->slotNumber ?? 'N/A' }}</span></td>
                            <td>{{ $reservation->startTime ? $reservation->startTime->format('M d, Y H:i') : 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($reservation->reservationStatus) }}">
                                    {{ $reservation->reservationStatus }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $reservation->paymentStatus == 'Paid' ? 'success' : 'warning' }}">
                                    {{ $reservation->paymentStatus }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.reservations.show', $reservation->reservationID) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                No recent reservations found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>