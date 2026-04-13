<?php
/* Template Name: User Profile Mock */
get_header();
?>

<section class="profile-section">
    <div class="profile-container" id="profile-content">

        <div class="profile-header">
            <div class="profile-avatar">
                <img id="user-avatar" src="" alt="Avatar">
            </div>
            <div class="profile-greeting">
                <span class="greeting-sub">Welcome back</span>
                <h1 class="greeting-name" id="user-display-name"></h1>
            </div>
        </div>

        <div class="profile-reservations">
            <h2>My Reservations</h2>
            <div id="reservations-list" class="reservations-grid">
                <div class="reservations-loading">
                    <span class="loader-dot"></span>
                    <span class="loader-dot"></span>
                    <span class="loader-dot"></span>
                </div>
            </div>
        </div>

        <div class="profile-actions">
            <button id="logout-btn" class="btn-logout">
                Log Out
            </button>
        </div>
    </div>
</section>

<?php get_footer(); ?>