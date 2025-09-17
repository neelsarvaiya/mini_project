@extends('admin/admin_master_view')

@section('file_content')

<div class="card-body row">
    <div class="col-md-3"></div>

    <div class="col-md-6">
        <div class="container mt-5 mb-5">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Add User</h4>
                </div>

                <form action="{{ route('user_added') }}" method="POST" enctype="multipart/form-data" class="p-4">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" id="name" name="name" data-validation="required alpha min max" data-min="2" data-max="50" placeholder="Enter full name">
                        <div class="error" id="nameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" data-validation="required email" placeholder="Enter email">
                        <div class="error" id="emailError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone No.</label>
                        <input type="text" class="form-control" id="phone" name="phone" data-validation="required numeric min max" data-max="10" data-min="10" placeholder="Enter 10-digit phone number">
                        <div class="error" id="phoneError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="text" class="form-control" id="password" name="password" data-validation="required strongPassword" placeholder="Enter Password">
                        <div class="error" id="passwordError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" id="address" name="address" data-validation="required" placeholder="Enter address">
                        <div class="error" id="addressError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user" selected>User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="profile_image" class="form-label fw-semibold">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" data-validation="required file file1">
                        <div class="error" id="profile_imageError"></div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin_users') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-4">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

@endsection