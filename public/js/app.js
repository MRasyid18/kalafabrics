/* KalaFabrics - Main JS */

document.addEventListener('DOMContentLoaded', function () {

  /* --- Filter Tabs --- */
  document.querySelectorAll('.filter-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
      var group = this.closest('.filter-tabs');
      if (group) {
        group.querySelectorAll('.filter-tab').forEach(function (t) { t.classList.remove('active'); });
      }
      this.classList.add('active');
    });
  });

  /* --- Role Cards (Register) --- */
  document.querySelectorAll('.role-card').forEach(function (card) {
    card.addEventListener('click', function () {
      document.querySelectorAll('.role-card').forEach(function (c) { c.classList.remove('selected'); });
      this.classList.add('selected');
    });
  });

  /* --- Delivery Options (Checkout) --- */
  document.querySelectorAll('.delivery-option').forEach(function (opt) {
    opt.addEventListener('click', function () {
      document.querySelectorAll('.delivery-option').forEach(function (o) { o.classList.remove('selected'); });
      this.classList.add('selected');
    });
  });

  /* --- Payment Options (Checkout) --- */
  document.querySelectorAll('.payment-option').forEach(function (opt) {
    opt.addEventListener('click', function () {
      document.querySelectorAll('.payment-option').forEach(function (o) { o.classList.remove('selected'); });
      this.classList.add('selected');
    });
  });

  /* --- Password Toggle (Sign In) --- */
  document.querySelectorAll('.input-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = this.previousElementSibling;
      if (!input) input = this.parentElement.querySelector('input');
      if (input) {
        if (input.type === 'password') {
          input.type = 'text';
          this.innerHTML = '&#128065;';
        } else {
          input.type = 'password';
          this.innerHTML = '&#128064;';
        }
      }
    });
  });

  /* --- Qty Controls (Cart) --- */
  document.querySelectorAll('.qty-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var wrapper = this.closest('.qty-control');
      var valEl = wrapper ? wrapper.querySelector('.qty-value') : null;
      if (!valEl) return;
      var val = parseInt(valEl.textContent) || 1;
      if (this.dataset.action === 'minus' || this.classList.contains('minus')) {
        if (val > 1) valEl.textContent = val - 1;
      } else {
        valEl.textContent = val + 1;
      }
    });
  });

  /* --- Remove Cart Item --- */
  document.querySelectorAll('.cart-remove').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = this.closest('.cart-item');
      if (item) {
        item.style.transition = 'opacity .3s ease, transform .3s ease';
        item.style.opacity = '0';
        item.style.transform = 'translateX(20px)';
        setTimeout(function () { item.remove(); }, 300);
      }
    });
  });

  /* --- Simple line chart (Dashboard) --- */
  var lineCanvas = document.getElementById('lineChart');
  if (lineCanvas) {
    drawLineChart(lineCanvas);
  }

  /* --- Donut chart (Dashboard) --- */
  var donutCanvas = document.getElementById('donutChart');
  if (donutCanvas) {
    drawDonutChart(donutCanvas);
  }

  /* --- Contact form --- */
  var contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = this.querySelector('button[type=submit]');
      if (btn) {
        btn.textContent = 'Pesan Terkirim ✓';
        btn.style.background = '#2d6a4f';
        setTimeout(function () {
          btn.textContent = 'Kirim Pesan';
          btn.style.background = '';
        }, 3000);
      }
      this.reset();
    });
  }

  /* --- Fade up on scroll --- */
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.stat-card, .event-card, .product-card, .journal-card').forEach(function (el) {
      el.style.opacity = '0';
      el.style.transform = 'translateY(18px)';
      el.style.transition = 'opacity .5s ease, transform .5s ease';
      io.observe(el);
    });
  }
});

