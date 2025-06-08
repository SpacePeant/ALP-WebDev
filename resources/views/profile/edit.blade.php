@extends('base.base1')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
<style>
    .container {
        margin-top: 50px;
    }

    .profile-initial {
        background-color: #000;
        color: white;
        font-weight: bold;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (min-width: 768px) {
        .profile-initial {
            width: 100px;
            height: 100px;
            font-size: 40px;
        }
        .tulisan{
            text-align:center;
        }
    }

    @media (max-width: 767.98px) {
        .profile-initial {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
        .tulisan{
            text-align:left;
        }
            #tul{
        margin-bottom:20px;
    }
    }

    .loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255,255,255,0.8);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .loader {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #555;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    #btn-profile {
        background: #444;
        transition: background-color 0.3s;
        color: white;
    }

    #btn-profile:hover {
    background:black;
    }
</style>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-4" id="tul">
            <div class="bg-light rounded shadow-sm p-3 h-100 d-flex flex-md-column flex-row align-items-center text-center text-md-start mb-5">
                <div class="profile-initial me-md-0 me-3 mb-md-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="tulisan">
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- Form informasi profil --}}
            <div class="card h-100">
                <div class="card-header">
                    <h5>Profile Information</h5>
                    <small class="text-muted">Update your account's profile information and email address.</small>
                </div>
                <div class="card-body">
                    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2 text-warning">
                                    Your email address is unverified.
                                    <button form="send-verification" class="btn btn-link p-0">Click here to re-send the verification email.</button>
                                </div>
                                @if (session('status') === 'verification-link-sent')
                                    <div class="mt-2 text-success">
                                        A new verification link has been sent to your email address.
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Address</label>
                            <input class="form-control" id="address" name="address" type="text" value="{{ old('address', $user->address) }}" required autofocus autocomplete="address">
                            @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Phone Number</label>
                            <input class="form-control" id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}" inputmode="numeric"
        pattern="[0-9]*"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
        maxlength="15"
        required autofocus autocomplete="phone_number">
                            @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn" id="btn-profile">Save</button>
                        @if (session('status') === 'profile-updated')
                            <span class="ms-3 text-success">Saved.</span>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Password --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5>Update Password</h5>
            <small class="text-muted">Use a strong password to secure your account.</small>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input class="form-control" id="current_password" name="current_password" type="password" autocomplete="current-password">
                    @error('current_password', 'updatePassword') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input class="form-control" id="password" name="password" type="password" autocomplete="new-password">
                    @error('password', 'updatePassword') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn" id="btn-profile">Save</button>
                @if (session('status') === 'password-updated')
                    <span class="ms-3 text-success">Saved.</span>
                @endif
            </form>
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="card">
        <div class="card-header">
            <h5>Delete Account</h5>
            <small class="text-muted">Once your account is deleted, all resources and data will be permanently removed.</small>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                Delete Account
            </button>
        </div>
    </div>
</div>

{{-- Bootstrap Modal for Delete Confirmation --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action is irreversible.</p>
                    <div class="mb-3">
                        <label for="password" class="form-label">Confirm Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @if ($errors->userDeletion->has('password'))
                            <div class="text-danger mt-1">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
