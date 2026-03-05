<x-guest-layout>
    <section class="login">
        <div class="login-container">

            <div class="login-header">
                <span class="login-label">Welcome Back</span>
                <h1>Sign In</h1>
                <div class="line"></div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                @if ($errors->has('throttle'))
                    <div class="form-error"
                        style="color: #ffcf7b; background: rgba(99, 0, 0, 0.5); padding: 10px; margin-bottom: 20px; font-size: 11px; border: 1px solid var(--red);">
                        {{ $errors->first('throttle') }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="johndoe" required autofocus>
                    @error('name')
                        <span class="error-message"
                            style="color: var(--beige-text); font-size: 10px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="john.doe@example.com" required>
                    @error('email')
                        <span class="error-message"
                            style="color: var(--beige-text); font-size: 10px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="error-message"
                            style="color: var(--beige-text); font-size: 10px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="login-options">
                    <div class="form-checkbox">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label for="remember_me">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="form-submit">Sign In</button>

                <p class="login-redirect">Don't have an account?
                    <a href="{{ route('register') }}">Sign Up</a>
                </p>
            </form>

        </div>
    </section>
</x-guest-layout>
