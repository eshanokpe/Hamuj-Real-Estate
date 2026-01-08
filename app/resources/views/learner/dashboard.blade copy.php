@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <div class="sidebar-header text-center mb-4">
                    <h4 class="text-success">Learner Dashboard</h4>
                    <hr>
                </div>
                 
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('learner.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('learner.profile') }}">
                            <i class="fas fa-user me-2"></i>
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('learner.sessions') }}">
                            <i class="fas fa-calendar-alt me-2"></i>
                            My Sessions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('learner.tutors') }}">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            Find Tutors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('learner.courses') }}">
                            <i class="fas fa-book me-2"></i>
                            My Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('learner.progress') }}">
                            <i class="fas fa-chart-line me-2"></i>
                            Progress
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('learner.settings') }}">
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
                <h1 class="h2">Welcome back, {{ Auth::user()->name }}! 🎓</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-success">
                        <i class="fas fa-plus me-1"></i> Book Session
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
                                    <h6 class="card-title">Active Courses</h6>
                                    <h2 class="mb-0">3</h2>
                                </div>
                                <i class="fas fa-book fa-2x opacity-50"></i>
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
                                    <h2 class="mb-0">5</h2>
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
                                    <h6 class="card-title">Tutors</h6>
                                    <h2 class="mb-0">2</h2>
                                </div>
                                <i class="fas fa-chalkboard-teacher fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Study Hours</h6>
                                    <h2 class="mb-0">48</h2>
                                </div>
                                <i class="fas fa-clock fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Today's Schedule</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Subject</th>
                                            <th>Tutor</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>10:00 AM</td>
                                            <td>Mathematics</td>
                                            <td>Dr. Smith</td>
                                            <td>60 min</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-success">
                                                    <i class="fas fa-video me-1"></i> Join
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2:00 PM</td>
                                            <td>Physics</td>
                                            <td>Prof. Johnson</td>
                                            <td>90 min</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-info-circle me-1"></i> Details
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4:30 PM</td>
                                            <td>Chemistry</td>
                                            <td>Dr. Williams</td>
                                            <td>60 min</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-info-circle me-1"></i> Details
                                                </a>
                                            </td>
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
                                <a href="{{ route('learner.tutors') }}" class="btn btn-success">
                                    <i class="fas fa-search me-2"></i> Find a Tutor
                                </a>
                                <a href="{{ route('learner.sessions.book') }}" class="btn btn-outline-success">
                                    <i class="fas fa-calendar-plus me-2"></i> Book Session
                                </a>
                                <a href="{{ route('learner.courses') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-play-circle me-2"></i> Continue Learning
                                </a>
                                <a href="{{ route('learner.messages') }}" class="btn btn-outline-info">
                                    <i class="fas fa-comments me-2"></i> Messages
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Learning Progress</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Mathematics</span>
                                    <span>75%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 75%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Physics</span>
                                    <span>50%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 50%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Chemistry</span>
                                    <span>30%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: 30%"></div>
                                </div>
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
        background-color: #198754;
        color: white;
    }

    .sidebar-header {
        padding: 1rem 1rem 0;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endsection