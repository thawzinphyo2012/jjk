const CMS_API = 'http://localhost:8001/api/site'
const CMS_ORIGIN = 'http://localhost:8001'

function resolveImage(url) {
  if (!url) return ''
  if (url.startsWith('http')) return url
  if (url.startsWith('/storage') || url.startsWith('storage/')) {
    return CMS_ORIGIN + (url.startsWith('/') ? url : '/' + url)
  }
  if (url.startsWith('uploads/')) return CMS_ORIGIN + '/storage/' + url
  return url.replace(/^\//, '')
}

function localized(item, enKey, mmKey) {
  const lang = typeof getLang === 'function' ? getLang() : 'en'
  if (lang === 'mm' && item[mmKey]) return item[mmKey]
  return item[enKey] || item[mmKey] || ''
}

function imgTag(src, alt, cls) {
  const url = resolveImage(src) || src
  return `<img src="${url}" alt="${alt || ''}" class="${cls}" loading="lazy" onerror="this.src='images/hero.jpg'" />`
}

function starSvg() {
  return '<svg class="w-4 h-4 star-icon" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>'
}

const graphicCatColors = ['text-cyan-400', 'text-violet-400', 'text-green-400', 'text-orange-400', 'text-blue-400']

function renderServices(services) {
  const grid = document.getElementById('services-grid')
  if (!grid || !services?.length) return

  grid.innerHTML = services
    .map((s) => {
      const borderStyle = s.icon_color ? ` style="border-color:${s.icon_color}55"` : ''
      return `
    <div class="card-hover tilt-card p-5 sm:p-8 rounded-2xl bg-charcoal neon-border"${borderStyle}>
      <div class="service-media">
        <img src="${resolveImage(s.image) || 'images/hero.jpg'}" alt="${localized(s, 'title_en', 'title_mm')}" class="media-img" loading="lazy" onerror="this.src='images/hero.jpg'" />
      </div>
      <h3 class="font-display text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">${localized(s, 'title_en', 'title_mm')}</h3>
      <p class="text-gray-400 text-sm leading-relaxed">${localized(s, 'description_en', 'description_mm')}</p>
    </div>`
    })
    .join('')
}

function renderGraphics(graphics) {
  const grid = document.getElementById('graphics-grid')
  if (!grid || !graphics?.length) return

  grid.innerHTML = graphics
    .map((g, i) => {
      const catColor = g.gradient?.startsWith('text-') ? g.gradient : graphicCatColors[i % graphicCatColors.length]
      return `
    <div class="group card-hover tilt-card rounded-2xl overflow-hidden bg-charcoal neon-border">
      <div class="graphic-media">
        <img src="${resolveImage(g.image)}" alt="${localized(g, 'title_en', 'title_mm')}" class="media-img group-hover:scale-105 transition-transform duration-500" loading="lazy" />
      </div>
      <div class="p-4 sm:p-6">
        <span class="text-xs ${catColor} font-medium tracking-wider uppercase">${localized(g, 'category_en', 'category_mm')}</span>
        <h3 class="font-display text-lg font-bold text-white mt-2 mb-2">${localized(g, 'title_en', 'title_mm')}</h3>
        <p class="text-gray-400 text-sm">${localized(g, 'description_en', 'description_mm')}</p>
      </div>
    </div>`
    })
    .join('')
}

function renderTestimonials(items) {
  const list = document.getElementById('testimonials-list')
  if (!list || !items?.length) return

  list.innerHTML = items
    .map((t) => {
      const stars = starSvg().repeat(t.rating || 5)
      const quote = localized(t, 'quote_en', 'quote_mm')
      const role = localized(t, 'role_en', 'role_mm')
      return `
    <div class="testimonial-card p-5 sm:p-6 rounded-2xl bg-charcoal neon-border">
      <div class="flex gap-1 mb-3 text-cyan-400">${stars}</div>
      <p class="text-gray-300 text-sm sm:text-base leading-relaxed mb-4">${quote}</p>
      <div class="flex items-center gap-3">
        <img src="${resolveImage(t.avatar)}" alt="${t.name}" class="testimonial-avatar" loading="lazy" />
        <div>
          <p class="text-white font-medium text-sm">${t.name}</p>
          <p class="text-gray-500 text-xs">${role}</p>
        </div>
      </div>
    </div>`
    })
    .join('')
}

function renderPartners(partners) {
  const grid = document.getElementById('partners-grid')
  if (!grid || !partners?.length) return

  grid.innerHTML = partners
    .map(
      (p) => `
    <div class="partner-badge">
      ${imgTag(p.image, p.name, 'partner-icon')}
      <span>${p.name}</span>
    </div>`
    )
    .join('')
}

function renderFaqs(faqs) {
  const list = document.getElementById('faq-list')
  if (!list || !faqs?.length) return

  list.innerHTML = faqs
    .map(
      (f) => `
    <div class="faq-item rounded-2xl bg-charcoal neon-border overflow-hidden">
      <button type="button" class="faq-trigger" aria-expanded="false">
        <span>${localized(f, 'question_en', 'question_mm')}</span>
        <svg class="faq-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
      </button>
      <div class="faq-panel">
        <div class="faq-panel-inner">
          <p>${localized(f, 'answer_en', 'answer_mm')}</p>
        </div>
      </div>
    </div>`
    )
    .join('')

  initFaqAccordion()
}

function renderFormOptions(options) {
  const select = document.getElementById('contact-subject')
  if (!select || !options?.length) return

  const lang = typeof getLang === 'function' ? getLang() : 'en'
  const topic = typeof t === 'function' ? t('contact.form.topic') : 'Select a topic'

  select.innerHTML =
    `<option value="" class="bg-charcoal">${topic}</option>` +
    options
      .map((opt) => {
        const label = lang === 'mm' && opt.label_mm ? opt.label_mm : opt.label_en
        return `<option value="${opt.value}" class="bg-charcoal">${label}</option>`
      })
      .join('')
}

function applyMetaDescription(settings, page) {
  const meta = document.querySelector('meta[name="description"]')
  if (!meta || !settings) return

  const key = page === 'contact' ? 'meta_description_contact' : 'meta_description_home'
  if (settings[key]) meta.setAttribute('content', settings[key])
}

function applySettings(settings) {
  if (!settings) return

  document.querySelectorAll('[data-setting]').forEach((el) => {
    const key = el.dataset.setting
    if (settings[key] != null) el.textContent = settings[key]
  })

  document.querySelectorAll('[data-setting-html]').forEach((el) => {
    const key = el.dataset.settingHtml
    if (settings[key]) el.innerHTML = settings[key]
  })

  document.querySelectorAll('[data-setting-src]').forEach((el) => {
    const key = el.dataset.settingSrc
    if (settings[key]) el.src = resolveImage(settings[key])
  })

  document.querySelectorAll('[data-setting-href]').forEach((el) => {
    const key = el.dataset.settingHref
    if (!settings[key]) return
    const val = settings[key]
    if (key === 'contact_email') el.href = `mailto:${val}`
    else if (key === 'contact_phone') el.href = `tel:${val.replace(/\s/g, '')}`
    else el.href = val
  })

  document.querySelectorAll('[data-setting-width]').forEach((el) => {
    const key = el.dataset.settingWidth
    if (settings[key]) el.dataset.width = settings[key]
  })

  const statEls = [
    { el: '#hero-stat-1', count: 'hero_stat1_count', suffix: 'hero_stat1_suffix', decimals: null },
    { el: '#hero-stat-2', count: 'hero_stat2_count', suffix: 'hero_stat2_suffix', decimals: 'hero_stat2_decimals' },
    { el: '#hero-stat-3', count: 'hero_stat3_count', suffix: 'hero_stat3_suffix', decimals: null },
  ]

  statEls.forEach(({ el, count, suffix, decimals }) => {
    const node = document.querySelector(el)
    if (!node) return
    node.dataset.count = settings[count] || node.dataset.count
    node.dataset.suffix = settings[suffix] || node.dataset.suffix || ''
    if (decimals && settings[decimals]) node.dataset.decimals = settings[decimals]
  })
}

function initFaqAccordion() {
  document.querySelectorAll('.faq-item').forEach((item) => {
    const trigger = item.querySelector('.faq-trigger')
    if (!trigger || trigger.dataset.bound === '1') return
    trigger.dataset.bound = '1'

    trigger.addEventListener('click', () => {
      const willOpen = !item.classList.contains('open')

      document.querySelectorAll('.faq-item.open').forEach((openItem) => {
        if (openItem === item) return
        openItem.classList.remove('open')
        openItem.querySelector('.faq-trigger')?.setAttribute('aria-expanded', 'false')
      })

      item.classList.toggle('open', willOpen)
      trigger.setAttribute('aria-expanded', String(willOpen))
    })
  })
}

async function loadSiteContent() {
  const page = document.body.dataset.page || 'home'

  try {
    const res = await fetch(CMS_API)
    if (!res.ok) throw new Error('CMS unavailable')
    const data = await res.json()

    if (data.translations?.en && typeof translations !== 'undefined') {
      Object.assign(translations.en, data.translations.en)
      Object.assign(translations.mm, data.translations.mm)
    }

    window.siteData = data
    applyMetaDescription(data.settings, page)
    applySettings(data.settings)
    renderServices(data.services)
    renderGraphics(data.graphics)
    renderTestimonials(data.testimonials)
    renderPartners(data.partners)
    renderFaqs(data.faqs)
    renderFormOptions(data.form_options)
  } catch (err) {
    console.warn('Using static content fallback:', err.message)
    initFaqAccordion()
  }

  if (typeof initI18n === 'function') initI18n()

  document.dispatchEvent(new CustomEvent('site-loaded'))
}

window.renderServices = renderServices
window.renderGraphics = renderGraphics
window.renderTestimonials = renderTestimonials
window.renderFaqs = renderFaqs
window.initFaqAccordion = initFaqAccordion

loadSiteContent()
