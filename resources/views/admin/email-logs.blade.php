@extends('layouts.template-body')

@section('title', 'Email Logs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">📧 Email Logs</h4>
                    <a href="{{ route('admin.email-monitoring') }}" class="btn btn-primary">
                        ← Back to Monitoring
                    </a>
                </div>
                <div class="card-body">
                    @if(empty($logs))
                        <div class="alert alert-info">
                            <h5>No email logs found</h5>
                            <p>Email logs will appear here when emails are sent. Make sure:</p>
                            <ul>
                                <li>Queue worker is running: <code>php artisan queue:work</code></li>
                                <li>Logging is enabled in your application</li>
                                <li>Email configuration is correct</li>
                            </ul>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Type</th>
                                        <th>Message</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        @php
                                            $parts = explode('] ', $log, 2);
                                            $timestamp = '';
                                            $message = $log;
                                            
                                            if (count($parts) > 1) {
                                                $timestamp = trim($parts[0], '[]');
                                                $message = $parts[1];
                                            }
                                            
                                            $type = 'info';
                                            if (strpos($message, '❌') !== false) {
                                                $type = 'error';
                                            } elseif (strpos($message, '✅') !== false) {
                                                $type = 'success';
                                            } elseif (strpos($message, '⚠️') !== false) {
                                                $type = 'warning';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $timestamp }}</td>
                                            <td>
                                                @if($type === 'error')
                                                    <span class="badge bg-danger">Error</span>
                                                @elseif($type === 'success')
                                                    <span class="badge bg-success">Success</span>
                                                @elseif($type === 'warning')
                                                    <span class="badge bg-warning">Warning</span>
                                                @else
                                                    <span class="badge bg-info">Info</span>
                                                @endif
                                            </td>
                                            <td>{{ $message }}</td>
                                            <td>
                                                @if(strpos($message, 'purchase_id') !== false)
                                                    <small class="text-muted">Purchase details included</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 