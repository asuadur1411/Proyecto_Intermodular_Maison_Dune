<?php get_header(); ?>

<section class="login">
    <div class="login-container">

        <div class="login-header">
            <span class="login-label">Welcome Back</span>
            <h1>Sign In</h1>
            <div class="line"></div>
        </div>

        <form id="login-form" class="login-form">

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="johndoe" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="johndoe@gmail.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="" required>
            </div>

            <div class="login-options">
                <div class="form-checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit">Sign In</button>

            <p class="login-redirect">Don't have an account? <a
                    href="<?php echo get_permalink(get_page_by_path('register')); ?>">Sign Up</a></p>
        </form>

    </div>
</section>

<?php get_footer(); ?>