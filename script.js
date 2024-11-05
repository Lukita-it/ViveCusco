document.addEventListener("DOMContentLoaded", function() {
            var loginButton = document.getElementById("loginButton");
            if (loginButton) {
                loginButton.addEventListener("click", function() {
                    window.location.href = "../login/logout.php";
                });
            }

            var menuButton = document.getElementById("menuButton");
            if (menuButton) {
                menuButton.addEventListener("click", function() {
                    var sidebar = document.getElementById('sidebar');
                    sidebar.classList.toggle('closed');
                });
            }

            // Función para ocultar el sidebar en pantallas pequeñas
            function checkSidebar() {
                var sidebar = document.getElementById('sidebar');
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('open');
                } else {
                    sidebar.classList.remove('open');
                }
            }

            checkSidebar(); // Comprobar el tamaño de la pantalla al cargar

            window.addEventListener('resize', checkSidebar); // Comprobar el tamaño de la pantalla al cambiar el tamaño
});