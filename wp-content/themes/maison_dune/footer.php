   <footer>
       
    </footer>
    <?php wp_footer(); ?>

    <div id="cookie-banner">
        <h2>The Essence of Maison Dune</h2>
        <p>We use cookies to ensure a safe browsing experience and personalize your stay according to the hospitality tradition that defines us.</p>
        <div class="cookie-buttons">
            <button id="cookie-reject" class="cookie-btn-reject">Reject non-essential</button>
            <button id="cookie-config" class="cookie-btn cookie-btn-config">Settings</button>
            <button id="cookie-accept" class="cookie-btn cookie-btn-accept">Accept All</button>
        </div>
    </div>

    <div id="cookie-modal">
        <div class="cookie-modal-content">
            <h3>Preferences</h3>

            <div class="cookie-config-row">
                <div>
                    <h3>Essential Cookies</h3>
                    <p>Required for the proper functioning of the website and reservations.</p>
                </div>
                <label class="cookie-switch"><input type="checkbox" checked disabled><span class="cookie-slider"></span></label>
            </div>

            <div class="cookie-config-row">
                <div>
                    <h3>Analytics</h3>
                    <p>Help us improve our services by analyzing how you use the website.</p>
                </div>
                <label class="cookie-switch"><input type="checkbox" id="analytics"><span class="cookie-slider"></span></label>
            </div>

            <div class="cookie-config-row">
                <div>
                    <h3>Personalized Experience</h3>
                    <p>Allow us to offer you exclusive content and promotions based on your interests.</p>
                </div>
                <label class="cookie-switch"><input type="checkbox" id="marketing"><span class="cookie-slider"></span></label>
            </div>

            <div class="cookie-modal-actions">
                <button id="modal-close" class="cookie-btn-back">Back</button>
                <button id="modal-save" class="cookie-btn cookie-btn-accept">Save Preferences</button>
            </div>
        </div>
    </div>

    <script>
        function setCookie(name, value, days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            document.cookie = name + "=" + value + "; expires=" + date.toUTCString() + "; path=/; SameSite=Lax";
        }

        function getCookie(name) {
            let value = `; ${document.cookie}`;
            let parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const banner = document.getElementById('cookie-banner');
            const modal = document.getElementById('cookie-modal');
            
            if (!getCookie('maison_consent')) {
                banner.style.display = 'block';
            }

            document.getElementById('cookie-accept').onclick = () => {
                setCookie('maison_consent', 'all', 365);
                banner.style.display = 'none';
            };

            document.getElementById('cookie-reject').onclick = () => {
                setCookie('maison_consent', 'essential', 365);
                banner.style.display = 'none';
            };

            document.getElementById('cookie-config').onclick = () => {
                modal.style.display = 'block';
            };

            document.getElementById('modal-close').onclick = () => {
                modal.style.display = 'none';
            };

            document.getElementById('modal-save').onclick = () => {
                let prefs = ['essential'];
                if (document.getElementById('analytics').checked) prefs.push('analytics');
                if (document.getElementById('marketing').checked) prefs.push('marketing');
                setCookie('maison_consent', prefs.join(','), 365);
                modal.style.display = 'none';
                banner.style.display = 'none';
            };
        });
    </script>
</body>
</html>