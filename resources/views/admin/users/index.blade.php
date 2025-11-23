<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - Smart Parking System</title>
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
            text-align: center;
        }
        .stat-card h3 { font-size: 2rem; font-weight: bold; margin: 10px 0; }
        .stat-card p { margin: 0; opacity: 0.9; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="header-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-people-fill me-2" style="color: #667eea;"></i>
                        Users Management
                    </h2>
                    <p class="text-muted mb-0">Manage all registered users and their accounts</p>
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
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-people display-5"></i>
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);">
                    <i class="bi bi-person-fill display-5"></i>
                    <h3>{{ $stats['drivers'] }}</h3>
                    <p>Drivers</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="bi bi-shield-fill-check display-5"></i>
                    <h3>{{ $stats['admins'] }}</h3>
                    <p>Administrators</p>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search and Filters -->
        <div class="card-custom">
            <div class="card-body">
                <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Search & Filter</h5>
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control">
                            <option value="">All Roles</option>
                            <option value="Driver" {{ request('role') == 'Driver' ? 'selected' : '' }}>Driver</option>
                            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary-custom me-2">
                            <i class="bi bi-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card-custom">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="bi bi-hash me-2"></i>ID</th>
                                <th><i class="bi bi-person me-2"></i>User</th>
                                <th><i class="bi bi-envelope me-2"></i>Email</th>
                                <th><i class="bi bi-phone me-2"></i>Phone</th>
                                <th><i class="bi bi-shield me-2"></i>Role</th>
                                <th><i class="bi bi-calendar me-2"></i>Registered</th>
                                <th><i class="bi bi-car-front me-2"></i>Vehicles</th>
                                <th><i class="bi bi-gear me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="fw-bold">#{{ $user->userID }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2">
                                            {{ strtoupper(substr($user->fullName, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->fullName }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phoneNumber ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role == 'Admin' ? 'danger' : 'primary' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>{{ $user->dateRegistered ? \Carbon\Carbon::parse($user->dateRegistered)->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $user->vehicles->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->userID) }}" 
                                       class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($user->userID != auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->userID) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Delete user {{ $user->fullName }}?')"
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-inbox display-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted">No users found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->count() > 0)
            <div class="card-footer bg-light">
                <small class="text-muted">Showing {{ $users->count() }} users</small>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
