/**
 * Hidden Lanka - Main Client Script
 */

document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('.header-site');
  const menuToggle = document.querySelector('.menu-toggle');
  const mobileNav = document.querySelector('.mobile-nav');

  // Sticky header scroll shadow
  if (header) {
    const handleScroll = () => {
      if (window.scrollY > 30) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    };
    
    window.addEventListener('scroll', handleScroll);
    // Run once on load to catch initial state
    handleScroll();
  }

  // Mobile menu toggle
  if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', () => {
      const isOpen = mobileNav.classList.contains('open');
      if (isOpen) {
        mobileNav.classList.remove('open');
        menuToggle.setAttribute('aria-expanded', 'false');
      } else {
        mobileNav.classList.add('open');
        menuToggle.setAttribute('aria-expanded', 'true');
      }
    });

    // Close mobile nav when clicking any link inside it
    const mobileLinks = mobileNav.querySelectorAll('a');
    mobileLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileNav.classList.remove('open');
        menuToggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Page exit transition (SPA style animation with top progress bar & exit fade)
  const links = document.querySelectorAll('a');
  links.forEach(link => {
    const href = link.getAttribute('href');
    const target = link.getAttribute('target');
    
    if (
      href && 
      !href.startsWith('#') && 
      !href.startsWith('tel:') && 
      !href.startsWith('mailto:') && 
      !href.startsWith('javascript:') && 
      !href.includes('wa.me') &&
      (!target || target === '_self') &&
      link.hostname === window.location.hostname
    ) {
      link.addEventListener('click', (e) => {
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.button === 1) return;
        
        // If href was dynamically removed, skip transition
        if (!link.getAttribute('href')) return;
        
        // Check if it's the same page with a different hash (anchor link)
        try {
          const targetUrlObj = new URL(link.href);
          const currentUrlObj = new URL(window.location.href);
          targetUrlObj.hash = '';
          currentUrlObj.hash = '';
          if (targetUrlObj.href === currentUrlObj.href) {
            return;
          }
        } catch (err) {
          // Fallback if URL parsing fails
        }
        
        e.preventDefault();
        const targetUrl = link.href;
        
        // 1. Inject & animate the top loading progress bar
        const bar = document.createElement('div');
        bar.id = 'transition-bar';
        document.body.appendChild(bar);
        
        setTimeout(() => {
          bar.style.width = '75%';
        }, 10);
        
        // 2. Add page exit class to fade out content
        document.body.classList.add('page-exit-active');
        
        // 3. Navigate after exit transitions complete (600ms)
        setTimeout(() => {
          window.location.href = targetUrl;
        }, 600);
      });
    }
  });

  // Intersection Observer for scroll-reveal animations
  const revealElements = document.querySelectorAll('.reveal');
  if (revealElements.length > 0) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          // Unobserve after animating in to optimize performance
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -30px 0px' // Triggers slightly before element crosses the viewport edge
    });

    revealElements.forEach(element => {
      revealObserver.observe(element);
    });
  }

  // Authentic Island & Village Experiences Mobile Slideshow
  const experiencesSlider = document.getElementById('experiencesSlider');
  if (experiencesSlider) {
    const cards = experiencesSlider.querySelectorAll('.experience-card');
    const prevBtn = document.getElementById('expPrevBtn');
    const nextBtn = document.getElementById('expNextBtn');
    const dots = document.querySelectorAll('#expPagination .exp-dot');
    let currentIndex = 0;
    let autoSlideTimer = null;
    let isUserInteracting = false;

    const updateDots = (index) => {
      dots.forEach((dot, idx) => {
        if (idx === index) {
          dot.classList.add('active');
        } else {
          dot.classList.remove('active');
        }
      });
    };

    const scrollToCard = (index) => {
      if (cards.length === 0) return;
      if (index < 0) index = cards.length - 1;
      if (index >= cards.length) index = 0;
      currentIndex = index;

      const targetCard = cards[currentIndex];
      if (targetCard) {
        experiencesSlider.scrollTo({
          left: targetCard.offsetLeft - experiencesSlider.offsetLeft,
          behavior: 'smooth'
        });
      }
      updateDots(currentIndex);
    };

    // Next / Prev button listeners
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        scrollToCard(currentIndex - 1);
        resetAutoPlay();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        scrollToCard(currentIndex + 1);
        resetAutoPlay();
      });
    }

    // Dot navigation
    dots.forEach((dot, idx) => {
      dot.addEventListener('click', () => {
        scrollToCard(idx);
        resetAutoPlay();
      });
    });

    // Sync dots on swipe / manual scroll
    let scrollTimeout;
    experiencesSlider.addEventListener('scroll', () => {
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        const scrollLeft = experiencesSlider.scrollLeft;
        let closestIdx = 0;
        let minDiff = Infinity;
        cards.forEach((card, i) => {
          const diff = Math.abs((card.offsetLeft - experiencesSlider.offsetLeft) - scrollLeft);
          if (diff < minDiff) {
            minDiff = diff;
            closestIdx = i;
          }
        });
        currentIndex = closestIdx;
        updateDots(currentIndex);
      }, 60);
    }, { passive: true });

    // Auto Play Slideshow for mobile
    const startAutoPlay = () => {
      if (autoSlideTimer) clearInterval(autoSlideTimer);
      autoSlideTimer = setInterval(() => {
        if (window.innerWidth <= 992 && !isUserInteracting) {
          scrollToCard(currentIndex + 1);
        }
      }, 4000);
    };

    const resetAutoPlay = () => {
      isUserInteracting = true;
      if (autoSlideTimer) clearInterval(autoSlideTimer);
      setTimeout(() => {
        isUserInteracting = false;
        startAutoPlay();
      }, 6000);
    };

    experiencesSlider.addEventListener('touchstart', () => { isUserInteracting = true; }, { passive: true });
    experiencesSlider.addEventListener('touchend', () => {
      setTimeout(() => { isUserInteracting = false; }, 4000);
    }, { passive: true });

    startAutoPlay();
  }

  // Admin Sidebar Mobile Menu Toggle
  const adminMenuToggleBtn = document.getElementById('adminMenuToggleBtn');
  const adminNavCollapse = document.getElementById('adminNavCollapse');
  if (adminMenuToggleBtn && adminNavCollapse) {
    adminMenuToggleBtn.addEventListener('click', () => {
      const isExpanded = adminNavCollapse.classList.contains('open');
      if (isExpanded) {
        adminNavCollapse.classList.remove('open');
        adminMenuToggleBtn.classList.remove('open');
        adminMenuToggleBtn.setAttribute('aria-expanded', 'false');
      } else {
        adminNavCollapse.classList.add('open');
        adminMenuToggleBtn.classList.add('open');
        adminMenuToggleBtn.setAttribute('aria-expanded', 'true');
      }
    });
  }
});

// On window load: complete progress bar (if exists)
window.addEventListener('load', () => {
  const bar = document.getElementById('transition-bar');
  if (bar) {
    bar.style.width = '100%';
    setTimeout(() => {
      bar.style.opacity = '0';
      setTimeout(() => {
        bar.remove();
      }, 500);
    }, 300);
  }
});

// Handle BFCache (back-forward browser cache state recovery)
window.addEventListener('pageshow', () => {
  document.body.classList.remove('page-exit-active');
  const bar = document.getElementById('transition-bar');
  if (bar) bar.remove();
});

