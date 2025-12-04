<!-- resources/views/components/alert.blade.php -->
@if(session('success'))
    <div class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 1000; min-width: 300px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.style.display='none'" 
                    style="background: none; border: none; font-size: 20px; cursor: pointer; color: #155724;">
                &times;
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error" style="position: fixed; top: 20px; right: 20px; z-index: 1000; min-width: 300px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.parentElement.style.display='none'" 
                    style="background: none; border: none; font-size: 20px; cursor: pointer; color: #721c24;">
                &times;
            </button>
        </div>
    </div>
@endif

<script>
    // Auto-ocultar alertas después de 5 segundos
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>