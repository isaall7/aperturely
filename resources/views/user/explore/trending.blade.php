@extends('layouts.index2')

@section('content')
<style>
    /* Preserve all dashboard styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Trending Page Specific */
    .trending-container {
        background: transparent;
        min-height: calc(100vh - 60px);
        padding: 30px 0;
    }

    .trending-header {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        border-radius: 24px;
        padding: 48px 40px;
        margin-bottom: 40px;
        color: white;
        box-shadow: 0 8px 32px rgba(238, 90, 111, 0.3);
        position: relative;
        overflow: hidden;
    }

    .trending-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .trending-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .trending-header-content {
        position: relative;
        z-index: 1;
    }

    .trending-header h1 {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .trending-header h1 i {
        font-size: 52px;
        animation: flame 1.5s ease-in-out infinite;
    }

    @keyframes flame {
        0%, 100% { transform: scale(1) rotate(-5deg); }
        50% { transform: scale(1.1) rotate(5deg); }
    }

    .trending-header p {
        font-size: 18px;
        opacity: 0.95;
        max-width: 600px;
    }

    /* Stats Card */
    .trending-stats-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        display: flex;
        gap: 32px;
        align-items: center;
        justify-content: center;
    }

    .stat-item {
        text-align: center;
        padding: 16px 32px;
        border-right: 2px solid #f0f0f0;
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-number {
        font-size: 36px;
        font-weight: 800;
        color: #ff6b6b;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #8e8e8e;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Trending List Container */
    .trending-list-container {
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    /* Trending List Item */
    .trending-list-item {
        display: flex;
        align-items: center;
        gap: 24px;
        padding: 20px;
        margin-bottom: 16px;
        background: #fafafa;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .trending-list-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: linear-gradient(135deg, #5d87ff, #4a7de8);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .trending-list-item:hover {
        background: white;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transform: translateX(8px);
    }
        /* Modal - From Dashboard */
    .detail-modal .modal-dialog {
        max-width: 1200px;
        height: 92vh;
        margin: 4vh auto;
    }

    .detail-modal .modal-content {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .detail-modal .modal-body {
        padding: 0;
        flex: 1;
        overflow: hidden;
    }

    .modal-container {
        display: flex;
        height: 100%;
    }

    .modal-image-section {
        flex: 1.5;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .modal-image-section img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Modal Carousel */
    .modal-carousel {
        width: 100%;
        height: 100%;
    }

    .modal-carousel .carousel-inner {
        height: 100%;
    }

    .modal-carousel .carousel-item {
        height: 100%;
        display: none !important;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    .modal-carousel .carousel-item.active {
        display: flex !important;
        position: relative;
    }

    .modal-carousel .carousel-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .modal-carousel .carousel-control-prev,
    .modal-carousel .carousel-control-next {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
    }

    .modal-carousel .carousel-control-prev:hover,
    .modal-carousel .carousel-control-next:hover {
        background: white;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }

    .modal-carousel .carousel-control-prev {
        left: 24px;
    }

    .modal-carousel .carousel-control-next {
        right: 24px;
    }

    .modal-carousel .carousel-control-prev-icon,
    .modal-carousel .carousel-control-next-icon {
        width: 28px;
        height: 28px;
        filter: invert(1);
    }

    .modal-carousel .carousel-indicators {
        bottom: 24px;
    }

    .modal-carousel .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.6);
        border: none;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .modal-carousel .carousel-indicators button.active {
        background-color: #fff;
        transform: scale(1.3);
    }

    /* Modal Details Section */
    .modal-details-section {
        width: 480px;
        background: white;
        display: flex;
        flex-direction: column;
        border-left: 1px solid #efefef;
    }

    .modal-header-custom {
        padding: 24px;
        border-bottom: 1px solid #efefef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-actions {
        display: flex;
        gap: 14px;
        align-items: center;
    }

    .modal-action-btn {
        background: #f8f8f8;
        border: none;
        cursor: pointer;
        font-size: 26px;
        padding: 10px;
        border-radius: 50%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-action-btn:hover {
        background: #e8e8e8;
        transform: scale(1.1) rotate(5deg);
    }

    .modal-save-btn {
        background: linear-gradient(135deg, #e60023, #c4001d);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 28px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(230, 0, 35, 0.3);
    }

    .modal-save-btn:hover {
        background: linear-gradient(135deg, #ff0a37, #e60023);
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(230, 0, 35, 0.4);
    }
        /* Comment Input */
    .modal-comment-input-section {
        padding: 24px;
        border-top: 1px solid #efefef;
    }

    .modal-comment-input {
        display: flex;
        gap: 14px;
        align-items: center;
    }

    .modal-comment-input input {
        flex: 1;
        border: 2px solid #efefef;
        border-radius: 28px;
        padding: 14px 24px;
        outline: none;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .modal-comment-input input:focus {
        border-color: #5d87ff;
        background: white;
        box-shadow: 0 0 0 4px rgba(93, 135, 255, 0.1);
    }

    .modal-comment-input button {
        background: #5d87ff;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 28px;
        font-weight: 700;
        cursor: pointer;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-comment-input button:hover:not(:disabled) {
        background: #4a7de8;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(93, 135, 255, 0.3);
    }

    .modal-comment-input button:disabled {
        background: #dbdbdb;
        cursor: not-allowed;
        opacity: 0.6;
    }
    .reply-info {
        padding: 8px 12px;
        background: #f0f7ff;
        border-radius: 8px;
        margin-top: 8px;
        display: none;
    }

    .reply-info small {
        color: #5d87ff;
        font-weight: 600;
    }

    .cancel-reply {
        background: none;
        border: none;
        color: #8e8e8e;
        cursor: pointer;
        margin-left: 10px;
        font-size: 14px;
    }

    .cancel-reply:hover {
        color: #262626;
    }
    /* Dropdown Menu */
    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        border-radius: 16px;
        padding: 10px;
        min-width: 220px;
        margin-top: 8px;
    }

    .dropdown-item {
        padding: 12px 18px;
        font-size: 15px;
        color: #262626;
        transition: all 0.2s ease;
        border-radius: 10px;
        font-weight: 500;
    }

    .dropdown-item:hover {
        background: #f0f7ff;
        color: #5d87ff;
        transform: translateX(4px);
    }

    .dropdown-item.text-danger:hover {
        background: #fff0f0;
        color: #e74c3c;
    }

    /* Report Modal */
    .report-modal .modal-dialog {
        max-width: 560px;
    }

    .report-modal .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .report-modal .modal-header {
        border-bottom: 1px solid #f0f0f0;
        padding: 28px;
    }

    .report-modal .modal-title {
        font-weight: 700;
        font-size: 20px;
        color: #262626;
    }

    .report-modal .modal-body {
        padding: 28px;
    }

    .report-modal .form-label {
        font-weight: 700;
        color: #262626;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .report-modal .form-select,
    .report-modal .form-control {
        border: 2px solid #efefef;
        border-radius: 14px;
        padding: 14px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .report-modal .form-select:focus,
    .report-modal .form-control:focus {
        border-color: #e74c3c;
        background: white;
        box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1);
    }

    .report-modal .modal-footer {
        border-top: 1px solid #f0f0f0;
        padding: 24px 28px;
        gap: 12px;
    }

    .report-modal .btn-submit-report {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex: 1;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .report-modal .btn-submit-report:hover {
        background: linear-gradient(135deg, #ff5a4a, #e74c3c);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(231, 76, 60, 0.4);
    }

    .report-modal .btn-cancel {
        background: #f0f5f9;
        color: #262626;
        border: none;
        padding: 14px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s ease;
        flex: 1;
    }

    .report-modal .btn-cancel:hover {
        background: #e0e7ed;
    }

    /* Scrollbar */
    .modal-comments-section::-webkit-scrollbar {
        width: 8px;
    }

    .modal-comments-section::-webkit-scrollbar-track {
        background: #f8f8f8;
        border-radius: 10px;
    }

    .modal-comments-section::-webkit-scrollbar-thumb {
        background: #dbdbdb;
        border-radius: 10px;
    }

    .modal-comments-section::-webkit-scrollbar-thumb:hover {
        background: #b8b8b8;
    }

    .trending-list-item:hover::before {
        transform: scaleY(1);
    }

    /* Top 3 special styling */
    .trending-list-item.rank-1 {
        background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(255, 165, 0, 0.05));
        border: 2px solid rgba(255, 215, 0, 0.3);
    }

    .trending-list-item.rank-1::before {
        background: linear-gradient(135deg, #FFD700, #FFA500);
    }

    .trending-list-item.rank-2 {
        background: linear-gradient(135deg, rgba(192, 192, 192, 0.1), rgba(168, 168, 168, 0.05));
        border: 2px solid rgba(192, 192, 192, 0.3);
    }

    .trending-list-item.rank-2::before {
        background: linear-gradient(135deg, #C0C0C0, #A8A8A8);
    }

    .trending-list-item.rank-3 {
        background: linear-gradient(135deg, rgba(205, 127, 50, 0.1), rgba(139, 69, 19, 0.05));
        border: 2px solid rgba(205, 127, 50, 0.3);
    }

    .trending-list-item.rank-3::before {
        background: linear-gradient(135deg, #CD7F32, #8B4513);
    }

    /* Ranking Number */
    .ranking-number {
        min-width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        border-radius: 12px;
        color: white;
        flex-shrink: 0;
    }

    .rank-1 .ranking-number {
        background: linear-gradient(135deg, #FFD700, #FFA500);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
    }

    .rank-2 .ranking-number {
        background: linear-gradient(135deg, #C0C0C0, #A8A8A8);
        box-shadow: 0 4px 12px rgba(192, 192, 192, 0.4);
    }

    .rank-3 .ranking-number {
        background: linear-gradient(135deg, #CD7F32, #8B4513);
        box-shadow: 0 4px 12px rgba(205, 127, 50, 0.4);
    }

    .ranking-number.other {
        background: linear-gradient(135deg, #5d87ff, #4a7de8);
        box-shadow: 0 4px 12px rgba(93, 135, 255, 0.3);
    }

    /* Post Thumbnail */
    .trending-thumbnail {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .trending-list-item:hover .trending-thumbnail {
        transform: scale(1.05);
    }

    /* Post Details */
    .trending-details {
        flex: 1;
        min-width: 0;
    }

    .trending-user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .trending-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .trending-username {
        font-weight: 700;
        color: #262626;
        font-size: 16px;
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .trending-username:hover {
        color: #5d87ff;
    }

    .trending-caption {
        font-size: 15px;
        color: #262626;
        line-height: 1.5;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .trending-stats {
        display: flex;
        gap: 24px;
        align-items: center;
    }

    .stat-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: white;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        color: #262626;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .stat-badge i {
        font-size: 16px;
    }

    .stat-badge.likes {
        color: #ff6b6b;
    }

    .stat-badge.comments {
        color: #5d87ff;
    }

    /* Crown Icon for Top 3 */
    .crown-icon {
        position: absolute;
        top: -8px;
        right: 20px;
        font-size: 32px;
        animation: float 2s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

    /* Modal Styles */
    .detail-modal .modal-dialog {
        max-width: 1200px;
        height: 92vh;
        margin: 4vh auto;
    }

    .detail-modal .modal-content {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .detail-modal .modal-body {
        padding: 0;
        flex: 1;
        overflow: hidden;
    }

    .modal-container {
        display: flex;
        height: 100%;
    }

    .modal-image-section {
        flex: 1.5;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .modal-image-section img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .modal-carousel {
        width: 100%;
        height: 100%;
    }

    .modal-carousel .carousel-inner {
        height: 100%;
    }

    .modal-carousel .carousel-item {
        height: 100%;
        display: none !important;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    .modal-carousel .carousel-item.active {
        display: flex !important;
        position: relative;
    }

    .modal-carousel .carousel-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .modal-carousel .carousel-control-prev,
    .modal-carousel .carousel-control-next {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
    }

    .modal-carousel .carousel-control-prev:hover,
    .modal-carousel .carousel-control-next:hover {
        background: white;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }

    .modal-carousel .carousel-control-prev {
        left: 24px;
    }

    .modal-carousel .carousel-control-next {
        right: 24px;
    }

    .modal-carousel .carousel-control-prev-icon,
    .modal-carousel .carousel-control-next-icon {
        width: 28px;
        height: 28px;
        filter: invert(1);
    }

    .modal-details-section {
        width: 480px;
        background: white;
        display: flex;
        flex-direction: column;
        border-left: 1px solid #efefef;
    }

    .modal-header-custom {
        padding: 24px;
        border-bottom: 1px solid #efefef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-actions {
        display: flex;
        gap: 14px;
        align-items: center;
    }

    .modal-action-btn {
        background: #f8f8f8;
        border: none;
        cursor: pointer;
        font-size: 26px;
        padding: 10px;
        border-radius: 50%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-action-btn:hover {
        background: #e8e8e8;
        transform: scale(1.1) rotate(5deg);
    }

    .modal-user-section {
        padding: 24px;
        border-bottom: 1px solid #efefef;
    }

    .modal-user-info {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }

    .modal-user-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f0f0f0;
    }

    .modal-user-details h6 {
        margin: 0;
        font-weight: 700;
        color: #262626;
        font-size: 17px;
    }

    .modal-caption {
        font-size: 15px;
        color: #262626;
        line-height: 1.6;
        margin-bottom: 14px;
    }

    .modal-stats {
        display: flex;
        gap: 24px;
        font-size: 15px;
        color: #8e8e8e;
        font-weight: 600;
    }

    .modal-comments-section {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
    }

    .comment-item {
        display: flex;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f5f5f5;
    }

    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid #f0f0f0;
    }

    .comment-content {
        flex: 1;
    }

    .comment-username {
        font-weight: 700;
        color: #262626;
        font-size: 15px;
        margin-right: 10px;
    }

    .comment-text {
        color: #262626;
        font-size: 15px;
        line-height: 1.5;
    }

    .modal-comment-input-section {
        padding: 24px;
        border-top: 1px solid #efefef;
    }

    .modal-comment-input {
        display: flex;
        gap: 14px;
        align-items: center;
    }

    .modal-comment-input input {
        flex: 1;
        border: 2px solid #efefef;
        border-radius: 28px;
        padding: 14px 24px;
        outline: none;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .modal-comment-input input:focus {
        border-color: #5d87ff;
        background: white;
        box-shadow: 0 0 0 4px rgba(93, 135, 255, 0.1);
    }

    .modal-comment-input button {
        background: #5d87ff;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 28px;
        font-weight: 700;
        cursor: pointer;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-comment-input button:hover:not(:disabled) {
        background: #4a7de8;
        transform: scale(1.05);
    }

    /* Empty State */
    .empty-trending {
        text-align: center;
        padding: 120px 40px;
        background: white;
        border-radius: 24px;
        margin: 40px auto;
        max-width: 600px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .empty-trending i {
        font-size: 80px;
        margin-bottom: 24px;
        display: block;
        opacity: 0.7;
    }

    .empty-trending h4 {
        color: #262626;
        margin-bottom: 12px;
        font-weight: 700;
        font-size: 24px;
    }

    .empty-trending p {
        color: #8e8e8e;
        font-size: 16px;
    }
    .comment-actions {
    display: flex;
    gap: 20px;
    margin-top: 10px;
    font-size: 13px;
    color: #8e8e8e;
    font-weight: 600;
    }

    .comment-actions button {
        background: none;
        border: none;
        color: #8e8e8e;
        cursor: pointer;
        padding: 0;
        font-weight: 600;
        font-size: 13px;
        transition: color 0.3s ease;
    }
    .replies-container {
        margin-left: 52px;
        margin-top: 12px;
        padding-left: 12px;
        border-left: 2px solid #efefef;
    }
    .comment-avatar-link {
        display: block;
        line-height: 0;
        transition: opacity 0.2s ease;
    }

    .comment-avatar-link:hover {
        opacity: 0.7;
    }

    .comment-username-link {
        text-decoration: none;
        color: inherit;
    }

    .comment-username-link:hover .comment-username {
        text-decoration: underline;
        color: #000;
    }

    .comment-actions button:hover {
        color: #262626;
    }
    .modal-user-avatar:hover {
        border-color: #5d87ff;
        transform: scale(1.05);
    }

    .modal-user-details h6 a {
        color: #262626;
        text-decoration: none;
    }

    .modal-user-details h6 a:hover {
        color: #5d87ff;
    }

    .modal-stats span:hover {
        color: #262626;
    }
    /* Responsive */
    @media (max-width: 992px) {
        .trending-header h1 {
            font-size: 32px;
        }

        .stat-item {
            padding: 12px 20px;
        }

        .stat-number {
            font-size: 28px;
        }

        .trending-list-item {
            gap: 16px;
        }

        .trending-thumbnail {
            width: 100px;
            height: 100px;
        }
    }

    @media (max-width: 768px) {
        .trending-list-container {
            padding: 20px;
        }

        .trending-list-item {
            flex-wrap: wrap;
            gap: 12px;
        }

        .ranking-number {
            min-width: 50px;
            height: 50px;
            font-size: 24px;
        }

        .trending-thumbnail {
            width: 80px;
            height: 80px;
        }

        .trending-stats {
            width: 100%;
            justify-content: flex-start;
        }
    }

    @media (max-width: 600px) {
        .trending-stats-card {
            flex-direction: column;
            gap: 16px;
        }

        .stat-item {
            border-right: none;
            border-bottom: 2px solid #f0f0f0;
            padding: 16px;
            width: 100%;
        }

        .stat-item:last-child {
            border-bottom: none;
        }
    }
</style>

<div class="trending-container py-1 mt-1">
    <div class="container">
        <!-- Trending Header -->
        <div class="trending-header">
            <div class="trending-header-content">
                <h1 class="text-white">
                    Trending Sekarang
                </h1>
                <p>Postingan paling populer berdasarkan jumlah suka dan komentar</p>
            </div>
        </div>

        <!-- Stats Card -->
        @if($trendingPosts->count() > 0)
        <div class="trending-stats-card">
            <div class="stat-item">
                <div class="stat-number">{{ $trendingPosts->count() }}</div>
                <div class="stat-label">Postingan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $trendingPosts->sum('likes_count') }}</div>
                <div class="stat-label">Total suka</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $trendingPosts->sum('comments_count') }}</div>
                <div class="stat-label">Total Komentar</div>
            </div>
        </div>
        @endif

        <!-- Trending List -->
        @if($trendingPosts->count() > 0)
            <div class="trending-list-container">
                @foreach($trendingPosts as $index => $post)
                    <div class="trending-list-item {{ $index < 3 ? 'rank-' . ($index + 1) : '' }}" 
                         data-bs-toggle="modal" 
                         data-bs-target="#detailModal{{ $post->id }}">
                        
                        <!-- Crown for Top 3 -->
                        @if($index === 0)
                            <span class="crown-icon">👑</span>
                        @elseif($index === 1)
                            <span class="crown-icon">🥈</span>
                        @elseif($index === 2)
                            <span class="crown-icon">🥉</span>
                        @endif

                        <!-- Ranking Number -->
                        <div class="ranking-number {{ $index >= 3 ? 'other' : '' }}">
                            #{{ $index + 1 }}
                        </div>

                        <!-- Post Thumbnail -->
                        @if($post->photos && $post->photos->first())
                            <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" 
                                 alt="Post Thumbnail"
                                 class="trending-thumbnail"
                                 loading="lazy">
                        @else
                            <div class="trending-thumbnail" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #ccc; font-size: 32px;"></i>
                            </div>
                        @endif

                        <!-- Post Details -->
                        <div class="trending-details">
                            <!-- User Info -->
                            <div class="trending-user-info">
                                <img src="{{ $post->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                     alt="{{ $post->user->name }}" 
                                     class="trending-avatar">
                                <a href="{{ route('user.profile', $post->user->username ?? $post->user->id) }}" 
                                   class="trending-username"
                                   onclick="event.stopPropagation()">
                                    {{ $post->user->username ?? $post->user->name }}
                                </a>
                            </div>

                            <!-- Caption -->
                            @if($post->caption)
                                <div class="trending-caption">{{ $post->caption }}</div>
                            @else
                                <div class="trending-caption text-muted">Tidak ada caption</div>
                            @endif

                            <!-- Stats -->
                            <div class="trending-stats">
                                <div class="stat-badge likes">
                                    <i class="fas fa-heart"></i>
                                    <span>{{ number_format($post->likes->count()) }}</span>
                                </div>
                                <div class="stat-badge comments">
                                    <i class="fas fa-comment"></i>
                                    <span>{{ number_format($post->comments->count()) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('partials.post-modal', ['post' => $post])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $trendingPosts->links() }}
            </div>
        @else
            <div class="empty-trending">
                <i>🔥</i>
                <h4>Belum Ada Konten Trending</h4>
                <p>Belum ada postingan yang trending saat ini. Coba lagi nanti!</p>
            </div>
        @endif
    </div>
</div>

<script>
    // Like functionality
    document.querySelectorAll('.modal-action-btn[data-post-id]').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;

            fetch(`{{ route('user.post.like', ':id') }}`.replace(':id', postId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                this.innerHTML = data.liked ? '❤️' : '🤍';
                this.dataset.liked = data.liked ? '1' : '0';

                const countEl = document.querySelector(`.like-count[data-post-id="${postId}"]`);
                if (countEl) {
                    countEl.textContent = data.total;
                }
            })
            .catch(err => console.error(err));
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Comment form submit dengan AJAX
        document.querySelectorAll('.comment-form-ajax').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const commentInput = this.querySelector('.comment-input');
                const postId = this.dataset.postId;
                
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';

                fetch('{{ route("user.comments.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const commentsContainer = document.getElementById('comments-container-' + postId);
                        const noComments = document.getElementById('no-comments-' + postId);
                        
                        if (noComments) {
                            noComments.remove();
                        }

                        if (data.comment.reply_id) {
                            const parentWrapper = document.getElementById('comment-wrapper-' + data.comment.reply_id);
                            if (parentWrapper) {
                                let repliesContainer = parentWrapper.querySelector('.replies-container');
                                if (!repliesContainer) {
                                    repliesContainer = document.createElement('div');
                                    repliesContainer.className = 'replies-container';
                                    repliesContainer.style.marginLeft = '52px';
                                    repliesContainer.style.marginTop = '12px';
                                    repliesContainer.style.paddingLeft = '12px';
                                    repliesContainer.style.borderLeft = '2px solid #efefef';
                                    parentWrapper.appendChild(repliesContainer);
                                }
                                repliesContainer.insertAdjacentHTML('beforeend', data.html);
                            }
                        } else {
                            commentsContainer.insertAdjacentHTML('afterbegin', data.html);
                        }

                        commentInput.value = '';
                        const replyIdInput = form.querySelector('.reply-id-input');
                        const replyInfo = form.querySelector('.reply-info');
                        replyIdInput.value = '';
                        replyInfo.style.display = 'none';
                        
                        showAlert('success', 'Komentar berhasil ditambahkan!');
                    } else {
                        showAlert('error', data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Terjadi kesalahan saat mengirim komentar');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Kirim';
                });
            });
        });

        // Reply button click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('reply-btn')) {
                const commentId = e.target.getAttribute('data-id');
                const username = e.target.getAttribute('data-username');
                
                const modal = e.target.closest('.modal');
                if (modal) {
                    const form = modal.querySelector('.comment-form-ajax');
                    const replyIdInput = form.querySelector('.reply-id-input');
                    const replyInfo = form.querySelector('.reply-info');
                    const replyToUsername = form.querySelector('.reply-to-username');
                    const commentInput = form.querySelector('.comment-input');
                    
                    replyIdInput.value = commentId;
                    replyToUsername.textContent = username;
                    replyInfo.style.display = 'block';
                    commentInput.focus();
                }
            }
        });

        // Cancel reply
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('cancel-reply')) {
                const form = e.target.closest('.comment-form-ajax');
                const replyIdInput = form.querySelector('.reply-id-input');
                const replyInfo = form.querySelector('.reply-info');
                
                replyIdInput.value = '';
                replyInfo.style.display = 'none';
            }
        });

        // Delete comment
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-comment-btn')) {
                if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
                    const commentId = e.target.getAttribute('data-id');
                    const deleteUrl = e.target.getAttribute('data-url');
                    
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const commentElement = document.getElementById('comment-' + commentId);
                            if (commentElement) {
                                const commentWrapper = document.getElementById('comment-wrapper-' + commentId);
                                if (commentWrapper) {
                                    commentWrapper.remove();
                                } else {
                                    commentElement.remove();
                                }
                                
                                const modal = e.target.closest('.modal');
                                const commentsContainer = modal.querySelector('[id^="comments-container-"]');
                                const remainingComments = commentsContainer.querySelectorAll('.comment-wrapper, .comment-item:not(.reply-item)');
                                
                                if (remainingComments.length === 0) {
                                    const postId = commentsContainer.id.replace('comments-container-', '');
                                    commentsContainer.innerHTML = '<p class="text-center text-muted no-comments-msg" id="no-comments-' + postId + '">Belum ada komentar</p>';
                                }
                            }
                            showAlert('success', 'Komentar berhasil dihapus!');
                        } else {
                            showAlert('error', data.message || 'Gagal menghapus komentar');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'Terjadi kesalahan saat menghapus komentar');
                    });
                }
            }
        });

        // Helper function untuk alert
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '80px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '99999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Initialize carousels
        const carousels = document.querySelectorAll('.carousel');
        carousels.forEach(carousel => {
            new bootstrap.Carousel(carousel, {
                interval: false,
                wrap: true,
                touch: true
            });
        });
    });
</script>

@endsection