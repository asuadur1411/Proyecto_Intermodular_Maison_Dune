<?php get_header(); ?>

<section class="login">
    <div class="login-container">

        <div class="login-header">
            <span class="login-label">Account Recovery</span>
            <h1>Forgot Password</h1>
            <div class="line"></div>
        </div>

        <form id="forgot-password-form" class="login-form">

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="johndoe@gmail.com" required>
            </div>

            <button type="submit">Send Reset Link</button>

            <p class="login-redirect">Remember your password? <a
                    href="<?php echo get_permalink(get_page_by_path('login')); ?>">Sign In</a></p>
        </form>

    </div>
</section>

<?php get_footer(); ?>