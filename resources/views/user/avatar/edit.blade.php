@extends('layouts.index')

@section('content')
<style>
    .create-profile-container {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .profile-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .card-header {
        background: #4a90e2;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        border-radius: 12px 12px 0 0;
    }
    
    .card-body {
        padding: 30px;
    }
    
    .avatar-section {
        text-align: center;
        margin-bottom: 25px;
    }
    
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4a90e2;
        margin-bottom: 15px;
    }
    
    .form-label {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
        width: 100%;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: #e74c3c;
    }
    
    .invalid-feedback {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .btn {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-primary {
        background: #4a90e2;
        color: white;
    }
    
    .btn-primary:hover {
        background: #357abd;
        transform: translateY(-2px);
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .mb-3 {
        margin-bottom: 20px;
    }
    
    .d-flex {
        display: flex;
    }
    
    .justify-content-end {
        justify-content: flex-end;
    }
</style>

<div class="create-profile-container mt-5">
    <div class="container">
        <div class="profile-card">
            <div class="card-header">
                <h5 class="text-white text-center">Buat Profile</h5>
            </div>

            <div class="card-body">
                {{-- ALERT --}}
                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('user.avatar.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- AVATAR --}}
                <div class="mb-3 avatar-section">
                    <img
                        src="{{ auth()->user()->avatar
                            ? asset('storage/' . auth()->user()->avatar)
                            : asset('ui/images/profile/default.jpg') }}"
                        class="avatar-preview"
                        id="avatarPreview"
                    >

                    <input
                        type="file"
                        name="avatar"
                        class="form-control @error('avatar') is-invalid @enderror"
                        accept="image/*"
                        onchange="previewAvatar(event)"
                    >

                    @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BIO --}}
                <div class="mb-3">
                    <label class="form-label">Bio</label>
                    <textarea
                        name="bio"
                        class="form-control @error('bio') is-invalid @enderror"
                        rows="4"
                    >{{ old('bio', auth()->user()->profile->bio ?? '') }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">Update Profile</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

{{-- PREVIEW AVATAR --}}
<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('avatarPreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection