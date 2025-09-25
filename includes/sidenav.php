    <div class="sidebar">
        <div class="sidebar-header">
            <img src="./assets/images/logo.png" alt="logo" />
            <h2>RPL</h2>
        </div>
        <ul class="sidebar-links">
            <h4>
                <span>Main Menu</span>
                <div class="menu-separator"></div>
            </h4>
            <li>
                <a href="./user_dashboard.php">
                    <span class="material-symbols-outlined">
                        dashboard
                    </span>Home
                </a>
            </li>
            <li>
                <a href="./raise_ticket.php">
                    <span class="material-symbols-outlined">
                        overview
                    </span>Raise Ticket
                </a>
            </li>
            <!-- <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        monitoring
                    </span>Analytics
                </a>
            </li> -->
            <!-- <h4>
                <span>General</span>
                <div class="menu-separator"></div>
            </h4> -->
            <!-- <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        folder
                    </span>Projects
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        groups
                    </span>Groups
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        move_up
                    </span>Transfer
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        flag
                    </span>All Reports
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        notifications_active
                    </span>Notifications
                </a>
            </li> -->
            <h4>
                <span>Account</span>
                <div class="menu-separator"></div>

            </h4>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>Profile
                </a>
            </li>
            <!-- <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        settings
                    </span>Settings
                </a>
            </li> -->
            <li>
                <a href="./logout.php">
                    <span class="material-symbols-outlined">
                        logout
                    </span>Logout
                </a>
            </li>
        </ul>
        <div class="user-account">
            <div class="user-profile">
                <img src="./assets/images/profile.png" alt="">
                <div class="user-details">
                    <h3 style="text-transform: capitalize;"><?=h($user['name'])?></h3>
                    <!-- <span>Web Developer</span> -->
                </div>
            </div>
        </div>
    </div>