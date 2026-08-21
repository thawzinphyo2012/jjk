function getTheme() {
  return localStorage.getItem('theme') || 'dark'
}

function setTheme(theme) {
  document.documentElement.classList.remove('dark', 'light')
  document.documentElement.classList.add(theme)
  localStorage.setItem('theme', theme)
  updateToggleIcons(theme)
  document.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }))
}

function toggleTheme() {
  setTheme(getTheme() === 'dark' ? 'light' : 'dark')
}

function updateToggleIcons(theme) {
  document.querySelectorAll('.icon-sun').forEach((el) => {
    el.classList.toggle('hidden', theme === 'light')
  })
  document.querySelectorAll('.icon-moon').forEach((el) => {
    el.classList.toggle('hidden', theme === 'dark')
  })
}

document.querySelectorAll('.theme-toggle-btn').forEach((btn) => {
  btn.addEventListener('click', toggleTheme)
})

updateToggleIcons(getTheme())
