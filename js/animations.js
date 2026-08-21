;(function () {
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  const isMobile = window.matchMedia('(max-width: 767px)').matches
  const isCoarsePointer = window.matchMedia('(hover: none) and (pointer: coarse)').matches

  if (reduced) {
    document.documentElement.classList.add('reduce-motion')
    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-fade').forEach((el) => {
      el.classList.add('revealed')
    })
    return
  }

  /* ── Scroll progress bar ── */
  function initScrollProgress() {
    const bar = document.createElement('div')
    bar.id = 'scroll-progress'
    bar.setAttribute('aria-hidden', 'true')
    document.body.prepend(bar)

    window.addEventListener(
      'scroll',
      () => {
        const doc = document.documentElement
        const scrolled = doc.scrollTop
        const height = doc.scrollHeight - doc.clientHeight
        bar.style.width = height > 0 ? `${(scrolled / height) * 100}%` : '0%'
      },
      { passive: true }
    )
  }

  /* ── Scroll reveal ── */
  function initReveal() {
    const groups = [
      { parent: '#home > div.relative.max-w-7xl > div:first-child', children: '> *', stagger: 0.12 },
      { parent: '#home .hero-stats', children: '> div', stagger: 0.15 },
      { parent: '#home .relative.animate-float', children: null, cls: 'reveal-scale', delay: 0.3 },
      { parent: '#about > div > div > div:first-child', children: '> *', stagger: 0.1 },
      { parent: '#about .grid.grid-cols-2', children: '> div', stagger: 0.08 },
      { parent: '#about .about-media-wrap', children: null, cls: 'reveal-right', delay: 0.2 },
      { parent: '#service .text-center', children: '> *', stagger: 0.1 },
      { parent: '#service .grid', children: '> div', stagger: 0.08 },
      { parent: '#testimonial > div:first-child', children: '> *', stagger: 0.1 },
      { parent: '#testimonial .space-y-4', children: '> div', stagger: 0.12 },
      { parent: '#partnership > div:first-child', children: '> *', stagger: 0.1 },
      { parent: '#partnership .grid', children: '> div', stagger: 0.06 },
      { parent: '#partnership .mt-6', children: null, cls: 'reveal-fade', delay: 0.4 },
      { parent: '#graphic .text-center', children: '> *', stagger: 0.1 },
      { parent: '#graphic .grid', children: '> div', stagger: 0.08 },
      { parent: '#faq .text-center', children: '> *', stagger: 0.1 },
      { parent: '#faq-list', children: '> div', stagger: 0.08 },
      { parent: 'footer .max-w-7xl > div', children: '> *', stagger: 0.1 },
      { parent: 'section .text-center.mb-10', children: '> *', stagger: 0.1 },
      { parent: 'section .text-center.mb-16', children: '> *', stagger: 0.1 },
      { parent: '.lg\\:col-span-2.space-y-6', children: '> div', stagger: 0.1 },
      { parent: '#contact-form', children: '> *', stagger: 0.06 },
      { parent: 'section .mb-8.rounded-2xl', children: null, cls: 'reveal-scale' },
    ]

    const seen = new Set()

    groups.forEach(({ parent, children, stagger, cls, delay }) => {
      document.querySelectorAll(parent).forEach((container) => {
        const targets = children ? container.querySelectorAll(children) : [container]
        targets.forEach((el, i) => {
          if (seen.has(el)) return
          seen.add(el)
          el.classList.add(cls || (i % 2 === 0 ? 'reveal' : 'reveal'))
          const d = delay != null ? delay + i * (stagger || 0) : i * (stagger || 0)
          el.style.setProperty('--reveal-delay', `${d}s`)
        })
      })
    })

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return
          entry.target.classList.add('revealed')
          observer.unobserve(entry.target)
        })
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    )

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-fade').forEach((el) => {
      observer.observe(el)
    })
  }

  /* ── Hero load entrance ── */
  function initHeroEntrance() {
    const hero = document.getElementById('home')
    if (!hero) return

    hero.querySelectorAll('.animate-float').forEach((el) => {
      el.classList.add('hero-enter')
    })

    hero.querySelectorAll('.absolute.-top-4, .absolute.bottom-4, .absolute.top-1\\/2').forEach((tag, i) => {
      tag.classList.add('hero-tag')
      tag.style.animationDelay = `${0.8 + i * 0.2}s`
    })
  }

  /* ── Counter animation ── */
  function initCounters() {
    const counters = document.querySelectorAll('[data-count]')
    if (!counters.length) return

    const animate = (el) => {
      const target = parseFloat(el.dataset.count)
      const suffix = el.dataset.suffix || ''
      const prefix = el.dataset.prefix || ''
      const decimals = (el.dataset.decimals && parseInt(el.dataset.decimals, 10)) || 0
      const duration = 1800
      const start = performance.now()

      const step = (now) => {
        const progress = Math.min((now - start) / duration, 1)
        const eased = 1 - Math.pow(1 - progress, 3)
        const value = target * eased
        el.textContent = prefix + (decimals ? value.toFixed(decimals) : Math.floor(value)) + suffix
        if (progress < 1) requestAnimationFrame(step)
      }

      requestAnimationFrame(step)
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return
          animate(entry.target)
          observer.unobserve(entry.target)
        })
      },
      { threshold: 0.5 }
    )

    counters.forEach((el) => observer.observe(el))
  }

  /* ── Progress bars ── */
  function initProgressBars() {
    const bars = document.querySelectorAll('.progress-fill')
    if (!bars.length) return

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return
          const width = entry.target.dataset.width || '0'
          entry.target.style.width = `${width}%`
          observer.unobserve(entry.target)
        })
      },
      { threshold: 0.3 }
    )

    bars.forEach((bar) => observer.observe(bar))
  }

  /* ── Typing terminal ── */
  function initTyping() {
    const terminal = document.querySelector('.terminal-type')
    if (!terminal) return

    const lines = terminal.querySelectorAll('.terminal-line')
    let delay = 400

    lines.forEach((line, i) => {
      line.style.opacity = '0'
      setTimeout(() => {
        line.style.opacity = '1'
        line.classList.add('terminal-visible')
      }, delay)
      delay += 280 + i * 80
    })
  }

  /* ── Nav scroll spy ── */
  function initNavSpy() {
    const sections = document.querySelectorAll('section[id]')
    const links = document.querySelectorAll('.nav-link[href^="#"]')
    if (!sections.length || !links.length) return

    const map = new Map()
    links.forEach((link) => {
      const id = link.getAttribute('href')?.slice(1)
      if (id) map.set(id, link)
    })

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return
          const id = entry.target.id
          links.forEach((l) => l.classList.remove('nav-active'))
          map.get(id)?.classList.add('nav-active')
        })
      },
      { threshold: 0.35, rootMargin: '-80px 0px -50% 0px' }
    )

    sections.forEach((s) => observer.observe(s))
  }

  /* ── Parallax orbs ── */
  function initParallax() {
    const orbs = document.querySelectorAll('.parallax-orb')
    if (!orbs.length || isMobile) return

    window.addEventListener(
      'scroll',
      () => {
        const y = window.scrollY
        orbs.forEach((orb, i) => {
          const speed = 0.08 + i * 0.04
          orb.style.transform = `translateY(${y * speed}px)`
        })
      },
      { passive: true }
    )
  }

  /* ── Floating particles (hero) ── */
  function initParticles() {
    const canvas = document.getElementById('particle-canvas')
    if (!canvas) return

    const ctx = canvas.getContext('2d')
    let w, h, particles

    function resize() {
      w = canvas.width = canvas.offsetWidth
      h = canvas.height = canvas.offsetHeight
      const count = isMobile ? 20 : 50
      particles = Array.from({ length: count }, () => ({
        x: Math.random() * w,
        y: Math.random() * h,
        r: Math.random() * 1.5 + 0.5,
        dx: (Math.random() - 0.5) * 0.4,
        dy: (Math.random() - 0.5) * 0.4,
        o: Math.random() * 0.5 + 0.2,
      }))
    }

    function draw() {
      ctx.clearRect(0, 0, w, h)
      const isLight = document.documentElement.classList.contains('light')
      ctx.fillStyle = isLight ? 'rgba(8, 145, 178, 0.6)' : 'rgba(0, 240, 255, 0.6)'

      particles.forEach((p) => {
        ctx.globalAlpha = p.o
        ctx.beginPath()
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2)
        ctx.fill()
        p.x += p.dx
        p.y += p.dy
        if (p.x < 0 || p.x > w) p.dx *= -1
        if (p.y < 0 || p.y > h) p.dy *= -1
      })

      requestAnimationFrame(draw)
    }

    resize()
    draw()
    window.addEventListener('resize', resize)
  }

  /* ── Button 3D ── */
  function initButton3D() {
    document.querySelectorAll('.btn-shine').forEach((btn) => {
      btn.classList.add('btn-3d')
      if (btn.classList.contains('bg-cyan-400')) btn.classList.add('btn-3d-primary')
      else if (btn.classList.contains('neon-border')) btn.classList.add('btn-3d-outline')
    })

    document.querySelectorAll('.lang-toggle-btn, .theme-toggle-btn').forEach((btn) => {
      btn.classList.add('btn-3d', 'btn-3d-icon')
    })

    document.querySelectorAll('[data-btn-3d]').forEach((btn) => {
      btn.classList.add('btn-3d', btn.dataset.btn3d || 'btn-3d-link')
    })

    if (isCoarsePointer || reduced) return

    const tiltButtons = document.querySelectorAll('.btn-3d')
    const maxTilt = isMobile ? 6 : 10

    tiltButtons.forEach((btn) => {
      if (btn.dataset.btn3dBound) return
      btn.dataset.btn3dBound = '1'

      const onMove = (e) => {
        const rect = btn.getBoundingClientRect()
        const clientX = e.touches ? e.touches[0].clientX : e.clientX
        const clientY = e.touches ? e.touches[0].clientY : e.clientY
        const x = (clientX - rect.left) / rect.width - 0.5
        const y = (clientY - rect.top) / rect.height - 0.5
        const isPrimary = btn.classList.contains('btn-3d-primary')
        const lift = isPrimary ? 14 : 10

        btn.style.transform = `perspective(700px) translateY(-${lift * 0.35}px) translateZ(${lift}px) rotateX(${-y * maxTilt}deg) rotateY(${x * maxTilt}deg)`
        btn.classList.add('tilt-active')

        if (btn.classList.contains('btn-shine')) {
          btn.style.setProperty('--shine-x', `${clientX - rect.left}px`)
          btn.style.setProperty('--shine-y', `${clientY - rect.top}px`)
        }
      }

      const onLeave = () => {
        btn.style.transform = ''
        btn.classList.remove('tilt-active')
      }

      if (isCoarsePointer) {
        btn.addEventListener('touchstart', onMove, { passive: true })
        btn.addEventListener('touchend', onLeave)
      } else {
        btn.addEventListener('mousemove', onMove)
        btn.addEventListener('mouseleave', onLeave)
      }
    })
  }

  /* ── Navbar slide-in on load ── */
  function initNavbar() {
    const nav = document.getElementById('navbar')
    if (nav) nav.classList.add('nav-enter')
  }

  /* ── Mobile menu stagger ── */
  function initMobileMenuAnim() {
    const menu = document.getElementById('mobile-menu')
    const btn = document.getElementById('menu-btn')
    if (!menu || !btn) return

    const links = menu.querySelectorAll('a')
    btn.addEventListener('click', () => {
      if (menu.classList.contains('open')) {
        links.forEach((link, i) => {
          link.style.setProperty('--menu-delay', `${i * 0.05}s`)
          link.classList.add('menu-link-enter')
        })
      } else {
        links.forEach((link) => link.classList.remove('menu-link-enter'))
      }
    })
  }

  /* ── 3D card wrap ── */
  function init3DCardWrap() {
    document.querySelectorAll('.tilt-card').forEach((card) => {
      if (card.dataset.tiltWrapped) return
      card.dataset.tiltWrapped = '1'

      const children = Array.from(card.childNodes)
      const inner = document.createElement('div')
      inner.className = 'tilt-card-inner'
      children.forEach((child) => inner.appendChild(child))
      card.appendChild(inner)
    })
  }

  /* ── 3D scroll reveal ── */
  function init3DReveal() {
    const titleSelectors = [
      '#service h2',
      '#graphic h2',
      '#faq h2',
      '#about h2',
      '#testimonial h2',
      '#partnership h2',
      'section .text-center h1',
    ]

    titleSelectors.forEach((sel) => {
      document.querySelectorAll(sel).forEach((el) => {
        if (el.classList.contains('reveal-3d')) return
        el.classList.add('reveal-3d', 'section-3d-title')
      })
    })

    document.querySelectorAll('#about .grid.grid-cols-2 > div').forEach((el, i) => {
      el.classList.add('stat-3d', 'reveal-3d')
      el.style.setProperty('--reveal-delay', `${i * 0.08}s`)
    })

    document.querySelectorAll('.partner-badge').forEach((el) => el.classList.add('partner-3d'))
    document.querySelectorAll('.testimonial-card').forEach((el) => el.classList.add('testimonial-3d'))
    document.querySelectorAll('.faq-item').forEach((el) => el.classList.add('faq-3d'))

    const aboutMedia = document.querySelector('.about-media-wrap')
    if (aboutMedia) {
      aboutMedia.classList.add('reveal-3d-right')
      aboutMedia.classList.remove('reveal-right')
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return
          entry.target.classList.add('revealed')
          observer.unobserve(entry.target)
        })
      },
      { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    )

    document.querySelectorAll('.reveal-3d, .reveal-3d-left, .reveal-3d-right').forEach((el) => {
      observer.observe(el)
    })
  }

  /* ── Hero mouse 3D parallax ── */
  function initHero3DParallax() {
    const hero = document.getElementById('home')
    const layer = hero?.querySelector('.hero-3d-layer')
    if (!hero || !layer || isMobile) return

    hero.addEventListener('mousemove', (e) => {
      const rect = hero.getBoundingClientRect()
      const x = (e.clientX - rect.left) / rect.width - 0.5
      const y = (e.clientY - rect.top) / rect.height - 0.5
      layer.style.transform = `perspective(1200px) rotateY(${x * 6}deg) rotateX(${-y * 6}deg)`
    })

    hero.addEventListener('mouseleave', () => {
      layer.style.transform = ''
    })
  }

  /* ── Section scroll 3D tilt ── */
  function initScroll3D() {
    if (isMobile) return

    const targets = document.querySelectorAll(
      'section[id]:not(#home) > .max-w-7xl, section[id]:not(#home) > .relative.max-w-7xl'
    )

    targets.forEach((el) => el.classList.add('scroll-3d'))

    window.addEventListener(
      'scroll',
      () => {
        const vh = window.innerHeight
        targets.forEach((el) => {
          const rect = el.getBoundingClientRect()
          const center = rect.top + rect.height / 2
          const offset = (center - vh / 2) / vh
          if (Math.abs(offset) > 1.2) return
          const rotate = offset * -3
          el.style.transform = `perspective(1400px) rotateX(${rotate}deg)`
        })
      },
      { passive: true }
    )
  }

  /* ── Image hover tilt (3D) ── */
  function initTilt() {
    init3DCardWrap()

    const maxTilt = isCoarsePointer ? 0 : isMobile ? 8 : 14

    document.querySelectorAll('.tilt-card').forEach((card) => {
      if (card.dataset.tiltBound) return
      card.dataset.tiltBound = '1'

      const onMove = (e) => {
        const rect = card.getBoundingClientRect()
        const clientX = e.touches ? e.touches[0].clientX : e.clientX
        const clientY = e.touches ? e.touches[0].clientY : e.clientY
        const x = (clientX - rect.left) / rect.width - 0.5
        const y = (clientY - rect.top) / rect.height - 0.5
        const rotateY = x * maxTilt
        const rotateX = -y * maxTilt

        card.style.transform = `perspective(900px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(12px)`
        card.style.setProperty('--glare-x', `${(x + 0.5) * 100}%`)
        card.style.setProperty('--glare-y', `${(y + 0.5) * 100}%`)
        card.style.setProperty('--glare-opacity', '1')
        card.classList.add('tilt-active')

        const inner = card.querySelector('.tilt-card-inner')
        if (inner) {
          inner.style.transform = `translateZ(28px) translateX(${x * 6}px) translateY(${y * 6}px)`
        }
      }

      const onLeave = () => {
        card.style.transform = ''
        card.style.setProperty('--glare-opacity', '0')
        card.classList.remove('tilt-active')
        const inner = card.querySelector('.tilt-card-inner')
        if (inner) inner.style.transform = 'translateZ(24px)'
      }

      if (isCoarsePointer) {
        card.addEventListener('touchmove', onMove, { passive: true })
        card.addEventListener('touchend', onLeave)
      } else {
        card.addEventListener('mousemove', onMove)
        card.addEventListener('mouseleave', onLeave)
      }
    })
  }

  /* ── Star rating pop ── */
  function initStarPop() {
    document.querySelectorAll('.testimonial-card').forEach((card) => {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (!entry.isIntersecting) return
            entry.target.querySelectorAll('.star-icon').forEach((star, i) => {
              star.style.animationDelay = `${i * 0.08}s`
              star.classList.add('star-pop')
            })
            observer.unobserve(entry.target)
          })
        },
        { threshold: 0.4 }
      )
      observer.observe(card)
    })
  }

  function init() {
    initScrollProgress()
    initNavbar()
    initReveal()
    initHeroEntrance()
    initCounters()
    initProgressBars()
    initTyping()
    initNavSpy()
    initParallax()
    initParticles()
    initButton3D()
    initMobileMenuAnim()
    init3DReveal()
    initHero3DParallax()
    initScroll3D()
    initTilt()
    initStarPop()
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
  } else {
    init()
  }

  document.addEventListener('site-loaded', () => {
    initCounters()
    initProgressBars()
    init3DReveal()
    initButton3D()
    initTilt()
    initStarPop()
    initReveal()
  })
})()
