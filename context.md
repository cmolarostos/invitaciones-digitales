Estoy trabajando en "Invitaciones Digitales", un SaaS de invitaciones de eventos construido con Laravel 13 / PHP 8.4 / MySQL / Tailwind CSS v4 / Vite. Deploy en Railway. El proyecto está en /opt/homebrew/var/www/invitaciones-digitales.

## Estado actual

### Modelos principales
- User → hasMany Events
- Event (SoftDeletes) → belongsTo User, Template; hasMany Guests, EventPhotos, EventPayments, MessageLogs
- Guest → rsvp_status: pending|confirmed|declined, plus_ones, token (único para URL de RSVP)
- Template → belongsTo EventType; campos: default_colors (JSON, usado en previews), color_palettes (JSON array de paletas predefinidas con name, preview[4 hex], vars{css-var: value})
- EventType → hasMany Templates

### Campos del modelo Event
- name, slug, event_date, event_time, venue_name, venue_address, venue_maps_url
- dress_code, dress_code_men, dress_code_women (nullable strings)
- dress_code_colors (JSON array: [{hex, label}]) → colores a evitar, nullable
- notes
- itinerary (JSON array: [{time, title, description}])
- requires_rsvp (boolean, default false) → muestra/oculta sección RSVP en la invitación
- youtube_url (nullable string) → URL de YouTube para música de fondo; helper youtubeVideoId() extrae el ID
- gifts_title (nullable string, default display: "Tu presencia es el mejor regalo")
- gifts_subtitle (nullable string, default display: "Si deseas obsequiar algo más…")
- gifts (JSON array: [{title, description, url}]) → si vacío, sección oculta en invitación
- custom_colors (JSON) → paleta seleccionada; objeto con vars CSS específicas del template
- status, published_at

### Controladores
- DashboardController → stats globales + por evento + actividad reciente
- EventController → wizard 3 pasos (create/selectTemplate/createWithTemplate) + publish + restore; edit() hace load('template') para el picker de paletas
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
- events/_form.blade.php          → partial compartido create/edit: itinerario dinámico, mesa de regalos dinámica, picker de paletas (tarjetas 2x2), dress code con instrucciones por género + color picker, youtube_url, checkbox requires_rsvp
- templates/xv-cottagecore.blade.php  → plantilla cottagecore
- templates/xv-elegante.blade.php     → plantilla elegante (rosa/glass)
- templates/xv-glamour.blade.php      → plantilla glamour (púrpura/dorado, loader, galería masonry, lightbox, CSS override via $event->custom_colors con 4 paletas: Glamour/Oro Rosa/Esmeralda/Zafiro)
- templates/xv-rustico.blade.php      → plantilla rústico boho (terracota/crema, animación de sobre, música YouTube via youtubeVideoId(), dress code Caballeros/Damas + paleta condicional, mesa de regalos configurable, CSS override via $event->custom_colors con 5 paletas: Rústico/Olivo/Vino/Pizarra/Ébano)
- templates/boda-clasica.blade.php
- templates/cumple-moderno.blade.php
- templates/corporativo.blade.php
- templates/tech-oscuro.blade.php
- templates/vaquero.blade.php
- templates/clasica.blade.php

### Itinerario
- Todos los templates muestran la sección de itinerario leyendo `$event->itinerary`
- Si el array está vacío, la sección se oculta automáticamente
- Campos por ítem: time (HH:MM), title, description

### Mesa de regalos (xv-rustico)
- Sección oculta si `$event->gifts` está vacío
- gifts_title y gifts_subtitle configurables con valores por defecto en el template
- Cada ítem: title (requerido), description (opcional), url (opcional → tarjeta se convierte en link)

### RSVP — estado y diseño pendiente
- Campo `requires_rsvp` controla si se muestra la sección RSVP en la invitación
- Dos escenarios a implementar:
  1. **RSVP abierto**: cualquier persona que recibe el link confirma con su nombre (sin token)
  2. **RSVP por lista**: solo invitados en la lista pueden confirmar (usando token único por invitado → `/rsvp/{token}`)
- El flujo real `/rsvp/{token}` ya existe (RsvpController) y funciona con QR ticket
- xv-rustico tiene sección RSVP temporal (decorativa) envuelta en `@if($event->requires_rsvp)`

### Música de fondo
- Campo `youtube_url` en Event, helper `youtubeVideoId()` soporta: youtube.com/watch?v=, youtu.be/, /embed/
- xv-rustico: botón flotante ▶/⏸, autoplay al abrir el sobre, oculto si no hay URL
- Pendiente: aplicar a otros templates

### Paletas de colores
- `color_palettes` en templates: array de paletas con {name, preview[4 hex], vars{css-var: value}}
- El formulario muestra picker de tarjetas 2x2, la selección se guarda en `custom_colors` del evento
- Cada template inyecta un bloque `:root { --var: value }` que sobreescribe los defaults
- Solo xv-rustico y xv-glamour implementados; los demás templates (Tailwind) pendientes

### Galería de fotos en templates
- Todas las secciones de galería muestran solo las fotos reales subidas; si no hay, la sección se oculta
- xv-rustico: grid masonry con layouts [tall, sq, sq, wide, mid, mid], toma hasta 6 fotos desde índice 1
- xv-glamour: galería masonry (hasta 9) + carousel de recuerdos (hasta 5); ambas secciones ocultas si no hay fotos
- Los demás templates usan `@if($event->photos->count() > 1)` con grid simple de Tailwind

### Hora del evento
- Formulario (admin): input nativo `type="time"` → 24 horas
- Invitaciones y vistas RSVP (público): `Carbon::parse($event->event_time)->format('g:i A')` → 12 horas con AM/PM
- xv-glamour ya usaba `g:i A`; cumple-moderno, corporativo y tech-oscuro usan formato split (`g` + `A`) en cards separadas — se respetaron

### CSS / JS
- app.css tiene clases de animación: fade-up, fade-in, scale-in + delay-1..delay-7
- app.js inicializa QR con el paquete `qrcode` en cualquier canvas[data-qr]

### Infraestructura
- **Hosting**: Hostinger (reemplazó a Railway)
- **Dominio producción**: presentacion.carlosmolar.com
- **Deploy manual via SSH**:
  1. SSH al servidor
  2. Navegar a la carpeta del proyecto
  3. `git pull`
  4. Copiar archivos desde carpeta origen (assets compilados)
  5. `php artisan migrate`
  6. `php artisan optimize:clear` / limpiar cache
- AppServiceProvider fuerza HTTPS en producción
- bootstrap/app.php tiene trustProxies(at: '*')

### Pendiente / próximos pasos naturales
- ~~Itinerario dinámico en todos los templates~~ ✓
- ~~Campo requires_rsvp~~ ✓
- ~~Dress code con instrucciones por género y paleta de colores~~ ✓
- ~~Custom colors con picker de paletas en formulario~~ ✓ (xv-rustico y xv-glamour)
- ~~Mesa de regalos configurable~~ ✓ (xv-rustico)
- ~~Música de fondo configurable via youtube_url~~ ✓
- Diseñar e implementar flujo RSVP completo (abierto vs por lista)
- Aplicar mesa de regalos y música a otros templates cuando se trabajen
- Subida de fotos con Cloudflare R2 (config ya preparada en .env.example)
- Envío de invitaciones por WhatsApp
- Pagos con Stripe para planes premium

*Última actualización: 2026-06-07*
