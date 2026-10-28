import test from 'node:test';
import assert from 'node:assert/strict';
import { mountPdfViewer } from '../../public/js/certificate-pdf.js';

function fixture() {
    const elements = new Map();
    for (const selector of ['canvas', '[data-pdf-viewport]', '[data-pdf-status]', '[data-pdf-counter]',
        '[data-pdf-previous]', '[data-pdf-next]', '[data-pdf-zoom-out]', '[data-pdf-zoom-in]', '[data-pdf-fit]']) {
        elements.set(selector, {
            disabled: false, hidden: true, style: {}, clientWidth: 320, textContent: '',
            addEventListener(type, handler) { this.handler = handler; },
            click() { if (!this.disabled) this.handler(); },
            getContext() { return {}; },
        });
    }
    const attributes = {};
    const viewer = {
        dataset: { source: 'https://conserpmdd.com/certificados/UNCHANGED/documento', workerUrl: '/vendor/pdfjs/pdf.worker.min.mjs' },
        querySelector(selector) { return elements.get(selector); },
        setAttribute(name, value) { attributes[name] = value; },
    };
    return { viewer, elements, attributes };
}

function library(rendered) {
    const pdf = {
        numPages: 2,
        async getPage(number) {
            return {
                getViewport({ scale }) { return { width: 600 * scale, height: 800 * scale }; },
                render(options) {
                    rendered.push({ number, options });
                    return { promise: Promise.resolve(), cancel() {} };
                },
            };
        },
        destroy() {},
    };
    return { GlobalWorkerOptions: {}, getDocument(options) { this.options = options; return { promise: Promise.resolve(pdf) }; } };
}

test('renders the unchanged document URL to a canvas that fits a phone', async () => {
    globalThis.window = { devicePixelRatio: 3 };
    const { viewer, elements, attributes } = fixture();
    const rendered = [];
    const pdfjs = library(rendered);
    const controller = await mountPdfViewer(viewer, async () => pdfjs);
    assert.equal(pdfjs.options.url, viewer.dataset.source);
    assert.equal(pdfjs.GlobalWorkerOptions.workerSrc, viewer.dataset.workerUrl);
    assert.equal(elements.get('canvas').hidden, false);
    assert.equal(elements.get('canvas').style.width, '304px');
    assert.ok(elements.get('canvas').width <= 608);
    assert.equal(elements.get('[data-pdf-counter]').textContent, 'Página 1 de 2');
    assert.equal(elements.get('[data-pdf-previous]').disabled, true);
    assert.equal(attributes['aria-busy'], 'false');
    controller.destroy();
});

test('can navigate a list across pages and zoom back to fit', async () => {
    globalThis.window = { devicePixelRatio: 1 };
    const { viewer, elements } = fixture();
    const rendered = [];
    const controller = await mountPdfViewer(viewer, async () => library(rendered));
    elements.get('[data-pdf-next]').click();
    await controller.settled();
    assert.equal(elements.get('[data-pdf-counter]').textContent, 'Página 2 de 2');
    assert.equal(elements.get('[data-pdf-next]').disabled, true);
    elements.get('[data-pdf-zoom-in]').click();
    await controller.settled();
    assert.equal(elements.get('canvas').style.width, '380px');
    elements.get('[data-pdf-fit]').click();
    await controller.settled();
    assert.equal(elements.get('canvas').style.width, '304px');
    elements.get('[data-pdf-previous]').click();
    await controller.settled();
    assert.equal(rendered.at(-1).number, 1);
    controller.destroy();
});

test('reports load errors while keeping native open and download as fallbacks', async () => {
    const { viewer, elements, attributes } = fixture();
    const controller = await mountPdfViewer(viewer, async () => { throw new Error('Network unavailable'); });
    assert.match(elements.get('[data-pdf-status]').textContent, /Abrir PDF o Descargar PDF/);
    assert.equal(attributes['aria-busy'], 'false');
    assert.equal(elements.get('[data-pdf-next]').disabled, true);
    controller.destroy();
});
