<?php include_once('admin_header.php') ?>

<div class="card-body row">
    <div class="col-md-3"></div>

    <div class="col-md-6">
        <div class="container mt-5 mb-5">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Edit User</h4>
                </div>

                
                <form action="#" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="d-flex justify-content-center">
                        <img src="" class="img-fluid rounded-circle" style="height: 270px; width: 40%;">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" id="name" name="name" data-validation="required alpha min max" data-min="2" data-max="50" placeholder="Enter full name" value="{{ $user->name }}">
                        <div class="error" id="nameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" data-validation="required email" placeholder="Enter email" value="{{ $user->email }}">
                        <div class="error" id="emailError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone No.</label>
                        <input type="text" class="form-control" id="phone" name="phone" data-validation="required numeric min max" data-max="10" data-min="10" placeholder="Enter 10-digit phone number" value="{{ $user->phone }}">
                        <div class="error" id="phoneError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" id="address" name="address" data-validation="required" placeholder="Enter address" value="{{ $user->address }}">
                        <div class="error" id="addressError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>


                    <div class="mb-4">
                        <label for="profile_image" class="form-label fw-semibold">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" data-validation="file file1">
                        <div class="error" id="profile_imageError"></div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin_users') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-4">Update User</button>
                    </div>
                </form>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
<?php include_once('admin_footer.php.php') ?>