@extends('layouts.index')

@section('content')
<style>
    .profile-container {
        background: #f0f5f9;
        min-height: 100vh;
        padding: 40px 0;
    }

    .profile-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .profile-header {
        display: flex;
        gap: 80px;
        align-items: center;
        margin-bottom: 40px;
    }

    .profile-avatar-section {
        flex-shrink: 0;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4a90e2;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .profile-info {
        flex: 1;
    }

    .profile-username {
        font-size: 28px;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .btn-edit-profile {
        background: #4a90e2;
        color: white;
        border: none;
        padding: 8px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-edit-profile:hover {
        background: #357abd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .profile-stats {
        display: flex;
        gap: 40px;
        margin-bottom: 20px;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .stat-number {
        font-size: 22px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .stat-label {
        font-size: 14px;
        color: #8e8e8e;
    }

    .profile-bio {
        margin-top: 20px;
    }

    .profile-name {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .profile-description {
        color: #4a4a4a;
        font-size: 14px;
        line-height: 1.6;
    }

    .posts-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .posts-header {
        display: flex;
        justify-content: center;
        border-top: 1px solid #e8e8e8;
        margin: 0 -30px 30px;
        padding-top: 0;
    }

    .posts-tab {
        padding: 15px 20px;
        border-top: 2px solid transparent;
        cursor: pointer;
        color: #8e8e8e;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .posts-tab.active {
        border-top-color: #4a90e2;
        color: #1a1a1a;
    }

    .posts-tab:hover {
        color: #4a90e2;
    }

    .posts-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .post-item {
        position: relative;
        aspect-ratio: 1;
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
    }

    .post-item:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .post-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .post-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        opacity: 0;
        transition: opacity 0.3s;
        color: white;
        font-weight: 600;
    }

    .post-item:hover .post-overlay {
        opacity: 1;
    }

    .overlay-stat {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
    }

    /* Modal Styles */
    .profile-modal .modal-dialog {
        max-width: 1000px;
    }

    .profile-modal .modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: none;
    }

    .profile-modal .modal-body {
        padding: 0;
    }

    .modal-post-image {
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 600px;
    }

    .modal-post-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .modal-comments-section {
        height: 600px;
        display: flex;
        flex-direction: column;
    }

    .modal-post-header {
        padding: 15px;
        border-bottom: 1px solid #e8e8e8;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #4a90e2;
    }

    .modal-user-info h6 {
        margin: 0;
        font-weight: 600;
        color: #1a1a1a;
        font-size: 14px;
    }

    .modal-comments-list {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }

    .comment-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .comment-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .comment-content {
        flex: 1;
    }

    .comment-username {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 14px;
        margin-right: 8px;
    }

    .comment-text {
        color: #4a4a4a;
        font-size: 14px;
    }

    .comment-actions {
        display: flex;
        gap: 15px;
        margin-top: 8px;
        font-size: 12px;
        color: #8e8e8e;
    }

    .comment-actions button {
        background: none;
        border: none;
        color: #8e8e8e;
        cursor: pointer;
        padding: 0;
        font-weight: 600;
    }

    .comment-actions button:hover {
        color: #4a90e2;
    }

    .modal-post-actions {
        padding: 12px 15px;
        border-top: 1px solid #e8e8e8;
        border-bottom: 1px solid #e8e8e8;
    }

    .post-actions {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 24px;
        color: #1a1a1a;
        transition: all 0.2s;
    }

    .action-btn:hover {
        transform: scale(1.1);
        color: #4a90e2;
    }

    .action-btn.liked {
        color: #e74c3c;
    }

    .post-likes {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
        padding: 8px 0;
    }

    .post-time {
        font-size: 12px;
        color: #8e8e8e;
        text-transform: uppercase;
    }

    .modal-comment-input {
        padding: 15px;
        display: flex;
        gap: 10px;
        align-items: center;
        border-top: 1px solid #e8e8e8;
    }

    .modal-comment-input input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 14px;
    }

    .modal-comment-input button {
        background: none;
        border: none;
        color: #4a90e2;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
    }

    .modal-comment-input button:hover {
        color: #357abd;
    }

    /* Scrollbar */
    .modal-comments-list::-webkit-scrollbar {
        width: 6px;
    }

    .modal-comments-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .modal-comments-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .modal-comments-list::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .posts-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .profile-header {
            gap: 30px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
        }

        .profile-username {
            font-size: 22px;
        }

        .profile-stats {
            gap: 20px;
        }

        .posts-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    }
</style>

<div class="profile-container mt-5">
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar-section">
                @auth
                    <img src="{{ Auth::user()->avatar ?? asset('ui/images/profile/si_imoet.jpeg') }}" alt="Profile" class="profile-avatar">
                @endauth
                @guest 
                    <img src="{{asset('ui/images/profile/user3.jpg')}}" alt="Profile" class="profile-avatar">
                @endguest
                </div>
                <div class="profile-info">
                    <div class="profile-username">
                        <span>{{ Auth::user()->name ?? 'username' }}</span>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-number">42</span>
                            <span class="stat-label">Posts</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8,547</span>
                            <span class="stat-label">Total Likes</span>
                        </div>
                    </div>

                    <div class="profile-bio">
                        <div class="profile-name">{{ Auth::user()->name ?? 'Your Name' }}</div>
                        <div class="profile-description">
                            📸 Content Creator | Travel Enthusiast 🌍<br>
                            🎨 Capturing moments that matter<br>
                            📍 Jakarta, Indonesia<br>
                            ✉️ contact@aperturely.com
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Section -->
        <div class="posts-section">
            <div class="posts-header">
                <div class="posts-tab active">
                    📷 Posts
                </div>
                <div class="posts-tab">
                    🔖 Saved
                </div>
                <div class="posts-tab">
                    👤 Tagged
                </div>
            </div>

            <div class="posts-grid">
                <!-- Post 1 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal1">
                    <img src="https://picsum.photos/400/400?random=1" alt="Post 1">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>234</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>45</span>
                        </div>
                    </div>
                </div>

                <!-- Post 2 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal2">
                    <img src="https://picsum.photos/400/400?random=2" alt="Post 2">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>567</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>89</span>
                        </div>
                    </div>
                </div>

                <!-- Post 3 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal3">
                    <img src="https://picsum.photos/400/400?random=3" alt="Post 3">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>123</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>34</span>
                        </div>
                    </div>
                </div>

                <!-- Post 4 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal4">
                    <img src="https://picsum.photos/400/400?random=4" alt="Post 4">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>890</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>156</span>
                        </div>
                    </div>
                </div>

                <!-- Post 5 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal5">
                    <img src="https://picsum.photos/400/400?random=5" alt="Post 5">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>445</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>67</span>
                        </div>
                    </div>
                </div>

                <!-- Post 6 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal6">
                    <img src="https://picsum.photos/400/400?random=6" alt="Post 6">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>678</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>92</span>
                        </div>
                    </div>
                </div>

                <!-- Post 7 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal7">
                    <img src="https://picsum.photos/400/400?random=7" alt="Post 7">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>321</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>48</span>
                        </div>
                    </div>
                </div>

                <!-- Post 8 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal8">
                    <img src="https://picsum.photos/400/400?random=8" alt="Post 8">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>756</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>134</span>
                        </div>
                    </div>
                </div>

                <!-- Post 9 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal9">
                    <img src="https://picsum.photos/400/400?random=9" alt="Post 9">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>234</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>56</span>
                        </div>
                    </div>
                </div>

                <!-- Post 10 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal10">
                    <img src="https://picsum.photos/400/400?random=10" alt="Post 10">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>489</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>78</span>
                        </div>
                    </div>
                </div>

                <!-- Post 11 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal11">
                    <img src="https://picsum.photos/400/400?random=11" alt="Post 11">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>912</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>167</span>
                        </div>
                    </div>
                </div>

                <!-- Post 12 -->
                <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal12">
                    <img src="https://picsum.photos/400/400?random=12" alt="Post 12">
                    <div class="post-overlay">
                        <div class="overlay-stat">
                            <span>❤️</span>
                            <span>345</span>
                        </div>
                        <div class="overlay-stat">
                            <span>💬</span>
                            <span>89</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 1 -->
<div class="modal fade profile-modal" id="postModal1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=1" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=21" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">sarah_photography</span>
                                        <span class="comment-text">Amazing shot! Love the colors! 😍</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>2h</span>
                                        <button>Reply</button>
                                        <button>15 likes</button>
                                    </div>
                                </div>
                            </div>

                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=22" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">mike_travels</span>
                                        <span class="comment-text">Where is this place? Need to visit!</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>1h</span>
                                        <button>Reply</button>
                                        <button>8 likes</button>
                                    </div>
                                </div>
                            </div>

                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=23" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">linda_creative</span>
                                        <span class="comment-text">Absolutely stunning! 🔥</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>45m</span>
                                        <button>Reply</button>
                                        <button>12 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">234 likes</div>
                            <div class="post-time">3 DAYS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 2 -->
<div class="modal fade profile-modal" id="postModal2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=2" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=24" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">john_adventure</span>
                                        <span class="comment-text">This is incredible! 🌟</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>4h</span>
                                        <button>Reply</button>
                                        <button>23 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">567 likes</div>
                            <div class="post-time">5 DAYS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Duplicate modals for other posts (3-12) with similar structure -->
<!-- For brevity, showing structure for Modal 3 only -->
<div class="modal fade profile-modal" id="postModal3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=3" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=25" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">emma_style</span>
                                        <span class="comment-text">Love this aesthetic! 💙</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>1d</span>
                                        <button>Reply</button>
                                        <button>10 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">123 likes</div>
                            <div class="post-time">1 WEEK AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 4 -->
<div class="modal fade profile-modal" id="postModal4" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=4" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=26" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">alex_photos</span>
                                        <span class="comment-text">Perfect composition! 👏</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>2d</span>
                                        <button>Reply</button>
                                        <button>18 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">890 likes</div>
                            <div class="post-time">2 WEEKS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 5 -->
<div class="modal fade profile-modal" id="postModal5" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=5" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=27" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">sophia_art</span>
                                        <span class="comment-text">So beautiful! ✨</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>3d</span>
                                        <button>Reply</button>
                                        <button>25 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">445 likes</div>
                            <div class="post-time">3 WEEKS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 6 -->
<div class="modal fade profile-modal" id="postModal6" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=6" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=28" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">david_capture</span>
                                        <span class="comment-text">Great lighting! 📸</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>1w</span>
                                        <button>Reply</button>
                                        <button>14 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">678 likes</div>
                            <div class="post-time">1 MONTH AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 7 -->
<div class="modal fade profile-modal" id="postModal7" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=7" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=29" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">olivia_lens</span>
                                        <span class="comment-text">Stunning! 😍</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>2w</span>
                                        <button>Reply</button>
                                        <button>32 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">321 likes</div>
                            <div class="post-time">2 MONTHS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 8 -->
<div class="modal fade profile-modal" id="postModal8" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=8" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=30" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">ryan_focus</span>
                                        <span class="comment-text">Amazing detail! 🔍</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>3w</span>
                                        <button>Reply</button>
                                        <button>19 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">756 likes</div>
                            <div class="post-time">3 MONTHS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 9 -->
<div class="modal fade profile-modal" id="postModal9" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=9" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=31" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">maya_vision</span>
                                        <span class="comment-text">Love the mood! 🌙</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>1m</span>
                                        <button>Reply</button>
                                        <button>27 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">234 likes</div>
                            <div class="post-time">4 MONTHS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 10 -->
<div class="modal fade profile-modal" id="postModal10" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=10" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=32" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">chris_frame</span>
                                        <span class="comment-text">Perfect shot! 📷</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>2m</span>
                                        <button>Reply</button>
                                        <button>21 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">489 likes</div>
                            <div class="post-time">5 MONTHS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 11 -->
<div class="modal fade profile-modal" id="postModal11" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=11" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=33" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">bella_light</span>
                                        <span class="comment-text">Gorgeous! ✨</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>3m</span>
                                        <button>Reply</button>
                                        <button>35 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">912 likes</div>
                            <div class="post-time">6 MONTHS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Detail Modal 12 -->
<div class="modal fade profile-modal" id="postModal12" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=12" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=8" alt="User" class="modal-user-avatar">
                            <div class="modal-user-info">
                                <h6>{{ Auth::user()->name ?? 'username' }}</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=34" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">jack_shutter</span>
                                        <span class="comment-text">Incredible work! 🎯</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>4m</span>
                                        <button>Reply</button>
                                        <button>28 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-post-actions">
                            <div class="post-actions">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes">345 likes</div>
                            <div class="post-time">7 MONTHS AGO</div>
                        </div>

                        <div class="modal-comment-input">
                            <input type="text" placeholder="Add a comment...">
                            <button>Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleLike(button) {
    if (button.textContent === '🤍') {
        button.textContent = '❤️';
        button.classList.add('liked');
    } else {
        button.textContent = '🤍';
        button.classList.remove('liked');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.posts-tab');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>

@endsection
