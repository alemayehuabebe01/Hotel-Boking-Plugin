<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 5px;
            border-radius: 5px;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .card-booking {
            border-left: 4px solid var(--primary-color);
            transition: transform 0.3s;
        }
        
        .card-booking:hover {
            transform: translateY(-5px);
        }
        
        .stat-card {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .stat-card .icon {
            font-size: 2.5rem;
            opacity: 0.3;
        }
        
        .booking-status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .bg-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .bg-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .bg-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- <div class="col-md-3 col-lg-2 d-md-block sidebar px-0 bg-primary">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4 mt-2">
                        <h4><i class="fas fa-hotel me-2"></i>HotelPro</h4>
                    </div>
                    <ul class="nav flex-column px-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-calendar-check"></i> Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bed"></i> Rooms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i> Guests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div> -->

            <!-- Main Content -->
            <main class="col-md-12 col-lg-12 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Today</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Week</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Month</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i> New Booking
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Bookings</h6>
                                        <h2 class="mb-0">124</h2>
                                    </div>
                                    <i class="fas fa-calendar-alt icon"></i>
                                </div>
                                <p class="small mb-0"><i class="fas fa-arrow-up me-1"></i> 12% from last month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Occupancy Rate</h6>
                                        <h2 class="mb-0">78%</h2>
                                    </div>
                                    <i class="fas fa-chart-pie icon"></i>
                                </div>
                                <p class="small mb-0"><i class="fas fa-arrow-up me-1"></i> 5% from last week</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-warning text-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Pending</h6>
                                        <h2 class="mb-0">8</h2>
                                    </div>
                                    <i class="fas fa-clock icon"></i>
                                </div>
                                <p class="small mb-0"><i class="fas fa-arrow-down me-1"></i> 2 from yesterday</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Cancelled</h6>
                                        <h2 class="mb-0">5</h2>
                                    </div>
                                    <i class="fas fa-times-circle icon"></i>
                                </div>
                                <p class="small mb-0"><i class="fas fa-arrow-down me-1"></i> 1 from last week</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings and Calendar -->
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Bookings</h5>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Booking ID</th>
                                                <th>Guest</th>
                                                <th>Room</th>
                                                <th>Check-In</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#HB-1254</td>
                                                <td>John Smith</td>
                                                <td>Deluxe Suite</td>
                                                <td>May 15, 2023</td>
                                                <td><span class="booking-status-badge bg-confirmed">Confirmed</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#HB-1253</td>
                                                <td>Sarah Johnson</td>
                                                <td>Executive Room</td>
                                                <td>May 14, 2023</td>
                                                <td><span class="booking-status-badge bg-confirmed">Confirmed</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#HB-1252</td>
                                                <td>Michael Brown</td>
                                                <td>Standard Room</td>
                                                <td>May 12, 2023</td>
                                                <td><span class="booking-status-badge bg-pending">Pending</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#HB-1251</td>
                                                <td>Emily Davis</td>
                                                <td>Family Suite</td>
                                                <td>May 10, 2023</td>
                                                <td><span class="booking-status-badge bg-cancelled">Cancelled</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#HB-1250</td>
                                                <td>Robert Wilson</td>
                                                <td>Deluxe Suite</td>
                                                <td>May 8, 2023</td>
                                                <td><span class="booking-status-badge bg-confirmed">Confirmed</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Upcoming Check-Ins</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">#HB-1254 - John Smith</h6>
                                            <small>Today</small>
                                        </div>
                                        <p class="mb-1">Deluxe Suite - 2 nights</p>
                                        <small>Check-in: 3:00 PM</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">#HB-1256 - Lisa Wong</h6>
                                            <small>Tomorrow</small>
                                        </div>
                                        <p class="mb-1">Executive Room - 3 nights</p>
                                        <small>Check-in: 2:00 PM</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">#HB-1257 - David Kim</h6>
                                            <small>May 16</small>
                                        </div>
                                        <p class="mb-1">Family Suite - 5 nights</p>
                                        <small>Check-in: 4:00 PM</small>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-plus me-2"></i> New Booking
                                    </button>
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-bed me-2"></i> Manage Rooms
                                    </button>
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-users me-2"></i> Guest List
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>