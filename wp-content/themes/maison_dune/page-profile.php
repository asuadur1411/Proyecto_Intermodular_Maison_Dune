<?php
/* Template Name: User Profile Mock */
get_header();
?>

<section class="profile-section">
    <div class="profile-container" id="profile-content">

        <div class="profile-header">
            <div class="profile-avatar">
                <img id="user-avatar" src="https://ui-avatars.com/api/?name=Admin+Maison&background=383227&color=ffcf7b"
                    alt="Avatar">
            </div>
            <div class="profile-greeting">
                <span class="greeting-sub">Bienvenido de nuevo (Modo Preview)</span>
                <h1 class="greeting-name" id="user-display-name">Admin Maison</h1>
            </div>
        </div>

        <div class="profile-reservations">
            <h2>Mis Reservas</h2>
            <div class="reservations-grid">
                <div class="reservation-board">
                    <h3>Restaurante Ziryab</h3>
                    <div class="board-content empty">
                        <p>Tienes una mesa reservada para 2 personas.</p>
                        <a href="#" class="btn-reservar">Ver Detalle</a>
                    </div>
                </div>

                <div class="reservation-board">
                    <h3>Habitaciones</h3>
                    <div class="board-content empty">
                        <p>No tienes estancias activas.</p>
                        <a href="#" class="btn-reservar" style="background-color: var(--grey);">Explorar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-actions">
            <button onclick="alert('Logout simulado')" class="btn-logout"
                style="background:none; border:none; border-bottom:1px solid; cursor:pointer;">
                Cerrar Sesión
            </button>
        </div>
    </div>
</section>

<script>
    // Este bloque es solo para cuando quieras volver a conectar con Laravel
    document.addEventListener('DOMContentLoaded', function () {
        const token = localStorage.getItem('maison_token');

        if (token) {
            console.log("Detectado token, intentando conectar con Laravel...");
            // Aquí iría el fetch real que te pasé antes
        } else {
            console.log("Modo Preview: Mostrando datos locales para test de diseño.");
        }
    });
</script>

<?php get_footer(); ?>