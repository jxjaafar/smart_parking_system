<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations Management - Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container-fluid { padding: 30px; }
        .header-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .card-custom {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
        }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="header-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-calendar-check-fill me-2" style="color: #667eea;"></i>
                        Reservations Management
                    </h2>
                    <p class="text-muted mb-0">View and manage all parking reservations</p>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="bi bi-calendar-check display-5"></i>
                    <h3 class="mt-2">{{ $reservations->count() }}</h3>
                    <p class="mb-0">Total Reservations</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);">
                    <i class="bi bi-play-circle display-5"></i>
                    <h3 class="mt-2">{{ $reservations->where('reservationStatus', 'Active')->count() }}</h3>
                    <p class="mb-0">Active</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="bi bi-clock display-5"></i>
                    <h3 class="mt-2">{{ $reservations->where('paymentStatus', 'Unpaid')->count() }}</h3>
                    <p class="mb-0">Pending Payment</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                    <i class="bi bi-currency-dollar display-5"></i>
                    <h3 class="mt-2">KES {{ number_format($reservations->where('paymentStatus', 'Paid')->sum('totalCost'), 2) }}</h3>
                    <p class="mb-0">Total Revenue</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search and Filters -->
        <div class="card-custom">
            <div class="card-body">
                <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Search & Filter</h5>
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" 
                               value="{{ request('search') }}" placeholder="Search by user or slot...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-control">
                            <option value="">All Payments</option>
                            <option value="Unpaid" {{ request('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary-custom me-2">
                            <i class="bi bi-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reservations Table -->
        <div class="card-custom">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="bi bi-hash me-2"></i>ID</th>
                                <th><i class="bi bi-person me-2"></i>User</th>
                                <th><i class="bi bi-p-square me-2"></i>Slot</th>
                                <th><i class="bi bi-clock me-2"></i>Start Time</th>
                                <th><i class="bi bi-clock-history me-2"></i>Duration</th>
                                <th><i class="bi bi-currency-dollar me-2"></i>Cost</th>
                                <th><i class="bi bi-circle-fill me-2"></i>Status</th>
                                <th><i class="bi bi-credit-card me-2"></i>Payment</th>
                                <th><i class="bi bi-gear me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                            <tr>
                                <td class="fw-bold">#{{ $reservation->reservationID }}</td>
                                <td>{{ $reservation->user->fullName ?? 'N/A' }}</td>
                                <td><span class="badge bg-dark">{{ $reservation->parkingSlot->slotNumber ?? 'N/A' }}</span></td>
                                <td>{{ $reservation->startTime ? $reservation->startTime->format('M d, Y H:i') : 'N/A' }}</td>
                                <td>{{ $reservation->totalHours ? $reservation->totalHours . ' hrs' : 'Ongoing' }}</td>
                                <td class="fw-bold">KES {{ number_format($reservation->totalCost ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $reservation->reservationStatus == 'Active' ? 'success' : 
                                        ($reservation->reservationStatus == 'Completed' ? 'info' : 'danger') 
                                    }}">
                                        {{ $reservation->reservationStatus }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $reservation->paymentStatus == 'Paid' ? 'success' : 'warning'
                                    }}">
                                        {{ $reservation->paymentStatus }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.reservations.show', $reservation->reservationID) }}" 
                                       class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-inbox display-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted">No reservations found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($reservations->count() > 0)
            <div class="card-footer bg-light">
                <small class="text-muted">Showing {{ $reservations->count() }} reservations</small>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>