/* --- Canvas Line Chart --- */
function drawLineChart(canvas) {
  var ctx = canvas.getContext('2d');
  var w = canvas.width = canvas.offsetWidth;
  var h = canvas.height = 220;
  var data = [1500, 1750, 1600, 1900, 2400, 2550];
  var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
  var pad = { top: 20, right: 20, bottom: 40, left: 50 };
  var cw = w - pad.left - pad.right;
  var ch = h - pad.top - pad.bottom;
  var max = 3000;
  var yTicks = [0, 500, 1000, 1500, 2000, 2500, 3000];

  ctx.clearRect(0, 0, w, h);

  /* Grid lines */
  ctx.strokeStyle = 'rgba(30,35,24,.07)';
  ctx.lineWidth = 1;
  yTicks.forEach(function (tick) {
    var y = pad.top + ch - (tick / max) * ch;
    ctx.beginPath();
    ctx.moveTo(pad.left, y);
    ctx.lineTo(pad.left + cw, y);
    ctx.stroke();
    ctx.fillStyle = '#9a9988';
    ctx.font = '11px DM Sans, sans-serif';
    ctx.textAlign = 'right';
    ctx.fillText(tick.toLocaleString(), pad.left - 8, y + 4);
  });

  /* Area fill */
  var xs = data.map(function (_, i) { return pad.left + (i / (data.length - 1)) * cw; });
  var ys = data.map(function (d) { return pad.top + ch - (d / max) * ch; });
  var grad = ctx.createLinearGradient(0, pad.top, 0, pad.top + ch);
  grad.addColorStop(0, 'rgba(45,58,30,.18)');
  grad.addColorStop(1, 'rgba(45,58,30,.01)');
  ctx.beginPath();
  ctx.moveTo(xs[0], ys[0]);
  for (var i = 1; i < xs.length; i++) {
    var xc = (xs[i - 1] + xs[i]) / 2;
    ctx.bezierCurveTo(xc, ys[i - 1], xc, ys[i], xs[i], ys[i]);
  }
  ctx.lineTo(xs[xs.length - 1], pad.top + ch);
  ctx.lineTo(xs[0], pad.top + ch);
  ctx.closePath();
  ctx.fillStyle = grad;
  ctx.fill();

  /* Line */
  ctx.beginPath();
  ctx.moveTo(xs[0], ys[0]);
  for (var i = 1; i < xs.length; i++) {
    var xc = (xs[i - 1] + xs[i]) / 2;
    ctx.bezierCurveTo(xc, ys[i - 1], xc, ys[i], xs[i], ys[i]);
  }
  ctx.strokeStyle = 'rgba(45,58,30,.75)';
  ctx.lineWidth = 2;
  ctx.stroke();

  /* Dots */
  xs.forEach(function (x, i) {
    ctx.beginPath();
    ctx.arc(x, ys[i], 4, 0, Math.PI * 2);
    ctx.fillStyle = '#2d3a1e';
    ctx.fill();
    ctx.beginPath();
    ctx.arc(x, ys[i], 2.5, 0, Math.PI * 2);
    ctx.fillStyle = 'white';
    ctx.fill();
  });

  /* X labels */
  months.forEach(function (m, i) {
    ctx.fillStyle = '#9a9988';
    ctx.font = '11px DM Sans, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText(m, xs[i], h - 10);
  });
}

/* --- Canvas Donut Chart --- */
function drawDonutChart(canvas) {
  var ctx = canvas.getContext('2d');
  var size = 160;
  canvas.width = size;
  canvas.height = size;
  var cx = size / 2, cy = size / 2, r = 60, inner = 38;
  var slices = [
    { pct: 0.38, color: '#2d3a1e' },
    { pct: 0.25, color: '#8bc4a0' },
    { pct: 0.18, color: '#c9a85c' },
    { pct: 0.12, color: '#4a7c59' },
    { pct: 0.07, color: '#d4cfc4' }
  ];
  var start = -Math.PI / 2;
  slices.forEach(function (s) {
    var end = start + s.pct * 2 * Math.PI;
    ctx.beginPath();
    ctx.moveTo(cx, cy);
    ctx.arc(cx, cy, r, start, end);
    ctx.closePath();
    ctx.fillStyle = s.color;
    ctx.fill();
    start = end;
  });
  /* Inner hole */
  ctx.beginPath();
  ctx.arc(cx, cy, inner, 0, Math.PI * 2);
  ctx.fillStyle = 'white';
  ctx.fill();
  /* Center text */
  ctx.fillStyle = '#1e2318';
  ctx.font = 'bold 14px DM Sans, sans-serif';
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';
  ctx.fillText('100%', cx, cy);
}
