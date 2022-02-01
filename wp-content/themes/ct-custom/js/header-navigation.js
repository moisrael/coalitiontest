document.addEventListener('DOMContentLoaded', () => {
    // Generic Parameters
    const pageContainer = document.querySelector('body>.container');
    const header = document.querySelector('.header-container');
    const headerHeight = header.offsetHeight;
    const upperSubHeader = document.querySelector('.header-container .top-header');
    const phoneNumberLinks = document.querySelectorAll('a[href^="tel:"]');
    const mobileDeviceScreen = window.matchMedia('(max-width: 768px)');
    pageContainer.style.paddingTop = `${headerHeight}px`;

    // Mobile Menu Class
    class MobileMenu {
        constructor() {
            // Parameters
            this.pageContainer = pageContainer;
            this.header = header;
            this.headerHeight = headerHeight;
            this.menuToggle = document.querySelector('.menu-toggle');
            this.mobileMenu = document.querySelector('.mobile-menu');
            this.menuContentSource = document.querySelector('.main-header .navigation-menu ul').cloneNode(true);
            this.menuContent = document.querySelector('.main-header .mobile-navigation-menu');
            
            // Generate menu content
            this.menuContent = this.menuContent.appendChild(this.menuContentSource);
            
            // Parameters (cont'd)
            this.menuDropdown = document.querySelectorAll('.main-header .mobile-navigation-menu ul .menu-item-has-children>a');
            this.subMenu = document.querySelectorAll('.main-header .mobile-navigation-menu ul .menu-item-has-children .sub-menu');
            this.dropdownIndex;
            this.isMenuOpen = false;
            this.isSubMenuOpen = false;
            // Listen for all events
            this.events();
        }

        // Events
        events() {
            // To toggle menu open or close when menu button is clicked/tapped
            this.menuToggle.addEventListener('click', () => { this.toggleMenu(); });
            this.menuDropdown.forEach(
                dropdown => {
                    dropdown.addEventListener('click', (event) => {
                        event.preventDefault();
                        
                        this.dropdownIndex = Array.from(this.menuDropdown).indexOf(event.target);
                        
                        // To show submenu when dropdown item is clicked/tapped
                        if (!this.isSubMenuOpen && !this.subMenu[this.dropdownIndex].classList.contains('active')) {
                            return this.showSubMenu(event);
                        }
                        
                        if (this.isSubMenuOpen && !this.subMenu[this.dropdownIndex].classList.contains('active')) {
                            return this.showSubMenu(event);
                        }
                        
                        // To hide submenu when dropdown item is clicked/tapped
                        if (this.dropdownIndex == 0 && this.subMenu[this.dropdownIndex].classList.contains('active')) {
                            return this.hideSubMenu(event);
                        }
                        
                        if (this.dropdownIndex >= 1 && this.subMenu[this.dropdownIndex].classList.contains('active')) {
                            return this.hideSubMenu(event);
                        }
                    });
                }
            );
        }

        // Makes the menu open
        openMenu() {
            this.mobileMenu.style = 'opacity: 1; pointer-events: auto;';
            this.menuToggle.classList.add('active');
        }

        // Makes the menu close
        closeMenu() {
            this.mobileMenu.style = 'opacity: 0; pointer-events: none;';
            this.menuToggle.classList.remove('active');
            this.menuDropdown.forEach( dropdown => dropdown.classList.remove('active') );
            this.subMenu.forEach( dropdown => dropdown.classList.remove('active') );
        }
        
        // Toggles the menu open and close
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
            this.isMenuOpen ? this.openMenu() : this.closeMenu();
        }

        // Shows submenu
        showSubMenu(event) {
            this.dropdownIndex = Array.from(this.menuDropdown).indexOf(event.target);
            this.menuDropdown[this.dropdownIndex].classList.add('active');
            this.subMenu[this.dropdownIndex].classList.add('active');
        }

        // Hides submenu
        hideSubMenu(event) {
            this.dropdownIndex = Array.from(this.menuDropdown).indexOf(event.target);
            this.menuDropdown[this.dropdownIndex].classList.remove('active');
            this.subMenu[this.dropdownIndex].classList.remove('active');
            
            if (this.dropdownIndex == 0) {
                this.menuDropdown.forEach( dropdown => dropdown.classList.remove('active') );
            }
        }
    }

    // Resizes the header
    const resizeHeader = () => {
        // Parameters
        const headerGapFromTop = pageContainer.getBoundingClientRect().top;
        const resizeHeaderAt = upperSubHeader.offsetHeight;

        // Shrinks the header
        if (headerGapFromTop < resizeHeaderAt) {
            header.classList.add('top-fix-resize');
            upperSubHeader.style = 'display: none;';
        }

        // Unshrinks the header
        if (headerGapFromTop >= 0) {
            header.classList.remove('top-fix-resize');
            upperSubHeader.style = 'display: block;';
        }
    };
    
    // Checks the screen resolution before running or cancelling the event
    const detectScreenResolution = (screenResolution, event) => {
        // Cancels the event whenever the screen resolution does not match the given resolution
        if (!screenResolution.matches) {
            phoneNumberLinks.forEach(
                phoneNumberLink => {
                    event.preventDefault();
                }
            );
        }
    };
    
    // Create mobile menu
    const mobileMenu = new MobileMenu();

    // Check header size, and adjust when necessary, every time the page is scrolled
    window.addEventListener('scroll', resizeHeader);

    // Check screen resolution and run or cancel click event
    phoneNumberLinks.forEach(
        phoneNumberLink => {
            phoneNumberLink.addEventListener('click', event => { detectScreenResolution(mobileDeviceScreen, event) });
        }
    );
});