<?php get_header(); ?>

<section class="login">
    <div class="login-container">

        <div class="login-header">
            <span class="login-label">Account Recovery</span>
            <h1>New Password</h1>
            <div class="line"></div>
        </div>

        <form id="reset-password-form" class="login-form">

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm New Password</label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="" required>
            </div>

            <button type="submit">Reset Password</button>

            <p class="login-redirect">Remember your password? <a
                    href="<?php echo get_permalink(get_page_by_path('login')); ?>">Sign In</a></p>
        </form>

    </div>
</section>

<?php get_footer(); ?>