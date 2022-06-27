import './bootstrap'
import Alpine from 'alpinejs'
import { gsap } from 'gsap'

window.Alpine = Alpine
Alpine.start()

gsap.to('.box', {duration: 1, opacity: 0.3})
gsap.to('.bg-orange-500', {duration: 3, rotation: 360, scale: 0.5})

window.onload = () => {
    console.log('loaded')
}
