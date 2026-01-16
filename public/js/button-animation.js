/**
 * Animasi Tombol Interaktif
 * Menambahkan efek hover dan klik untuk semua tombol
 */

document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk menambahkan efek animasi ke elemen
    function addAnimationToElement(element) {
        // Pastikan elemen belum memiliki kelas animasi
        if (!element.classList.contains('btn-animated')) {
            element.classList.add('btn-animated');
            
            // Tambahkan event listener untuk efek hover
            element.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 6px 12px rgba(0,0,0,0.15)';
                this.style.transition = 'all 0.3s ease';
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            });
            
            // Tambahkan efek ripple saat klik
            element.addEventListener('mousedown', function(e) {
                // Hapus kelas ripple jika sudah ada
                this.classList.remove('ripple-effect');
                
                // Tambahkan kelas ripple
                this.classList.add('ripple-effect');
                
                // Hapus kelas setelah animasi selesai
                setTimeout(() => {
                    this.classList.remove('ripple-effect');
                }, 600);
            });
        }
    }
    
    // Tambahkan gaya ripple ke head
    const style = document.createElement('style');
    style.textContent = `
        .btn-animated {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .ripple-effect::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            animation: ripple-animation 0.6s linear;
        }
        
        @keyframes ripple-animation {
            to {
                width: 300px;
                height: 300px;
                opacity: 0;
            }
        }
        
        /* Tambahkan efek bounce untuk beberapa tombol penting */
        .btn-primary, .btn-success, .btn-danger {
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover, .btn-success:hover, .btn-danger:hover {
            transform: scale(1.03) !important;
        }
        
        .btn-primary:active, .btn-success:active, .btn-danger:active {
            transform: scale(0.98) !important;
        }
    `;
    document.head.appendChild(style);
    
    // Ambil semua tombol, link dengan kelas btn, dan elemen dengan atribut role="button"
    const buttons = document.querySelectorAll('button, a.btn, [role="button"], .btn, input[type="submit"], .sidebar-link');
    
    // Tambahkan animasi ke semua tombol
    buttons.forEach(addAnimationToElement);
    
    // Observer untuk menangani elemen yang ditambahkan dinamis
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) { // Element node
                    if (node.matches && 
                        (node.matches('button, a.btn, [role="button"], .btn, input[type="submit"], .sidebar-link'))) {
                        addAnimationToElement(node);
                    }
                    
                    // Cari anak-anak yang cocok
                    const childElements = node.querySelectorAll && 
                        node.querySelectorAll('button, a.btn, [role="button"], .btn, input[type="submit"], .sidebar-link');
                    if (childElements) {
                        childElements.forEach(addAnimationToElement);
                    }
                }
            });
        });
    });
    
    // Amati perubahan DOM
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});