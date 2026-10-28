export async function mountPdfViewer(viewer, loadLibrary = () => import(viewer.dataset.libraryUrl)) {
    const canvas = viewer.querySelector('canvas');
    const viewport = viewer.querySelector('[data-pdf-viewport]');
    const status = viewer.querySelector('[data-pdf-status]');
    const counter = viewer.querySelector('[data-pdf-counter]');
    const previous = viewer.querySelector('[data-pdf-previous]');
    const next = viewer.querySelector('[data-pdf-next]');
    const zoomOut = viewer.querySelector('[data-pdf-zoom-out]');
    const zoomIn = viewer.querySelector('[data-pdf-zoom-in]');
    const fit = viewer.querySelector('[data-pdf-fit]');
    const controls = [previous, next, zoomOut, zoomIn, fit];
    let pdf;
    let pageNumber = 1;
    let zoom = 1;
    let renderTask;
    let version = 0;
    let queue = Promise.resolve();
    let resizeTimer;
    let observer;
    let disposed = false;

    const updateControls = (busy) => {
        previous.disabled = busy || pageNumber === 1;
        next.disabled = busy || !pdf || pageNumber === pdf.numPages;
        zoomOut.disabled = busy || zoom <= 0.75;
        zoomIn.disabled = busy || zoom >= 2.5;
        fit.disabled = busy;
        viewer.setAttribute('aria-busy', String(busy));
    };

    const render = () => {
        const ticket = ++version;
        renderTask?.cancel();
        updateControls(true);
        status.textContent = 'Cargando página…';
        queue = queue.catch(() => {}).then(async () => {
            if (ticket !== version || disposed) return;
            try {
                const page = await pdf.getPage(pageNumber);
                if (ticket !== version || disposed) return;
                const original = page.getViewport({ scale: 1 });
                const availableWidth = Math.max(160, viewport.clientWidth - 16);
                const scaled = page.getViewport({ scale: availableWidth / original.width * zoom });
                // Keep a single page in memory and limit bitmap size on mobile devices.
                const pixelRatio = Math.min(window.devicePixelRatio || 1, 2,
                    Math.sqrt(5000000 / (scaled.width * scaled.height)));
                canvas.width = Math.floor(scaled.width * pixelRatio);
                canvas.height = Math.floor(scaled.height * pixelRatio);
                canvas.style.width = `${Math.floor(scaled.width)}px`;
                canvas.style.height = `${Math.floor(scaled.height)}px`;
                renderTask = page.render({
                    canvasContext: canvas.getContext('2d'),
                    viewport: scaled,
                    transform: pixelRatio === 1 ? null : [pixelRatio, 0, 0, pixelRatio, 0, 0],
                });
                await renderTask.promise;
                if (ticket !== version || disposed) return;
                canvas.hidden = false;
                counter.textContent = `Página ${pageNumber} de ${pdf.numPages}`;
                status.textContent = '';
                updateControls(false);
            } catch (error) {
                if (error.name === 'RenderingCancelledException' || ticket !== version || disposed) return;
                canvas.hidden = true;
                status.textContent = 'No se pudo mostrar esta página. Puedes utilizar Abrir PDF o Descargar PDF.';
                updateControls(false);
            }
        });
        return queue;
    };

    previous.addEventListener('click', () => { pageNumber = Math.max(1, pageNumber - 1); render(); });
    next.addEventListener('click', () => { pageNumber = Math.min(pdf.numPages, pageNumber + 1); render(); });
    zoomOut.addEventListener('click', () => { zoom = Math.max(0.75, zoom - 0.25); render(); });
    zoomIn.addEventListener('click', () => { zoom = Math.min(2.5, zoom + 0.25); render(); });
    fit.addEventListener('click', () => { zoom = 1; render(); });
    updateControls(true);

    try {
        const library = await loadLibrary();
        library.GlobalWorkerOptions.workerSrc = viewer.dataset.workerUrl;
        pdf = await library.getDocument({
            url: viewer.dataset.source,
            cMapUrl: viewer.dataset.cmapUrl,
            cMapPacked: true,
            standardFontDataUrl: viewer.dataset.fontUrl,
            wasmUrl: viewer.dataset.wasmUrl,
            isEvalSupported: false,
        }).promise;
        await render();
        let lastWidth = viewport.clientWidth;
        if (typeof ResizeObserver !== 'undefined') {
            observer = new ResizeObserver(() => {
                if (viewport.clientWidth === lastWidth) return;
                lastWidth = viewport.clientWidth;
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(render, 150);
            });
            observer.observe(viewport);
        }
    } catch (error) {
        status.textContent = 'No se pudo cargar la vista previa. Puedes utilizar Abrir PDF o Descargar PDF.';
        viewer.setAttribute('aria-busy', 'false');
        controls.forEach((control) => { control.disabled = true; });
    }

    return {
        settled: () => queue,
        destroy: () => {
            disposed = true;
            ++version;
            clearTimeout(resizeTimer);
            observer?.disconnect();
            renderTask?.cancel();
            pdf?.destroy();
        },
    };
}

if (typeof document !== 'undefined') {
    const viewer = document.querySelector('[data-certificate-pdf]');
    if (viewer) mountPdfViewer(viewer);
}
