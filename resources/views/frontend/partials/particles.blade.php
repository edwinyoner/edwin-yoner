<script>
function createParticleCanvas(canvasId, sectionSelector) {
    const canvas  = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx     = canvas.getContext('2d');
    const section = document.querySelector(sectionSelector);
    const dpi     = window.devicePixelRatio || 1;

    function resize() {
        const w = section ? section.offsetWidth  : window.innerWidth;
        const h = section ? section.offsetHeight : window.innerHeight;
        canvas.style.width  = w + 'px';
        canvas.style.height = h + 'px';
        canvas.width  = w * dpi;
        canvas.height = h * dpi;
        ctx.setTransform(dpi, 0, 0, dpi, 0, 0);
    }
    resize();
    window.addEventListener('resize', resize);

    const W = () => canvas.width  / dpi;
    const H = () => canvas.height / dpi;

    const COLORS = [
            '#d4af37', '#e8c547', '#b8960c', // Dorados/Amarillos
            '#c0392b', '#e74c3c',             // Rojos
            '#2980b9', '#3498db',             // Azules
            '#27ae60', '#2ecc71',             // Verdes
            '#e67e22', '#d35400',             // Anaranjados (Sustituidos)
        ];

    function hexToRgb(hex) {
        return [
            parseInt(hex.slice(1, 3), 16),
            parseInt(hex.slice(3, 5), 16),
            parseInt(hex.slice(5, 7), 16),
        ];
    }

    // Seguimiento del mouse relativo al canvas
    const mouse = { x: -999, y: -999 };

    canvas.addEventListener('mousemove', e => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });

    canvas.addEventListener('mouseleave', () => {
        mouse.x = -999;
        mouse.y = -999;
    });

    class Node {
        constructor() {
            this.x     = Math.random() * W();
            this.y     = Math.random() * H();
            this.vx    = (Math.random() - 0.5) * 0.5;
            this.vy    = (Math.random() - 0.5) * 0.5;
            this.r     = Math.random() * 2 + 1;
            this.color = COLORS[Math.floor(Math.random() * COLORS.length)];
            this.rgb   = hexToRgb(this.color);
        }

        update() {
            // Repulsión del mouse
            const dx   = this.x - mouse.x;
            const dy   = this.y - mouse.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            const REPEL = 90;

            if (dist < REPEL && dist > 0) {
                const force = (REPEL - dist) / REPEL;
                this.vx += (dx / dist) * force * 1.8;
                this.vy += (dy / dist) * force * 1.8;
            }

            // Fricción suave
            this.vx *= 0.97;
            this.vy *= 0.97;

            // Velocidad mínima para que nunca se detenga
            const speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
            if (speed < 0.15) {
                this.vx += (Math.random() - 0.5) * 0.1;
                this.vy += (Math.random() - 0.5) * 0.1;
            }

            // Límite de velocidad máxima
            const maxSpeed = 5.5;
            if (speed > maxSpeed) {
                this.vx = (this.vx / speed) * maxSpeed;
                this.vy = (this.vy / speed) * maxSpeed;
            }

            this.x += this.vx;
            this.y += this.vy;

            // Rebote en bordes
            if (this.x < this.r)         { this.x = this.r;          this.vx *= -1; }
            if (this.x > W() - this.r)   { this.x = W() - this.r;    this.vx *= -1; }
            if (this.y < this.r)         { this.y = this.r;           this.vy *= -1; }
            if (this.y > H() - this.r)   { this.y = H() - this.r;    this.vy *= -1; }
        }

        draw() {
            const [r, g, b] = this.rgb;

            // Halo exterior
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.r + 3, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(${r},${g},${b},0.3)`;
            ctx.lineWidth = 1.5;
            ctx.stroke();

            // Nodo sólido
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.fill();
        }
    }

    // Ajustar cantidad de nodos según altura de la sección
    const area     = W() * H();
    const count    = Math.min(42, Math.max(20, Math.floor(area / 18000)));
    const nodes    = Array.from({ length: count }, () => new Node());
    const MAX_DIST = 130;

    function drawConnections() {
        for (let i = 0; i < nodes.length; i++) {
            for (let j = i + 1; j < nodes.length; j++) {
                const a  = nodes[i], b = nodes[j];
                const dx = a.x - b.x;
                const dy = a.y - b.y;
                const d  = Math.sqrt(dx * dx + dy * dy);

                if (d < MAX_DIST) {
                    const alpha = (1 - d / MAX_DIST) * 0.65;
                    const [r1, g1, b1] = a.rgb;
                    const [r2, g2, b2] = b.rgb;

                    // Gradiente del color del nodo A al color del nodo B
                    const grad = ctx.createLinearGradient(a.x, a.y, b.x, b.y);
                    grad.addColorStop(0,   `rgba(${r1},${g1},${b1},${alpha})`);
                    grad.addColorStop(0.5, `rgba(${Math.round((r1+r2)/2)},${Math.round((g1+g2)/2)},${Math.round((b1+b2)/2)},${alpha})`);
                    grad.addColorStop(1,   `rgba(${r2},${g2},${b2},${alpha})`);

                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.strokeStyle = grad;
                    ctx.lineWidth   = 1;
                    ctx.stroke();
                }
            }
        }
    }

    let animId;
    (function animate() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        ctx.fillStyle = isDark ? 'rgba(2,2,2,0.22)' : 'rgba(248,250,252,0.22)';
        ctx.fillRect(0, 0, W(), H());
        drawConnections();
        nodes.forEach(n => { n.update(); n.draw(); });
        animId = requestAnimationFrame(animate);
    })();

    document.addEventListener('turbo:before-visit', () => cancelAnimationFrame(animId));
}
</script>