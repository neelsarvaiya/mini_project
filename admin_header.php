<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshPick Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #28a745, #56d879);
            color: #fff;
            padding-top: 60px;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border-radius: 10px;
            margin: 5px 10px;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.02);
        }

        .sidebar .sidebar-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 60px;
            background: #1e7e34;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            font-weight: 700;
            z-index: 1001;
            letter-spacing: 1px;
        }

        /* Topbar */
        .topbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 60px;
            background: #fff;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .topbar .menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 15px;
        }

        .topbar .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar .topbar-right .icon {
            font-size: 1.2rem;
            position: relative;
            cursor: pointer;
        }

        .topbar .topbar-right .icon span {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: #fff;
            font-size: 0.65rem;
            padding: 1px 5px;
            border-radius: 50%;
        }

        .topbar .topbar-right img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
        }

        .topbar .topbar-right img:hover {
            transform: scale(1.1);
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            padding: 80px 20px 20px 20px;
            transition: all 0.3s;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .card-dashboard {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            text-align: center;
        }

        .card-dashboard:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .card-dashboard h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .card-dashboard p {
            color: #6c757d;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .topbar {
                left: 0;
            }

            .topbar .menu-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">FreshPick Admin</div>
        <a href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="#"><i class="bi bi-box-seam"></i> Products</a>
        <a href="#"><i class="bi bi-basket"></i> Orders</a>
        <a href="#"><i class="bi bi-people"></i> Users</a>
        <a href="#"><i class="bi bi-tags"></i> Categories</a>
        <a href="#"><i class="bi bi-gear"></i> Settings</a>
    </div>

    <div class="topbar">
        <i class="bi bi-list menu-toggle" id="menu-toggle"></i>
        <h4>Dashboard</h4>
        <div class="topbar-right">
            <div class="icon">
                <i class="bi bi-bell"></i>
                <span>3</span>
            </div>
            <div class="icon">
                <i class="bi bi-envelope"></i>
                <span>5</span>
            </div>
            <img src="img/admin.jpg" alt="Admin">
        </div>
    </div>

    <div class="main-content">
        <h2>Welcome, Admin</h2>
        <p>Here’s a quick overview of your FreshPick Dashboard.</p>

        <div class="dashboard-cards mt-4">
            <div class="card-dashboard">
                <h3>120</h3>
                <p>New Orders</p>
            </div>
            <div class="card-dashboard">
                <h3>80</h3>
                <p>Products</p>
            </div>
            <div class="card-dashboard">
                <h3>45</h3>
                <p>Users</p>
            </div>
            <div class="card-dashboard">
                <h3>15</h3>
                <p>Categories</p>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
</body>

</html>
