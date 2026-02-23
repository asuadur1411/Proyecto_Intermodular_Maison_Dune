<?php get_header(); ?>

<section class="login">
  <div class="login-container">

    <div class="login-header">
      <span class="login-label">Join Us</span>
      <h1>Create Account</h1>
      <div class="line"></div>
    </div>

    <form id="register-form" class="login-form">

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

      <div class="form-group">
        <label for="password_confirm">Confirm Password</label>
        <input type="password" id="password_confirm" name="password_confirm" placeholder="" required>
      </div>

      <div class="form-checkbox">
        <input type="checkbox" id="privacy" name="privacy" required>
        <label for="privacy">I have read and accept the <a href="#">Privacy Policy</a></label>
      </div>

      <button type="submit">Create Account</button>

      <p class="login-redirect">Already have an account? <a href="<?php echo get_permalink(get_page_by_path('login')); ?>">Sign In</a></p>

    </form>

  </div>
</section>

<?php get_footer(); ?>