@extends('layouts.index2')

@section('content')
<style>
    .profile-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fafafa;
        padding: 20px;
    }
    
    .profile-box {
        background: white;
        border-radius: 16px;
        padding: 40px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .profile-title {
        font-size: 24px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 32px;
        text-align: center;
    }
    
    .avatar-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 32px;
    }
    
    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        background: #f5f5f5;
        border: 2px solid #e5e5e5;
    }
    
    .avatar-upload {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        background: #1a1a1a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .avatar-upload:hover {
        background: #333;
    }
    
    .avatar-upload svg {
        width: 16px;
        height: 16px;
        color: white;
    }
    
    .avatar-input {
        display: none;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: #4a4a4a;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
        font-family: inherit;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #1a1a1a;
    }
    
    .form-input.error {
        border-color: #ef4444;
    }
    
    .error-message {
        color: #ef4444;
        font-size: 13px;
        margin-top: 6px;
    }
    
    .submit-btn {
        width: 100%;
        padding: 14px;
        background: #1a1a1a;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .submit-btn:hover {
        background: #333;
    }
    
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }
    
    .alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
</style>

<div class="profile-container">
    <div class="profile-box">
        <h1 class="profile-title">Buat Profil</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.avatar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Avatar -->
            <div class="avatar-wrapper">
                <img
                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('ui/images/profile/default.jpg') }}"
                    class="avatar-preview"
                    id="avatarPreview"
                    alt="Avatar"
                >
                <label for="avatarInput" class="avatar-upload">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>
                <input
                    type="file"
                    name="avatar"
                    id="avatarInput"
                    class="avatar-input"
                    accept="image/*"
                    onchange="previewAvatar(event)"
                >
            </div>

            @error('avatar')
                <div class="error-message" style="text-align: center; margin-top: -24px; margin-bottom: 24px;">
                    {{ $message }}
                </div>
            @enderror

            <!-- Username -->
            <div class="form-group">
                <label class="form-label">Username</label>
                <input
                    type="text"
                    name="username"
                    class="form-input @error('username') error @enderror"
                    placeholder="username"
                    value="{{ old('username', auth()->user()->username) }}"
                >

                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bio -->
            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea
                    name="bio"
                    rows="4"
                    class="form-input @error('bio') error @enderror"
                    placeholder="Ceritakan tentang dirimu..."
                >{{ old('bio', auth()->user()->profile->bio ?? '') }}</textarea>

                @error('bio')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="submit-btn">
                Simpan Profil
            </button>
        </form>
    </div>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection