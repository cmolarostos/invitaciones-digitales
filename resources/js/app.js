import QRCode from 'qrcode';

// ── QR: genera en cualquier canvas con data-qr ────────────────────────────
document.querySelectorAll('canvas[data-qr]').forEach(canvas => {
    const url = canvas.dataset.qr;
    if (!url) return;

    QRCode.toCanvas(canvas, url, {
        width:           200,
        margin:          2,
        color: {
            dark:  '#1e293b',
            light: '#ffffff',
        },
    });
});
