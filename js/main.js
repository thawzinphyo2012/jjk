const navbar = document.getElementById('navbar')
const menuBtn = document.getElementById('menu-btn')
const mobileMenu = document.getElementById('mobile-menu')
const contactForm = document.getElementById('contact-form')

const API_URL = 'http://localhost:8001/api/contact'

function closeMobileMenu() {
  mobileMenu?.classList.remove('open')
  mobileMenu?.classList.add('hidden')
  menuBtn?.classList.remove('active')
  document.body.classList.remove('menu-open')
}

function openMobileMenu() {
  mobileMenu?.classList.remove('hidden')
  mobileMenu?.classList.add('open')
  menuBtn?.classList.add('active')
  document.body.classList.add('menu-open')
}

window.addEventListener('scroll', () => {
  if (!navbar) return
  if (window.scrollY > 50) {
    navbar.classList.add('nav-scrolled')
    navbar.classList.remove('border-transparent')
  } else {
    navbar.classList.remove('nav-scrolled')
    navbar.classList.add('border-transparent')
  }
})

menuBtn?.addEventListener('click', () => {
  if (mobileMenu?.classList.contains('open')) {
    closeMobileMenu()
  } else {
    openMobileMenu()
  }
})

mobileMenu?.querySelectorAll('a').forEach((link) => {
  link.addEventListener('click', () => closeMobileMenu())
})

window.addEventListener('resize', () => {
  if (window.innerWidth >= 768) closeMobileMenu()
})

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeMobileMenu()
})

document.addEventListener('click', (e) => {
  if (!mobileMenu?.classList.contains('open')) return
  if (menuBtn?.contains(e.target) || mobileMenu.contains(e.target)) return
  closeMobileMenu()
})

contactForm?.addEventListener('submit', async (e) => {
  e.preventDefault()
  const btn = contactForm.querySelector('button[type="submit"]')
  const submitKey = btn.dataset.i18n || 'contact.form.submit'
  const original = t(submitKey)
  btn.disabled = true
  btn.textContent = t('form.sending')

  const formData = new FormData(contactForm)
  const payload = Object.fromEntries(formData.entries())

  try {
    const res = await fetch(API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(payload),
    })

    if (!res.ok) throw new Error('Failed')

    btn.textContent = t('form.sent')
    btn.classList.replace('bg-cyan-400', 'bg-green-400')
    contactForm.reset()
    setTimeout(() => {
      btn.textContent = original
      btn.classList.replace('bg-green-400', 'bg-cyan-400')
      btn.disabled = false
    }, 2500)
  } catch {
    btn.textContent = t('form.failed')
    btn.classList.add('bg-red-400')
    setTimeout(() => {
      btn.textContent = original
      btn.classList.remove('bg-red-400')
      btn.disabled = false
    }, 2500)
  }
})
