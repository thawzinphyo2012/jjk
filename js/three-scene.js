import * as THREE from 'https://unpkg.com/three@0.160.0/build/three.module.js'

;(function () {
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (reduced) return

  const canvases = document.querySelectorAll('[data-three-scene]')
  if (!canvases.length) return

  const isMobile = window.matchMedia('(max-width: 767px)').matches
  const isLight = () => document.documentElement.classList.contains('light')

  canvases.forEach((canvas) => {
    const section = canvas.closest('section')
    if (!section) return

    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: !isMobile })
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, isMobile ? 1.5 : 2))
    renderer.setClearColor(0x000000, 0)

    const scene = new THREE.Scene()
    const camera = new THREE.PerspectiveCamera(50, 1, 0.1, 100)
    camera.position.z = isMobile ? 6 : 5

    const group = new THREE.Group()
    scene.add(group)

    const primary = () => (isLight() ? 0x0891b2 : 0x00f0ff)
    const secondary = () => (isLight() ? 0x7c3aed : 0x9333ea)

    const wireMat = () =>
      new THREE.MeshBasicMaterial({
        color: primary(),
        wireframe: true,
        transparent: true,
        opacity: isMobile ? 0.35 : 0.55,
      })

    const geo1 = new THREE.IcosahedronGeometry(isMobile ? 1.1 : 1.4, 1)
    const mesh1 = new THREE.Mesh(geo1, wireMat())
    mesh1.position.set(isMobile ? 0 : -1.2, 0.2, 0)
    group.add(mesh1)

    const geo2 = new THREE.TorusKnotGeometry(isMobile ? 0.55 : 0.7, 0.18, 100, 16)
    const mesh2 = new THREE.Mesh(geo2, wireMat())
    mesh2.position.set(isMobile ? 0 : 1.4, -0.3, -0.5)
    group.add(mesh2)

    const ringGeo = new THREE.TorusGeometry(isMobile ? 1.6 : 2.2, 0.02, 8, 64)
    const ringMat = () =>
      new THREE.MeshBasicMaterial({
        color: secondary(),
        transparent: true,
        opacity: 0.4,
      })
    const ring = new THREE.Mesh(ringGeo, ringMat())
    ring.rotation.x = Math.PI / 2.5
    group.add(ring)

    const particles = isMobile ? 120 : 280
    const positions = new Float32Array(particles * 3)
    for (let i = 0; i < particles * 3; i++) {
      positions[i] = (Math.random() - 0.5) * (isMobile ? 8 : 12)
    }
    const pGeo = new THREE.BufferGeometry()
    pGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3))
    const pMat = () =>
      new THREE.PointsMaterial({
        color: primary(),
        size: isMobile ? 0.04 : 0.06,
        transparent: true,
        opacity: 0.7,
        blending: THREE.AdditiveBlending,
      })
    const points = new THREE.Points(pGeo, pMat())
    scene.add(points)

    let mouseX = 0
    let mouseY = 0
    let targetX = 0
    let targetY = 0

    if (!isMobile) {
      section.addEventListener('mousemove', (e) => {
        const rect = section.getBoundingClientRect()
        mouseX = ((e.clientX - rect.left) / rect.width - 0.5) * 2
        mouseY = ((e.clientY - rect.top) / rect.height - 0.5) * 2
      })
      section.addEventListener('mouseleave', () => {
        mouseX = 0
        mouseY = 0
      })
    }

    function resize() {
      const w = canvas.clientWidth
      const h = canvas.clientHeight
      if (!w || !h) return
      renderer.setSize(w, h, false)
      camera.aspect = w / h
      camera.updateProjectionMatrix()
    }

    const ro = new ResizeObserver(resize)
    ro.observe(canvas)
    resize()

    let raf
    const clock = new THREE.Clock()

    function animate() {
      raf = requestAnimationFrame(animate)
      const t = clock.getElapsedTime()

      targetX += (mouseX - targetX) * 0.05
      targetY += (mouseY - targetY) * 0.05

      group.rotation.x = t * 0.15 + targetY * 0.25
      group.rotation.y = t * 0.22 + targetX * 0.35
      mesh1.rotation.z = t * 0.3
      mesh2.rotation.x = t * 0.4
      ring.rotation.z = t * 0.12
      points.rotation.y = t * 0.05

      camera.position.x = targetX * 0.4
      camera.position.y = -targetY * 0.3
      camera.lookAt(0, 0, 0)

      renderer.render(scene, camera)
    }

    animate()

    document.addEventListener('theme-changed', () => {
      mesh1.material.color.set(primary())
      mesh2.material.color.set(primary())
      ring.material.color.set(secondary())
      points.material.color.set(primary())
    })

    window.addEventListener('beforeunload', () => {
      cancelAnimationFrame(raf)
      ro.disconnect()
      renderer.dispose()
      geo1.dispose()
      geo2.dispose()
      ringGeo.dispose()
      pGeo.dispose()
    })
  })
})()
