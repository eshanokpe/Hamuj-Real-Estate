@extends('layouts.admin')

@section('content')
<div class="page-wrapper">
    <div class="page-content-tab">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <a href="{{ route('admin.faq.create') }}" class="btn btn-dark">
                                <i class="fas fa-plus"></i> Add FAQ
                            </a>
                        </div>
                        <h4 class="page-title">Support Conversations</h4>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Conversation List -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Open Support Tickets</h4>
                            <div class="search-box">
                                <form action="{{ route('admin.conversations.index') }}" method="GET" class="d-flex">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" 
                                            placeholder="Search conversations..." 
                                            value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if($conversations->isEmpty())
                                <div class="alert alert-info text-center">
                                    No open conversations found
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light"> 
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">User</th>
                                                <th width="25%">Subject</th>
                                                <th width="10%">Messages</th>
                                                <th width="20%">Last Activity</th>
                                                <th width="20%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($conversations as $conversation)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if($conversation->user_type === 'registered')
                                                        <a href="{{ route('admin.users.show', $conversation->user_id) }}" 
                                                           class="text-primary">
                                                            {{ $conversation->user->name }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">
                                                            {{ $conversation->user->name ?? 'Guest' }}
                                                        </span>
                                                        <span class="badge bg-secondary ms-1">Guest</span>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($conversation->subject, 40) }}</td>
                                                <td>{{ $conversation->messages_count }}</td>
                                                <td>
                                                    @if($conversation->last_message_at)
                                                        <span title="{{ $conversation->last_message_at->format('M j, Y g:i A') }}">
                                                            {{ $conversation->last_message_at->diffForHumans() }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.conversations.show', $conversation) }}" 
                                                       class="btn btn-sm btn-primary"
                                                       title="View conversation">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    @if($conversation->is_open)
                                                    <a href="{{ route('admin.conversations.close', $conversation) }}" 
                                                       class="btn btn-sm btn-danger ms-1"
                                                       title="Close conversation"
                                                       onclick="return confirm('Are you sure you want to close this conversation?')">
                                                        <i class="fas fa-lock"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                @if($conversations->hasPages())
                                <div class="mt-3">
                                    {{ $conversations->withQueryString()->links() }}
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
    }
    .search-box {
        width: 300px;
    }
</style>
@endsection