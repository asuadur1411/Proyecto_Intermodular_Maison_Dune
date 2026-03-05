<x-guest-layout>
    <section class="login">
        <div class="login-container">

            <div class="login-header">
                <span class="login-label">Join Us</span>
                <h1>Create Account</h1>
                <div class="line"></div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="johndoe" required autofocus>
                    @error('name')
                        <span
                            style="color: var(--beige-text); font-size: 11px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="johndoe@gmail.com" required>
                    @error('email')
                        <span
                            style="color: var(--beige-text); font-size: 11px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password">
                    @error('password')
                        <span
                            style="color: var(--beige-text); font-size: 11px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="login-options">
                    <div class="form-checkbox"
                        style="display: flex !important; align-items: center !important; gap: 10px !important;">
                        <input type="checkbox" id="privacy" name="privacy" required
                            style="flex-shrink: 0 !important; width: 14px !important; height: 14px !important; margin: 0 !important; cursor: pointer;">

                        <label for="privacy"
                            style="display: inline-block !important; width: auto !important; white-space: normal !important; margin: 0 !important; line-height: 1.2;">
                            I have read and accept the <a href="#"
                                style="display: inline !important; color: var(--beige-text) !important; text-decoration: underline !important; padding: 0;">Privacy
                                Policy</a>
                        </label>
                    </div>
                    @error('privacy')
                        <span style="color: var(--beige-text); font-size: 11px; margin-top: 5px; display: block;">You must
                            accept the privacy policy.</span>
                    @enderror
                </div>

                <button type="submit">Create Account</button>

                <p class="login-redirect">Already have an account?
                    <a href="{{ route('login') }}">Sign In</a>
                </p>

            </form>
        </div>
    </section>
</x-guest-layout>
