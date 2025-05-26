@extends('base.base1')

@section('content')

<style>
    /* Container utama flex supaya kiri dan kanan sama tinggi */
    .container{
        margin-top:50px;
    }
    .profile-row {
        display: flex;
        gap: 1.5rem;
        align-items: stretch;
        flex-wrap: wrap;
    }

    .profile-left, .profile-right, .HIHI {
        background: #f8f9fa;
        border-radius: 0.5rem;
        box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
        padding: 1.5rem;
        flex-grow: 1;
    }
    .HIHI{
        margin-top:20px;
    }
    /* Lebar kiri dan kanan */
    .profile-left {
        flex-basis: 30%;
        min-width: 280px;

        /* flex column untuk layout desktop */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center; /* supaya isi center horizontal */
        text-align: center;
    }

    .profile-right {
        flex-basis: 65%;
        min-width: 300px;
        display: flex;
        flex-direction: column;
    }

    /* Style untuk profile picture bulat dan ukurannya */
    .profile-initial {
        font-weight: 700;
        font-size: 3rem;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        user-select: none;
        margin-bottom: 0.75rem;
        flex-shrink: 0;
    }

    /* Nama dan email di bawah gambar */
    .profile-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .profile-email {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    /* Responsive untuk layar kecil */
    @media (max-width: 767.98px) {
        .profile-row {
            flex-direction: column;
        }
        .profile-left {
            flex-basis: 100%;
            min-width: auto;

            /* buat layout horizontal */
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            text-align: left;
            padding: 1rem 1.5rem;
        }
        .profile-initial {
            width: 70px;
            height: 70px;
            font-size: 2rem;
            margin-bottom: 0;
            margin-right: 1rem;
        }
        .profile-name {
            font-size: 1.25rem;
            margin-bottom: 0.1rem;
        }
        .profile-email {
            font-size: 0.9rem;
            margin-bottom: 0;
        }
    }
</style>

<div class="container py-5">
    <div class="profile-row">
        {{-- Profile Box kiri --}}
        <div class="profile-left">
            <div class="profile-initial">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
                <p>Welcome to your profile! Here you can update your information and settings.</p>
            </div>
        </div>

        {{-- Profile Info kanan --}}
        <div class="profile-right">
            <div class="card mb-4 flex-grow-1">
                <div class="card-header">
                    Profile Information
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Password Update Card --}}
    <div class="HIHI">
        <div class="card mb-4" id="HIHI">
        <div class="card-header">
            Update Password
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" autocomplete="current-password">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
    </div>
    

    {{-- Delete Account Card --}}
    <div class="HIHI">
        <div class="card mb-4">
        <div class="card-header">
            Delete Account
        </div>
        <div class="card-body">
            <p>Once your account is deleted, all data will be permanently lost.</p>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</button>
        </div>
    </div>
    </div>

    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('profile.destroy') }}" class="modal-content">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Once your account is deleted, all data will be permanently lost.</p>
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Password</label>
                        <input type="password" name="password" id="delete_password" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
