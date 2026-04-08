class FleetTyre {

    constructor(options) {
        this.container = $(options.container);
        this.selector = options.selector;
        this.svgMap = options.svgMap || {};
        this.modal = $(options.modal);

        this.store = {};
        this.currentCode = null;

        this.init();
    }

    init() {
        this.bindDropdown();
        this.bindEvents();
    }

    bindDropdown() {
        let self = this;

        $(this.selector).on('change', function () {
            self.store = {};
            let val = $(this).val();

            if (self.svgMap[val]) {
                self.loadSVG(self.svgMap[val]);
            }
        });
    }

    async loadSVG(file) {
        let res = await fetch(file);
        let svg = await res.text();

        this.container.html(svg);

        this.bindTyres();
    }

    bindTyres() {
        let self = this;

        this.container.find('.tyre-group').each(function () {
            let code = $(this).data('code');

            if (self.store[code]) {
                $(this).addClass('filled');
            }
        });
    }

    bindEvents() {
        let self = this;

        // click tyre
        $(document).on('click', '.tyre-group', function () {
            let code = $(this).data('code');

            self.currentCode = code;

            let data = self.store[code] || {};

            self.modal.find('#code').val(code);
            self.modal.find('#brand').val(data.brand || '');

            self.modal.show();
        });

        // save
        this.modal.find('#save').on('click', function () {
            let code = self.currentCode;

            self.store[code] = {
                brand: self.modal.find('#brand').val()
            };

            $(`.tyre-group[data-code="${code}"]`).addClass('filled');

            self.closeModal();

            // callback
            if (typeof self.onSave === 'function') {
                self.onSave(self.store);
            }
        });
    }

    closeModal() {
        this.modal.hide();
    }

    getData() {
        return this.store;
    }

    setData(data) {
        this.store = data;
    }

    onSave(callback) {
        this.onSave = callback;
    }
}