    <script>
        // ── Filter Pills ──
        document.querySelectorAll('.filter-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                // In real app: filter shipment cards based on selection
            });
        });
        // ── Offline Simulation (toggle with comment/uncomment) ──
        // Uncomment below to test offline banner:
        // document.getElementById('offline-banner').style.display = 'flex';
        // document.getElementById('sync-banner').style.display = 'flex';
    </script>
</body>

</html>