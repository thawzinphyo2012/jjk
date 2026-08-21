import './style.css'

const navbar = document.getElementById('navbar')
const menuBtn = document.getElementById('menu-btn')
const mobileMenu = document.getElementById('mobile-menu')
const contactForm = document.getElementById('contact-form')

window.addEventListener('scroll', () => {
  if (window.scrollY > 50) {
    navbar.classList.add('bg-obsidian/90', 'backdrop-blur-xl', 'border-white/5')
    navbar.classList.remove('border-transparent')
  } else {
    navbar.classList.remove('bg-obsidian/90', 'backdrop-blur-xl', 'border-white/5')
    navbar.classList.add('border-transparent')
  }
})

menuBtn?.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden')
})

mobileMenu?.querySelectorAll('a').forEach((link) => {
  link.addEventListener('click', () => {
    mobileMenu.classList.add('hidden')
  })
})

contactForm?.addEventListener('submit', (e) => {
  e.preventDefault()
  const btn = contactForm.querySelector('button')
  const original = btn.textContent
  btn.textContent = 'Message Sent!'
  btn.classList.replace('bg-cyan-400', 'bg-green-400')
  setTimeout(() => {
    btn.textContent = original
    btn.classList.replace('bg-green-400', 'bg-cyan-400')
    contactForm.reset()
  }, 2500)
})
