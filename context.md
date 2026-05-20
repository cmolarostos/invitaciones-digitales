Estoy trabajando en "Invitaciones Digitales", un SaaS de invitaciones de eventos construido con Laravel 13 / PHP 8.4 / MySQL / Tailwind CSS v4 / Vite. Deploy en Railway. El proyecto está en /opt/homebrew/var/www/invitaciones-digitales.

## Estado actual

### Modelos principales
- User → hasMany Events
- Event (SoftDeletes) → belongsTo User, Template; hasMany Guests, EventPhotos, EventPayments, MessageLogs
- Guest → rsvp_status: pending|confirmed|declined, plus_ones, token (único para URL de RSVP)
- Template → belongsTo EventType
- EventType → hasMany Templates

### Controladores
- DashboardController → stats globales + por evento + actividad reciente
- EventController → wizard 3 pasos (create/selectTemplate/createWithTemplate) + publish + restore
- GuestController → CRUD + import CSV
- RsvpController → show, confirm, thankyou (con QR ticket digital)
- CatalogController → catálogo público de plantillas
- Auth: Login, Register, ForgotPassword, ResetPassword

### Rutas clave
- GET  /                          → dashboard (auth)
- GET  /catalogo                  → catálogo público
- GET  /i/{slug}                  → invitación pública
- GET  /rsvp/{token}              → formulario RSVP del invitado
- GET  /rsvp/{token}/gracias      → página de confirmación + QR
- GET  events/select-type         → paso 1 wizard
- GET  events/select-template     → paso 2 wizard
- GET  events/new/{template}      → paso 3 wizard

### Vistas
- layouts/app.blade.php           → nav con Dashboard / Mis eventos
- layouts/public.blade.php        → layout para invitaciones y RSVP
- dashboard/index.blade.php       → cards de stats + barras RSVP por evento + actividad
- templates/xv-cottagecore.blade.php  → plantilla cottagecore con animaciones en cascada
- templates/xv-elegante.blade.php
- templates/boda-clasica.blade.php
- templates/cumple-moderno.blade.php
- templates/corporativo.blade.php

### CSS / JS
- app.css tiene clases de animación: fade-up, fade-in, scale-in + delay-1..delay-7
- app.js inicializa QR con el paquete `qrcode` en cualquier canvas[data-qr]

### Infraestructura
- Railway con MySQL como servicio separado
- railpack.json: build corre npm ci + npm run build; start corre optimize:clear + cache + migrate + seed + serve
- AppServiceProvider fuerza HTTPS en producción
- bootstrap/app.php tiene trustProxies(at: '*')

### Pendiente / próximos pasos naturales
- ~~Aplicar animaciones fade-up a los demás templates (boda-clasica, cumple-moderno, etc.)~~ ✓
- Subida de fotos con Cloudflare R2 (config ya preparada en .env.example)
- Envío de invitaciones por WhatsApp
- Pagos con Stripe para planes premium
- Más plantillas de diseño

---
*Última actualización: 2026-05-19*
