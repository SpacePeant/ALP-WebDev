<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
    <style>
        /* Styling for your profile page remains the same */
        body {
            background-color: #f0f0f0;
            font-family: 'Red Hat Text', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .profile-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 600px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-initial {
            width: 80px;
            height: 80px;
            background-color: #333;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .profile-header h4 {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .profile-header small {
            color: #777;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .edit-btn {
            color: #777;
            cursor: pointer;
            transition: color 0.3s;
        }
        .edit-btn:hover {
            color: #787878;
        }
        .profile-footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
        .btn-black, .btn-secondary {
            color: white !important; 
            border-radius: 0; 
            border: none; 
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-black {
            background-color: black !important; 
        }

        .btn-secondary {
            background-color: #444;
        }
        @media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-initial {
        margin: 0 auto 15px;
    }

    .info-row {
        flex-direction: row; /* tetap row */
        flex-wrap: wrap;     /* biar teks bisa wrap ke baris bawah jika terlalu panjang */
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .info-row > div {
        flex: 1 1 auto; /* teks boleh melebar dan wrap */
        min-width: 0;   /* supaya bisa wrap dengan baik */
    }

    .info-row .edit-btn {
        flex: 0 0 auto; /* ukuran tetap sesuai icon */
        margin-top: 0;
        align-self: center;
        cursor: pointer;
    }
}

@media (max-width: 576px) {
    .profile-card {
        padding: 15px 20px;
        max-width: 350px;
        margin: 20px auto;
        width: 90%;
    }

    .profile-initial {
        width: 60px;
        height: 60px;
        font-size: 26px;
    }

    .btn {
        width: 100%;
        margin-top: 10px;
    }
}
.back-to-collection {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #fff;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
}
.back-to-collection:hover {
    background: #f0f0f0;
}
    </style>
</head>
<body>
    <a href="javascript:void(0);" onclick="history.back();" class="back-to-collection" title="Kembali ke koleksi">
        <i data-feather="x"></i>
    </a>
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-initial">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h4>{{ $user->name }}</h4>
                <small>{{ $user->email }}</small>
            </div>
        </div>
        

        <div class="info-row">
            <div>
                <strong>Name</strong><br>
                <span>{{ $user->name }}</span>
            </div>
            <i class="bi bi-pencil-square edit-btn" title="Edit Name" data-bs-toggle="modal" data-bs-target="#editModal" data-field="name" data-value="{{ $user->name }}"></i>
        </div>

        <div class="info-row">
            <div>
                <strong>Phone Number</strong><br>
                <span>{{ $user->phone_number }}</span>
            </div>
            <i class="bi bi-pencil-square edit-btn" title="Edit Phone Number" data-bs-toggle="modal" data-bs-target="#editModal" data-field="phone_number" data-value="{{ $user->phone_number }}"></i>
        </div>
        <div class="info-row">
            <div>
                <strong>Address</strong><br>
                <span>{{ $user->address }}</span>
            </div>
            <i class="bi bi-pencil-square edit-btn" title="Edit Address" data-bs-toggle="modal" data-bs-target="#editModal" data-field="address" data-value="{{ $user->address }}"></i>
        </div>
<div class="info-row">
    <div>
        <strong>Password</strong><br>
        <span>********</span>
    </div>
    <i class="bi bi-pencil-square edit-btn" title="Change Password" data-bs-toggle="modal" data-bs-target="#editPasswordModal"></i>
</div>
        <div class="profile-footer">
            <small class="text-muted">Want to update your details? Just click the pencil icon next to each section.</small>
        </div>
    </div>

    <!-- Modal for editing profile info -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   {{-- <form id="editForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                        <input type="hidden" name="field" id="editField">
                    </form> --}}
                    <form id="editForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <input type="hidden" name="field" id="editField">
                        <label for="editValue" id="editLabel"></label>
                        <input type="text" name="value" id="editValue" class="form-control" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editForm" class="btn btn-black">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editPasswordForm" method="POST" action="{{ route('profile.update') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alert-container" class="mt-3"></div>
                    <input type="hidden" name="field" value="password">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password</label>
                        <input type="password" class="form-control" id="oldPassword" name="old_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        {{-- <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required> --}}
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.edit-btn').forEach((editBtn) => {
    editBtn.addEventListener('click', function() {
        // const field = this.closest('.info-row').querySelector('strong').textContent.toLowerCase();
        // const currentValue = this.closest('.info-row').querySelector('span').textContent;
        const field = this.getAttribute('data-field'); // lebih aman
        const currentValue = this.getAttribute('data-value');

        const editLabel = document.getElementById('editLabel');
        const editField = document.getElementById('editField');
        if (field === 'name') {
            editLabel.textContent = 'New Name';
        } else if (field === 'phone number') {
            editLabel.textContent = 'New Phone Number';
        } else if (field === 'address') {
            editLabel.textContent = 'New Address';
        }

        // document.getElementById('editValue').value = currentValue;
        // editField.value = field;

        // $('#editModal').modal('show');

          editField.value = field;
        editValue.value = currentValue;
    });
});

// Kosongkan password field setiap kali modal password dibuka
const passwordModal = document.getElementById('editPasswordModal');
passwordModal.addEventListener('show.bs.modal', function () {
    document.getElementById('oldPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
});

    </script>

    <script>
function showAlert(message, type) {
    $('#alert-container').html(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
        </div>
    `);
}

// Handle form submit untuk data umum
$('#editForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: "{{ route('profile.update') }}",
        data: $(this).serialize(),
        success: function(response) {
            // $('#editModal').modal('hide');
            showAlert(response, 'success');
            setTimeout(() => location.reload(), 2000); 
        },
        error: function(xhr) {
            // $('#editModal').modal('hide');
            showAlert(xhr.responseText, 'danger');
        }
    });
});

// Handle form submit untuk password
$('#editPasswordForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: "{{ route('profile.update') }}",
        data: $(this).serialize(),
        success: function(response) {
            // Jangan langsung tutup modal setelah submit, beri kesempatan melihat alert
            showAlert(response, 'success');
            
            // Delay untuk memberi waktu agar alert muncul
            setTimeout(function() {
                $('#editPasswordModal').modal('hide'); // Tutup modal setelah alert tampil
                location.reload(); // reload untuk update data
            }, 1500);
        },
        error: function(xhr) {
            // Jangan tutup modal setelah error
            showAlert(xhr.responseText, 'danger');
        }
    });
});
</script>
<script>
  feather.replace();
  </script>
</body>
</html>