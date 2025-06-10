// Fix for mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit to ensure all elements are loaded
    setTimeout(function() {
        const menuToggle = document.getElementById('menuToggle');
        const closeMenu = document.getElementById('closeMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        
        console.log('Mobile menu elements:', { menuToggle, closeMenu, mobileMenu }); // Debug log
        
        function closeMobileMenu() {
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
        
        function openMobileMenu() {
            if (mobileMenu) {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
        
        if (menuToggle) {
            // Remove any existing event listeners by cloning the element
            const newMenuToggle = menuToggle.cloneNode(true);
            menuToggle.parentNode.replaceChild(newMenuToggle, menuToggle);
            
            newMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Menu toggle clicked'); // Debug log
                openMobileMenu();
            });
        }
        
        if (closeMenu) {
            closeMenu.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Close menu clicked'); // Debug log
                closeMobileMenu();
            });
        }
        
        if (mobileMenu) {
            mobileMenu.addEventListener('click', function(e) {
                // Close only if clicking on the backdrop
                if (e.target === mobileMenu) {
                    closeMobileMenu();
                }
            });
            
            // Close menu when a menu item is clicked
            const menuItems = mobileMenu.querySelectorAll('a');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    setTimeout(closeMobileMenu, 100);
                });
            });
        }
    }, 100);
});
