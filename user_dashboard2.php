<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Dashboard</h2>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Tickets</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar with Logo and Profile Icon -->
        <div class="topbar">
            <div class="logo">BrandLogo</div>
            <div class="profile">
                <img src="profile-icon.png" alt="Profile" class="profile-img">
                <a href="edit_profile.php">Edit Profile</a>
            </div>
        </div>

        <!-- Ticket Table Section -->
        <div class="tickets-table">
            <h3>Your Tickets</h3>
            <table>
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be fetched dynamically from the database -->
                    <tr>
                        <td>#001</td>
                        <td>Water Leakage</td>
                        <td><span class="status active">Active</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lift Problem</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button>View</button></td>
                    </tr>
                    
                    <!-- More ticket rows -->
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
