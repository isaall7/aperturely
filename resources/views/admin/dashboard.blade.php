@extends('layouts.index')

@section('content')
<style>
    .admin-dashboard {
        background: #f5f7fa;
        min-height: 100vh;
        padding-top: 10px; /* Jarak dari navbar */
        padding-bottom: 40px;
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        border-radius: 16px;
        padding: 40px 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.2);
    }

    .dashboard-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
        color: white;
    }

    .dashboard-header p {
        margin: 0 0 12px 0;
        opacity: 0.95;
        font-size: 16px;
    }

    .welcome-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        backdrop-filter: blur(10px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid #4a90e2;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(74, 144, 226, 0.15);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
    }

    .stat-icon.light-blue {
        background: #e3f2fd;
        color: #2196f3;
    }

    .stat-icon.cyan {
        background: #e0f7fa;
        color: #00bcd4;
    }

    .stat-icon.indigo {
        background: #e8eaf6;
        color: #5c6bc0;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 13px;
        color: #7f8c8d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-change {
        font-size: 12px;
        color: #27ae60;
        font-weight: 600;
        margin-top: 8px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .action-btn {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 25px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        color: #2c3e50;
        display: block;
    }

    .action-btn:hover {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        border-color: #4a90e2;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(74, 144, 226, 0.25);
        color: white;
    }

    .action-icon {
        font-size: 32px;
        margin-bottom: 10px;
        display: block;
    }

    .action-label {
        font-size: 14px;
        font-weight: 600;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-card,
    .activity-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .chart-card h3,
    .activity-card h3 {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .chart-placeholder {
        height: 300px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e3f2fd 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7f8c8d;
        font-size: 14px;
        text-align: center;
        padding: 20px;
    }

    .activity-list {
        max-height: 350px;
        overflow-y: auto;
    }

    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.2s;
    }

    .activity-item:hover {
        background: #f8f9fa;
    }

    .activity-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-size: 14px;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .activity-time {
        font-size: 12px;
        color: #95a5a6;
    }

    .bottom-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 20px;
    }

    .table-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .table-card h3 {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .simple-table {
        width: 100%;
        border-collapse: collapse;
    }

    .simple-table th {
        background: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-size: 13px;
        color: #7f8c8d;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
    }

    .simple-table td {
        padding: 12px;
        font-size: 14px;
        color: #2c3e50;
        border-bottom: 1px solid #f1f3f5;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.active {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.inactive {
        background: #f8d7da;
        color: #721c24;
    }

    /* Scrollbar */
    .activity-list::-webkit-scrollbar {
        width: 6px;
    }

    .activity-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .activity-list::-webkit-scrollbar-thumb {
        background: #4a90e2;
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .admin-dashboard {
            padding-top: 80px;
        }

        .dashboard-header {
            padding: 30px 20px;
        }

        .dashboard-header h1 {
            font-size: 24px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="admin-dashboard py-5 ">
    <div class="dashboard-container">
        <!-- Header -->
        <div class="dashboard-header">
            <h1>👋 Welcome back, {{ Auth::user()->name }}!</h1>
            <p>Here's what's happening with your platform today</p>
            <span class="welcome-badge">🛡️ {{ ucfirst(Auth::user()->role) }} Dashboard</span>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">👥</div>
                <div class="stat-number">{{ $totalUsers ?? '1,234' }}</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-change">↑ 12% from last month</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon light-blue">📸</div>
                <div class="stat-number">{{ $totalPosts ?? '5,678' }}</div>
                <div class="stat-label">Total Posts</div>
                <div class="stat-change">↑ 8% from last month</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon cyan">❤️</div>
                <div class="stat-number">{{ $totalLikes ?? '23.5K' }}</div>
                <div class="stat-label">Total Likes</div>
                <div class="stat-change">↑ 15% from last month</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon indigo">💬</div>
                <div class="stat-number">{{ $totalComments ?? '8,942' }}</div>
                <div class="stat-label">Total Comments</div>
                <div class="stat-change">↑ 5% from last month</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="#" class="action-btn">
                <span class="action-icon">➕</span>
                <span class="action-label">Add User</span>
            </a>
            <a href="#" class="action-btn">
                <span class="action-icon">📊</span>
                <span class="action-label">View Reports</span>
            </a>
            <a href="#" class="action-btn">
                <span class="action-icon">⚙️</span>
                <span class="action-label">Settings</span>
            </a>
            <a href="#" class="action-btn">
                <span class="action-icon">🔔</span>
                <span class="action-label">Notifications</span>
            </a>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Chart Card -->
            <div class="chart-card">
                <h3>📈 User Growth Analytics</h3>
                <div class="chart-placeholder">
                    Chart will be displayed here<br>(integrate with Chart.js or similar)
                </div>
            </div>

            <!-- Activity Card -->
            <div class="activity-card">
                <h3>🔥 Recent Activity</h3>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-avatar">JD</div>
                        <div class="activity-content">
                            <div class="activity-text"><strong>John Doe</strong> created a new post</div>
                            <div class="activity-time">2 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">AS</div>
                        <div class="activity-content">
                            <div class="activity-text"><strong>Alice Smith</strong> liked a post</div>
                            <div class="activity-time">5 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">BJ</div>
                        <div class="activity-content">
                            <div class="activity-text"><strong>Bob Johnson</strong> commented on a post</div>
                            <div class="activity-time">10 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">CD</div>
                        <div class="activity-content">
                            <div class="activity-text"><strong>Carol Davis</strong> registered as new user</div>
                            <div class="activity-time">15 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">EW</div>
                        <div class="activity-content">
                            <div class="activity-text"><strong>Eve Wilson</strong> updated profile</div>
                            <div class="activity-time">20 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">FM</div>
                        <div class="activity-content">
                            <div class="activity-text"><strong>Frank Miller</strong> shared a post</div>
                            <div class="activity-time">25 minutes ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Grid -->
        <div class="bottom-grid">
            <!-- Recent Users -->
            <div class="table-card">
                <h3>👤 Recent Users</h3>
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td><span class="status-badge active">Active</span></td>
                        </tr>
                        <tr>
                            <td>Alice Smith</td>
                            <td>alice@example.com</td>
                            <td><span class="status-badge active">Active</span></td>
                        </tr>
                        <tr>
                            <td>Bob Johnson</td>
                            <td>bob@example.com</td>
                            <td><span class="status-badge pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Carol Davis</td>
                            <td>carol@example.com</td>
                            <td><span class="status-badge active">Active</span></td>
                        </tr>
                        <tr>
                            <td>Eve Wilson</td>
                            <td>eve@example.com</td>
                            <td><span class="status-badge inactive">Inactive</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Recent Posts -->
            <div class="table-card">
                <h3>📸 Recent Posts</h3>
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Caption</th>
                            <th>Likes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Beautiful sunset today!</td>
                            <td>245</td>
                        </tr>
                        <tr>
                            <td>Alice Smith</td>
                            <td>New adventure begins</td>
                            <td>189</td>
                        </tr>
                        <tr>
                            <td>Bob Johnson</td>
                            <td>Coffee time ☕</td>
                            <td>432</td>
                        </tr>
                        <tr>
                            <td>Carol Davis</td>
                            <td>Weekend vibes</td>
                            <td>567</td>
                        </tr>
                        <tr>
                            <td>Frank Miller</td>
                            <td>Working from home</td>
                            <td>123</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection