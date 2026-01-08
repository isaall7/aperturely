@extends('layouts.index')

@section('content')
<style>
    .feed-container {
        background: #f0f5f9;
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .post-card {
        background: white;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .post-header {
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e8e8e8;
    }
    
    .post-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #4a90e2;
    }
    
    .user-info h6 {
        margin: 0;
        font-weight: 600;
        color: #1a1a1a;
        font-size: 14px;
    }
    
    .user-info span {
        font-size: 12px;
        color: #8e8e8e;
    }
    
    .post-carousel {
        position: relative;
        background: #000;
    }
    
    .post-carousel img {
        width: 100%;
        height: 500px;
        object-fit: contain;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.8);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .carousel-control-prev {
        left: 15px;
    }
    
    .carousel-control-next {
        right: 15px;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1);
    }
    
    .post-actions {
        padding: 12px 15px;
        display: flex;
        gap: 15px;
        border-bottom: 1px solid #e8e8e8;
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
        padding: 0 15px 8px;
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
    }
    
    .post-caption {
        padding: 0 15px 8px;
        font-size: 14px;
        color: #1a1a1a;
    }
    
    .post-caption .username {
        font-weight: 600;
        margin-right: 6px;
    }
    
    .post-comments {
        padding: 0 15px 12px;
    }
    
    .view-comments {
        color: #8e8e8e;
        font-size: 14px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        text-align: left;
    }
    
    .view-comments:hover {
        color: #4a90e2;
    }
    
    .post-time {
        padding: 0 15px 12px;
        font-size: 12px;
        color: #8e8e8e;
        text-transform: uppercase;
    }
    
    .notification-sidebar {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: sticky;
        top: 20px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }
    
    .notification-header {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 20px;
        color: #1a1a1a;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .notification-badge {
        background: #e74c3c;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }
    
    .notification-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .notification-item:hover {
        background: #f0f7ff;
    }
    
    .notification-item.unread {
        background: #e8f4ff;
    }
    
    .notification-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-content strong {
        font-weight: 600;
        color: #1a1a1a;
    }
    
    .notification-content p {
        margin: 0;
        font-size: 13px;
        color: #4a4a4a;
    }
    
    .notification-time {
        font-size: 11px;
        color: #8e8e8e;
        margin-top: 4px;
    }
    
    /* Modal Styles */
    .comment-modal .modal-dialog {
        max-width: 1000px;
    }
    
    .comment-modal .modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: none;
    }
    
    .comment-modal .modal-body {
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
    
    .modal-comment-input {
        padding: 15px;
        display: flex;
        gap: 10px;
        align-items: center;
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
    
    /* Scrollbar Styling */
    .notification-sidebar::-webkit-scrollbar,
    .modal-comments-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .notification-sidebar::-webkit-scrollbar-track,
    .modal-comments-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .notification-sidebar::-webkit-scrollbar-thumb,
    .modal-comments-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .notification-sidebar::-webkit-scrollbar-thumb:hover,
    .modal-comments-list::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

<div class="feed-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Posts Feed -->
            <div class="col-lg-8">
                <!-- Post 1 -->
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-user">
                            <img src="https://i.pravatar.cc/150?img=1" alt="User" class="user-avatar">
                            <div class="user-info">
                                <h6>asupan_gabutmu5444</h6>
                                <span>44m</span>
                            </div>
                        </div>
                        <button class="action-btn">⋯</button>
                    </div>
                    
                    <div id="carousel1" class="carousel slide post-carousel" data-bs-ride="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://picsum.photos/600/600?random=1" alt="Post 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://picsum.photos/600/600?random=2" alt="Post 2">
                            </div>
                            <div class="carousel-item">
                                <img src="https://picsum.photos/600/600?random=3" alt="Post 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    
                    <div class="post-actions">
                        <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#commentModal1">💬</button>
                        <button class="action-btn">📤</button>
                        <button class="action-btn ms-auto">🔖</button>
                    </div>
                    
                    <div class="post-likes">455 likes</div>
                    
                    <div class="post-caption">
                        <span class="username">asupan_gabutmu5444</span>
                        Saat dewasa baru ngeh gue lihat scene ini 😂
                    </div>
                    
                    <div class="post-comments">
                        <button class="view-comments" data-bs-toggle="modal" data-bs-target="#commentModal1">
                            View all 23 comments
                        </button>
                    </div>
                    
                    <div class="post-time">44 minutes ago</div>
                </div>

                <!-- Post 2 -->
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-user">
                            <img src="https://i.pravatar.cc/150?img=2" alt="User" class="user-avatar">
                            <div class="user-info">
                                <h6>travel_indonesia</h6>
                                <span>2h</span>
                            </div>
                        </div>
                        <button class="action-btn">⋯</button>
                    </div>
                    
                    <div id="carousel2" class="carousel slide post-carousel" data-bs-ride="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://picsum.photos/600/600?random=4" alt="Post 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://picsum.photos/600/600?random=5" alt="Post 2">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel2" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel2" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    
                    <div class="post-actions">
                        <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#commentModal2">💬</button>
                        <button class="action-btn">📤</button>
                        <button class="action-btn ms-auto">🔖</button>
                    </div>
                    
                    <div class="post-likes">1,234 likes</div>
                    
                    <div class="post-caption">
                        <span class="username">travel_indonesia</span>
                        Pemandangan indah dari Raja Ampat 🌴🌊
                    </div>
                    
                    <div class="post-comments">
                        <button class="view-comments" data-bs-toggle="modal" data-bs-target="#commentModal2">
                            View all 156 comments
                        </button>
                    </div>
                    
                    <div class="post-time">2 hours ago</div>
                </div>

                <!-- Post 3 -->
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-user">
                            <img src="https://i.pravatar.cc/150?img=3" alt="User" class="user-avatar">
                            <div class="user-info">
                                <h6>food_lovers</h6>
                                <span>5h</span>
                            </div>
                        </div>
                        <button class="action-btn">⋯</button>
                    </div>
                    
                    <div class="post-carousel">
                        <img src="https://picsum.photos/600/600?random=6" alt="Post">
                    </div>
                    
                    <div class="post-actions">
                        <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#commentModal3">💬</button>
                        <button class="action-btn">📤</button>
                        <button class="action-btn ms-auto">🔖</button>
                    </div>
                    
                    <div class="post-likes">892 likes</div>
                    
                    <div class="post-caption">
                        <span class="username">food_lovers</span>
                        Rendang terenak se-Indonesia! 🍛🔥
                    </div>
                    
                    <div class="post-comments">
                        <button class="view-comments" data-bs-toggle="modal" data-bs-target="#commentModal3">
                            View all 67 comments
                        </button>
                    </div>
                    
                    <div class="post-time">5 hours ago</div>
                </div>
            </div>

            <!-- Notifications Sidebar -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="notification-sidebar">
                    <div class="notification-header">
                        <span>Notifications</span>
                        <div class="notification-badge">8</div>
                    </div>
                    
                    <div class="notification-item unread">
                        <img src="https://i.pravatar.cc/150?img=11" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>Rajvanti</strong> started following you</p>
                            <div class="notification-time">2m ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item unread">
                        <img src="https://i.pravatar.cc/150?img=12" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>Green Day</strong> liked your post</p>
                            <div class="notification-time">5m ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item unread">
                        <img src="https://i.pravatar.cc/150?img=13" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>@SAVA_ARDIAN_25</strong> commented: "Amazing shot! 🔥"</p>
                            <div class="notification-time">12m ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item">
                        <img src="https://i.pravatar.cc/150?img=14" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>Hariis</strong> and <strong>3 others</strong> liked your comment</p>
                            <div class="notification-time">13m ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item">
                        <img src="https://i.pravatar.cc/150?img=15" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>6 pretty woman</strong> started following you</p>
                            <div class="notification-time">4h ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item">
                        <img src="https://i.pravatar.cc/150?img=16" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>tech_updates</strong> mentioned you in a comment</p>
                            <div class="notification-time">6h ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item">
                        <img src="https://i.pravatar.cc/150?img=17" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>music_daily</strong> shared your post to their story</p>
                            <div class="notification-time">8h ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item">
                        <img src="https://i.pravatar.cc/150?img=18" alt="User" class="notification-avatar">
                        <div class="notification-content">
                            <p><strong>art_gallery</strong> saved your post</p>
                            <div class="notification-time">1d ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comment Modal 1 -->
<div class="modal fade comment-modal" id="commentModal1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=1" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=1" alt="User" class="user-avatar">
                            <div class="user-info">
                                <h6>asupan_gabutmu5444</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=21" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">budi_santoso</span>
                                        <span class="comment-text">Wkwkwk ngakak parah 😂</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>2h</span>
                                        <button>Reply</button>
                                        <button>12 likes</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=22" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">rina_official</span>
                                        <span class="comment-text">Nostalgia banget masa kecil dulu 🥺</span>
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
                                        <span class="comment-username">joko_gaming</span>
                                        <span class="comment-text">Scene legend ini mah 🔥</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>45m</span>
                                        <button>Reply</button>
                                        <button>5 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-post-actions">
                            <div class="post-actions" style="border: none; padding: 0;">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes" style="padding: 8px 0;">455 likes</div>
                            <div class="post-time" style="padding: 0;">44 MINUTES AGO</div>
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

<!-- Comment Modal 2 -->
<div class="modal fade comment-modal" id="commentModal2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=4" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=2" alt="User" class="user-avatar">
                            <div class="user-info">
                                <h6>travel_indonesia</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=24" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">traveler_pro</span>
                                        <span class="comment-text">Raja Ampat emang surga dunia! 🌴</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>3h</span>
                                        <button>Reply</button>
                                        <button>25 likes</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=25" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">diving_enthusiast</span>
                                        <span class="comment-text">Kapan kesana lagi nih? 🤿</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>2h</span>
                                        <button>Reply</button>
                                        <button>15 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-post-actions">
                            <div class="post-actions" style="border: none; padding: 0;">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes" style="padding: 8px 0;">1,234 likes</div>
                            <div class="post-time" style="padding: 0;">2 HOURS AGO</div>
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

<!-- Comment Modal 3 -->
<div class="modal fade comment-modal" id="commentModal3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-6 modal-post-image">
                        <img src="https://picsum.photos/600/600?random=6" alt="Post">
                    </div>
                    <div class="col-md-6 modal-comments-section">
                        <div class="modal-post-header">
                            <img src="https://i.pravatar.cc/150?img=3" alt="User" class="user-avatar">
                            <div class="user-info">
                                <h6>food_lovers</h6>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <div class="modal-comments-list">
                            <div class="comment-item">
                                <img src="https://i.pravatar.cc/150?img=26" alt="User" class="comment-avatar">
                                <div class="comment-content">
                                    <div>
                                        <span class="comment-username">culinary_expert</span>
                                        <span class="comment-text">Rendangnya menggoda banget! 😋</span>
                                    </div>
                                    <div class="comment-actions">
                                        <span>6h</span>
                                        <button>Reply</button>
                                        <button>30 likes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-post-actions">
                            <div class="post-actions" style="border: none; padding: 0;">
                                <button class="action-btn like-btn" onclick="toggleLike(this)">🤍</button>
                                <button class="action-btn">💬</button>
                                <button class="action-btn">📤</button>
                            </div>
                            <div class="post-likes" style="padding: 8px 0;">892 likes</div>
                            <div class="post-time" style="padding: 0;">5 HOURS AGO</div>
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
    if (button.classList.contains('liked')) {
        button.innerHTML = '🤍';
        button.classList.remove('liked');
    } else {
        button.innerHTML = '❤️';
        button.classList.add('liked');
    }
}
</script>

@endsection