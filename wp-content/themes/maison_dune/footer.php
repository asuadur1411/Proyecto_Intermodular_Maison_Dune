   <footer>
       
    </footer>
    <?php wp_footer(); ?>
    
    <!--PARTE DE LAS COOKIES-->

    <style>
        /* Importación de las fuentes del proyecto */
        @import url("https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap");

        #md-cookie-root {
            --gold: #DAA520;
            --deep-bg: #0d0d0d;
            --glass-bg: rgba(13, 13, 13, 0.98);
        }

        /* Banner Principal - Estilo Palacio */
        #cookie-banner {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            color: #fff;
            padding: 40px 60px;
            z-index: 99999;
            box-shadow: 0 -10px 40px rgba(0,0,0,0.8);
            border-top: 3px solid var(--gold);
            display: none;
            /* Patrón geométrico árabe sutil de fondo */
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M30 0l2.5 12.5L45 15l-12.5 2.5L30 30l-2.5-12.5L15 15l12.5-2.5L30 0z" fill="%23daa520" fill-opacity="0.04"/%3E%3C/svg%3E');
        }

        #cookie-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--gold);
            margin: 0 0 10px 0;
            font-weight: 500;
            letter-spacing: 1px;
        }

        #cookie-banner p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            line-height: 1.5;
            color: #d1d1d1;
            margin-bottom: 25px;
            max-width: 850px;
        }

        /* Botones de Alta Clase */
        .md-btn {
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 11px;
            font-weight: 600;
            padding: 15px 35px;
            cursor: pointer;
            transition: all 0.4s ease;
            border: none;
        }

        .btn-accept {
            background: var(--gold);
            color: #000;
            box-shadow: 0 4px 15px rgba(218, 165, 32, 0.2);
        }
        .btn-accept:hover {
            background: #f0c040;
            transform: translateY(-2px);
        }

        .btn-config {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
            margin-right: 15px;
        }
        .btn-config:hover {
            background: rgba(218, 165, 32, 0.1);
            color: #fff;
        }

        .btn-reject {
            background: transparent;
            color: #777;
            font-size: 10px;
            text-decoration: underline;
            margin-right: 20px;
        }

        /* Modal de Configuración Profunda */
        #cookie-modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.95); z-index: 100000;
        }

        .modal-inner {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background: #111; width: 90%; max-width: 650px; padding: 50px;
            border: 1px solid rgba(218, 165, 32, 0.3);
            box-shadow: 0 0 50px rgba(0,0,0,0.5);
        }

        .modal-inner h3 {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            color: var(--gold);
            text-align: center;
            margin-bottom: 40px;
        }

        .config-row {
            display: flex; justify-content: space-between; align-items: flex-start;
            padding: 20px 0; border-bottom: 1px solid #222;
        }

        .config-row h4 {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px; color: var(--gold); margin: 0 0 5px 0;
            text-transform: uppercase; letter-spacing: 1px;
        }

        .config-row p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px; color: #888; margin: 0; line-height: 1.4;
        }

        /* Switch Custom */
        .md-switch {
            position: relative; display: inline-block; width: 44px; height: 22px; flex-shrink: 0;
        }
        .md-switch input { opacity: 0; width: 0; height: 0; }
        .slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background-color: #333; transition: .4s; border-radius: 2px; /* Más moderno/recto */
        }
        .slider:before {
            position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px;
            background-color: #fff; transition: .4s;
        }
        input:checked + .slider { background-color: var(--gold); }
        input:checked + .slider:before { transform: translateX(22px); }
        input:disabled + .slider { opacity: 0.2; }

        @media (max-width: 768px) {
            #cookie-banner { padding: 30px 20px; text-align: center; }
            .btn-group { flex-direction: column; width: 100%; gap: 15px; }
            .btn-config { margin-right: 0; width: 100%; }
            .btn-accept { width: 100%; }
        }
    </style>

    <div id="md-cookie-root">
        <div id="cookie-banner">
            <h2>La esencia de Maison Dune</h2>
            <p>En nuestro refugio de cinco estrellas, valoramos su privacidad. Utilizamos cookies para garantizar una estancia digital segura y personalizar su experiencia según la tradición de hospitalidad que nos define.</p>
            
            <div class="btn-group" style="display:flex; justify-content: flex-end; align-items: center;">
                <button id="cookie-reject" class="md-btn btn-reject">Rechazar no esenciales</button>
                <button id="cookie-config" class="md-btn btn-config">Configuración</button>
                <button id="cookie-accept" class="md-btn btn-accept">Aceptar Todo</button>
            </div>
        </div>

        <div id="cookie-modal">
            <div class="modal-inner">
                <h3>Preferencias</h3>
                
                <div class="config-row">
                    <div>
                        <h4>Cookies Necesarias</h4>
                        <p>Imprescindibles para el correcto funcionamiento del hotel digital y reservas.</p>
                    </div>
                    <label class="md-switch"><input type="checkbox" checked disabled><span class="slider"></span></label>
                </div>

                <div class="config-row">
                    <div>
                        <h4>Análisis de Estancia</h4>
                        <p>Nos ayudan a mejorar nuestros servicios analizando el uso que hace de la web.</p>
                    </div>
                    <label class="md-switch"><input type="checkbox" id="analytics"><span class="slider"></span></label>
                </div>

                <div class="config-row">
                    <div>
                        <h4>Experiencia Personalizada</h4>
                        <p>Permiten ofrecerle contenido y promociones exclusivas basadas en sus intereses.</p>
                    </div>
                    <label class="md-switch"><input type="checkbox" id="marketing"><span class="slider"></span></label>
                </div>

                <div style="margin-top: 40px; display: flex; justify-content: space-between; align-items: center;">
                    <button id="modal-close" style="background:none; border:none; color:#555; font-family:'Montserrat'; font-size:11px; cursor:pointer; text-transform:uppercase; letter-spacing: 1px;">Volver</button>
                    <button id="modal-save" class="md-btn btn-accept">Guardar Preferencias</button>
                </div>
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