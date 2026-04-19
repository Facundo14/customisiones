    <footer class="bg-woodar-text dark:bg-woodar-dark text-woodar-bg p-8 text-center mt-auto transition-colors duration-500">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados.</p>
    </footer>
    <?php wp_footer(); ?>
    <script>
      // Lógica de click para el botón toggle
      const themeToggleBtn = document.getElementById('theme-toggle-btn');
      if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function() {
          if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
          } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
          }
        });
      }
    </script>
</body>
</html>
