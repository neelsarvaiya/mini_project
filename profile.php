<?php include_once('header.php'); ?>

<style>
    .profile-container {
        margin-top: 30px;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        /* padding for small screens */
    }

    .profile-card {
        border-radius: 1.2rem;
        border: none;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        max-width: 750px;
        width: 100%;
        transition: all 0.3s ease-in-out;
    }

    .profile-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.15);
    }

    .profile-header {
        background: linear-gradient(90deg, #28a745, #56d879);
        color: #fff;
        padding: 30px;
        border-top-left-radius: 1.2rem;
        border-top-right-radius: 1.2rem;
        text-align: center;
    }

    .profile-header .profile-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .profile-header .profile-image:hover {
        transform: scale(1.08);
    }

    .profile-header h2 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .profile-header p {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .card-body {
        padding: 2.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 0.8rem;
        padding: 12px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
    }

    .btn-custom {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save {
        border: 2px solid #28a745;
        color: #28a745;
    }

    .btn-save:hover {
        background: linear-gradient(90deg, #28a745, #56d879);
        color: #fff;
    }

    /* Responsive Tweaks */
    @media (max-width: 768px) {
        .profile-container {
            margin-top: 30px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .profile-header .profile-image {
            width: 100px;
            height: 100px;
        }

        .btn-custom {
            width: 100%;
            /* full width buttons on small screens */
        }

        .d-flex.gap-3 {
            flex-direction: column;
            gap: 10px;
        }
    }

    @media (max-width: 480px) {
        .profile-container {
            margin-top: 30px;
        }

        .profile-header h2 {
            font-size: 1.2rem;
        }

        .profile-header .profile-image {
            width: 80px;
            height: 80px;
        }

        .profile-header p {
            font-size: 0.85rem;
        }
    }
</style>

<div class="profile-container">
    <div class="card profile-card">
        <div class="profile-header">
            <img src="img/1.jpg" alt="Profile Picture" class="profile-image">
            <h2>John Doe</h2>
            <p>john.doe@example.com</p>
        </div>

        <!-- Profile Body -->
        <div class="card-body">
            <form action="update_profile.php" method="post" enctype="multipart/form-data">

                <div class="mb-4">
                    <input type="text" class="form-control" name="fullName" placeholder="Full Name"
                        value="John" data-validation="required alpha min" data-min="2">
                    <div class="error" id="fullNameError"></div>
                </div>

                <!-- Mobile -->
                <div class="mb-4">
                    <input type="text" class="form-control" name="mobile" placeholder="Mobile Number"
                        value="9876543210" data-validation="required numeric min max" data-min="10" data-max="10">
                    <div class="error" id="mobileError"></div>
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <textarea class="form-control" name="address" rows="3" placeholder="Your Address"
                        data-validation="required min" data-min="5"></textarea>
                    <div class="error" id="addressError"></div>
                </div>

                <!-- Profile Picture -->
                <div class="mb-4">
                    <input type="file" class="form-control" name="profile_picture" data-validation="fileType"
                        data-allowed="jpg,jpeg,png,gif">
                    <div class="error" id="profile_pictureError"></div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-3">
                    <button type="submit" class="btn btn-custom btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>