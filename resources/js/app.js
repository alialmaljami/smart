import Alpine from 'alpinejs'
import AOS from 'aos'
import 'aos/dist/aos.css'

window.Alpine = Alpine

document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
    })
})

Alpine.start()
