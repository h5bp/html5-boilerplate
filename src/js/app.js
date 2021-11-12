import customElementSupport from 'modernizr-esm/feature/custom-elements';

if (customElementSupport) {
  customElements.define('h5-bp', class H5BP extends HTMLElement {
    get text() {
      return this.getAttribute('text');
    }
    connectedCallback() {
      this.innerHTML = `<p>${this.text}</p>`;
    }
  });
}

