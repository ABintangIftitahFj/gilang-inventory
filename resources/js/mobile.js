// Mobile navigation enhancements for Gilang Inventory
document.addEventListener('DOMContentLoaded', function() {
    // Add "Back Button" functionality for all internal pages
    const addBackButton = () => {
        // Skip on dashboard page
        if (window.location.pathname === '/' || 
            window.location.pathname === '/dashboard' || 
            document.querySelector('.back-button-container')) {
            return;
        }
        
        const mainContent = document.querySelector('main > div');
        if (mainContent) {
            // Create back button element
            const backButton = document.createElement('div');
            backButton.classList.add('back-button-container', 'lg:hidden', 'mb-3');
            backButton.innerHTML = `
                <a href="javascript:history.back()" class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            `;
            
            // Add it to the beginning of the main content
            mainContent.insertBefore(backButton, mainContent.firstChild);
        }
    };
    
    // Fix sidebar navigation issues on mobile
    const enhanceMobileNavigation = () => {
        const sidebarNav = document.getElementById('sidebar-nav');
        const mobileMenu = document.getElementById('mobileMenu');
        
        // If sidebar exists but has no links visible on mobile
        if (sidebarNav && window.innerWidth < 768) {
            const sidebarLinks = sidebarNav.querySelectorAll('a');
            
            // Add proper styling to ensure links are visible on mobile
            sidebarLinks.forEach(link => {
                if (link.classList.contains('hidden')) {
                    link.classList.remove('hidden');
                    link.classList.add('block');
                }
            });
        }
        
        // Fix mobile menu overlay if it exists
        if (mobileMenu) {
            // Ensure the mobile menu has proper height and scrolling
            const mobileMenuContent = mobileMenu.querySelector('div.absolute');
            if (mobileMenuContent) {
                mobileMenuContent.classList.add('overflow-y-auto', 'max-h-[85vh]');
            }
        }
    };
    
    // Improve form inputs on mobile
    const enhanceMobileInputs = () => {
        const inputs = document.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Add better tap target size for mobile
            if (window.innerWidth < 768 && !input.classList.contains('mobile-enhanced')) {
                input.classList.add('mobile-enhanced');
                input.style.minHeight = '42px';
                
                // Add better focus styling
                input.addEventListener('focus', () => {
                    input.classList.add('ring-2', 'ring-blue-300');
                });
                
                input.addEventListener('blur', () => {
                    input.classList.remove('ring-2', 'ring-blue-300');
                });
            }
        });
    };
    
    // Run the enhancements
    addBackButton();
    enhanceMobileNavigation();
    enhanceMobileInputs();
    
    // Also run when screen is resized
    window.addEventListener('resize', enhanceMobileNavigation);
});
