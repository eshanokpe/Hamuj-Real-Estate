@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <div class="sidebar-header text-center mb-4">
                    <h4 class="text-primary">Tutor Dashboard</h4>
                    <hr>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tutor.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tutor.profile') }}">
                            <i class="fas fa-user me-2"></i>
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tutor.sessions') }}">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Sessions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tutor.students') }}">
                            <i class="fas fa-users me-2"></i>
                            My Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tutor.earnings') }}">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            Earnings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tutor.settings') }}">
                            <i class="fas fa-cog me-2"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Welcome, {{ Auth::user()->name }}! 👋</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar"></span>
                        This week
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Students</h6>
                                    <h2 class="mb-0">24</h2>
                                </div>
                                <i class="fas fa-users fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Upcoming Sessions</h6>
                                    <h2 class="mb-0">8</h2>
                                </div>
                                <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Earnings</h6>
                                    <h2 class="mb-0">$1,250</h2>
                                </div>
                                <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Rating</h6>
                                    <h2 class="mb-0">4.8</h2>
                                </div>
                                <i class="fas fa-star fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent Sessions</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>John Smith</td>
                                            <td>Mathematics</td>
                                            <td>Today</td>
                                            <td>3:00 PM</td>
                                            <td><span class="badge bg-success">Confirmed</span></td>
                                        </tr>
                                        <tr>
                                            <td>Sarah Johnson</td>
                                            <td>Physics</td>
                                            <td>Tomorrow</td>
                                            <td>10:00 AM</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>Mike Davis</td>
                                            <td>Chemistry</td>
                                            <td>Dec 15</td>
                                            <td>2:00 PM</td>
                                            <td><span class="badge bg-info">Scheduled</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('tutor.sessions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i> Schedule Session
                                </a>
                                <a href="{{ route('tutor.profile.edit') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i> Edit Profile
                                </a>
                                <a href="{{ route('tutor.availability') }}" class="btn btn-outline-success">
                                    <i class="fas fa-clock me-2"></i> Set Availability
                                </a>
                                <a href="{{ route('tutor.messages') }}" class="btn btn-outline-info">
                                    <i class="fas fa-envelope me-2"></i> View Messages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .sidebar {
        min-height: calc(100vh - 56px);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    .sidebar .nav-link {
        color: #333;
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        margin-bottom: 0.25rem;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .sidebar .nav-link.active {
        background-color: #293567;
        color: white;
    }

    .sidebar-header {
        padding: 1rem 1rem 0;
    }

    [data-feather] {
        width: 16px;
        height: 16px;
        vertical-align: text-bottom;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endsection