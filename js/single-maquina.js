document.addEventListener('DOMContentLoaded', function() {

    // =========================================================================
    // == LÓGICA PARA A GALERIA DE IMAGENS (Esta parte permanece a mesma)     ==
    // =========================================================================
    const mainImage = document.getElementById('mainImage');
    const mainImageLink = document.getElementById('mainImageLink');
    const thumbnails = document.querySelectorAll('.thumbnail-img');

    if (typeof GLightbox !== 'undefined') {
        const lightbox = GLightbox({
            selector: '.glightbox'
        });

        if (mainImage && thumbnails.length > 0) {
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function(event) {
                    event.preventDefault();
                    const largeImageUrl = this.dataset.large;

                    if (largeImageUrl) {
                        mainImage.src = largeImageUrl;
                        if (mainImageLink) {
                            mainImageLink.href = largeImageUrl;
                            lightbox.reload();
                        }
                        thumbnails.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });
        }
    }

    // =========================================================================
    // == LÓGICA UNIFICADA PARA ABRIR E FECHAR MODAIS DE COTAÇÃO             ==
    // =========================================================================
    // Seleciona TODOS os botões que têm a classe 'open-modal-btn'
    const quoteModalButtons = document.querySelectorAll('.open-modal-btn');

    quoteModalButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Pega o seletor do modal alvo do atributo 'data-target'
            const modalSelector = this.getAttribute('data-target');
            const modal = document.querySelector(modalSelector);

            if (modal) {
                modal.style.display = "block";
                document.body.classList.add('no-scroll');
            }
        });
    });

    // Lógica genérica para FECHAR os modais
    const allQuoteModals = document.querySelectorAll('.modal-corte-laser, .modal-dobradeira, .modal-solda-laser');
    allQuoteModals.forEach(modal => {
        const closeBtn = modal.querySelector('.close-btn-corte-laser, .close-btn-dobradeira, .close-btn-solda-laser');

        // Fechar pelo botão 'X'
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modal.style.display = "none";
                document.body.classList.remove('no-scroll');
            });
        }
        
        // Fechar clicando fora do conteúdo do modal
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
                document.body.classList.remove('no-scroll');
            }
        });
    });

    // =========================================================================
    // == LÓGICA ESPECÍFICA DOS FORMULÁRIOS (Validação, Envio, etc.)         ==
    // =========================================================================
    // A lógica de abrir/fechar foi movida para cima. Aqui fica apenas o que cada formulário faz.

    // --- Formulário de Corte a Laser ---
    const laserForm = document.getElementById("corteLaserForm");
    if (laserForm) {
        const cnpjInput = document.getElementById('cl-cnpj'), cnpjStatus = document.getElementById('cl-cnpj-status'), cnpjErrorMessage = document.getElementById('cl-cnpj-error-message'), nomeEmpresaInput = document.getElementById('cl-nomeEmpresa'), telefoneInput = document.getElementById('cl-telefone');
        if (cnpjInput) {
            cnpjInput.addEventListener('input', function() {
                let cnpjValue = this.value.replace(/\D/g, '').slice(0, 14); this.value = cnpjValue.replace(/^(\d{2})(\d)/, '$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3').replace(/\.(\d{3})(\d)/, '.$1/$2').replace(/(\d{4})(\d)/, '$1-$2'); cnpjInput.classList.remove('is-invalid'); cnpjErrorMessage.textContent = ''; if (nomeEmpresaInput.value && cnpjValue.length < 14) { nomeEmpresaInput.value = ''; telefoneInput.value = ''; } if (cnpjValue.length !== 14) return; cnpjStatus.style.display = 'flex'; fetch(`https://brasilapi.com.br/api/cnpj/v1/${cnpjValue}`).then(r => { if (!r.ok) throw new Error('CNPJ não encontrado'); return r.json(); }).then(d => { if (d.razao_social) nomeEmpresaInput.value = d.razao_social; }).catch(e => { cnpjInput.classList.add('is-invalid'); cnpjErrorMessage.textContent = 'CNPJ inválido ou não encontrado.'; }).finally(() => { cnpjStatus.style.display = 'none'; });
            });
        }
        if (telefoneInput) { telefoneInput.addEventListener('input', function() { let v = this.value.replace(/\D/g, '').slice(0, 11); this.value = v.replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2'); }); }
        laserForm.addEventListener('submit', function(e) { e.preventDefault(); if (cnpjInput && cnpjInput.classList.contains('is-invalid')) { alert('Por favor, corrija o CNPJ.'); return; } const btn = laserForm.querySelector('button[type="submit"]'); btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enviando...'; const fd = new FormData(laserForm); fd.append('action', 'enviarcortelaserajax'); fetch(rohmes_ajax.ajax_url, { method: 'POST', body: fd }).then(r => r.json()).then(d => { if (d.success) { window.location.href = window.location.origin + '/agradecimento/'; } else { throw new Error(d.data); } }).catch(e => { alert('Houve um erro.'); btn.disabled = false; btn.innerHTML = 'Continuar'; }); });
    }

    // --- Formulário de Dobradeira ---
    const dobradeiraForm = document.getElementById("dobradeiraForm");
    if (dobradeiraForm) {
        const d_cnpjInput = document.getElementById('d-cnpj'), d_cnpjErrorMessage = document.getElementById('d-cnpj-error-message'), d_nomeEmpresaInput = document.getElementById('d-nomeEmpresa'), d_telefoneInput = document.getElementById('d-telefone');
        if (d_cnpjInput) {
            d_cnpjInput.addEventListener('input', function() {
                let cnpjValue = this.value.replace(/\D/g, '').slice(0, 14); this.value = cnpjValue.replace(/^(\d{2})(\d)/, '$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3').replace(/\.(\d{3})(\d)/, '.$1/$2').replace(/(\d{4})(\d)/, '$1-$2'); d_cnpjInput.classList.remove('is-invalid'); d_cnpjErrorMessage.textContent = ''; if (d_nomeEmpresaInput.value && cnpjValue.length < 14) { d_nomeEmpresaInput.value = ''; d_telefoneInput.value = ''; } if (cnpjValue.length !== 14) return; fetch(`https://brasilapi.com.br/api/cnpj/v1/${cnpjValue}`).then(r => { if (!r.ok) throw new Error('CNPJ não encontrado'); return r.json(); }).then(d => { if (d.razao_social) d_nomeEmpresaInput.value = d.razao_social; }).catch(e => { d_cnpjInput.classList.add('is-invalid'); d_cnpjErrorMessage.textContent = 'CNPJ inválido ou não encontrado.'; });
            });
        }
        if (d_telefoneInput) { d_telefoneInput.addEventListener('input', function() { let v = this.value.replace(/\D/g, '').slice(0, 11); this.value = v.replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2'); }); }
        dobradeiraForm.addEventListener('submit', function(e) { e.preventDefault(); if (d_cnpjInput && d_cnpjInput.classList.contains('is-invalid')) { alert('Por favor, corrija o CNPJ.'); return; } const btn = dobradeiraForm.querySelector('button[type="submit"]'); btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enviando...'; const fd = new FormData(dobradeiraForm); fd.append('action', 'enviar_dobradeira_ajax'); fetch(rohmes_ajax.ajax_url, { method: 'POST', body: fd }).then(r => r.json()).then(d => { if (d.success) { window.location.href = window.location.origin + '/agradecimento/'; } else { throw new Error(d.data); } }).catch(e => { alert('Houve um erro.'); btn.disabled = false; btn.innerHTML = 'Enviar Cotação'; }); });
    }

    // --- Formulário de Solda a Laser ---
    const soldaLaserForm = document.getElementById("soldaLaserForm");
    if (soldaLaserForm) {
        const s_cnpjInput = document.getElementById('s-cnpj'), s_cnpjErrorMessage = document.getElementById('s-cnpj-error-message'), s_nomeEmpresaInput = document.getElementById('s-nomeEmpresa'), s_telefoneInput = document.getElementById('s-telefone');
        if (s_cnpjInput) {
            s_cnpjInput.addEventListener('input', function() {
                let cnpjValue = this.value.replace(/\D/g, '').slice(0, 14); this.value = cnpjValue.replace(/^(\d{2})(\d)/, '$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3').replace(/\.(\d{3})(\d)/, '.$1/$2').replace(/(\d{4})(\d)/, '$1-$2'); s_cnpjInput.classList.remove('is-invalid'); s_cnpjErrorMessage.textContent = ''; if (s_nomeEmpresaInput.value && cnpjValue.length < 14) { s_nomeEmpresaInput.value = ''; s_telefoneInput.value = ''; } if (cnpjValue.length !== 14) return; fetch(`https://brasilapi.com.br/api/cnpj/v1/${cnpjValue}`).then(r => { if (!r.ok) throw new Error('CNPJ não encontrado'); return r.json(); }).then(d => { if (d.razao_social) s_nomeEmpresaInput.value = d.razao_social; }).catch(e => { s_cnpjInput.classList.add('is-invalid'); s_cnpjErrorMessage.textContent = 'CNPJ inválido ou não encontrado.'; });
            });
        }
        if (s_telefoneInput) { s_telefoneInput.addEventListener('input', function() { let v = this.value.replace(/\D/g, '').slice(0, 11); this.value = v.replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2'); }); }
        soldaLaserForm.addEventListener('submit', function(e) { e.preventDefault(); if (s_cnpjInput && s_cnpjInput.classList.contains('is-invalid')) { alert('Por favor, corrija o CNPJ.'); return; } const btn = soldaLaserForm.querySelector('button[type="submit"]'); btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enviando...'; const fd = new FormData(soldaLaserForm); fd.append('action', 'enviar_solda_laser_ajax'); fetch(rohmes_ajax.ajax_url, { method: 'POST', body: fd }).then(r => r.json()).then(d => { if (d.success) { window.location.href = window.location.origin + '/agradecimento/'; } else { throw new Error(d.data); } }).catch(e => { alert('Houve um erro.'); btn.disabled = false; btn.innerHTML = 'Enviar Cotação'; }); });
    }

    // =========================================================================
    // == LÓGICA PARA O MODAL NR 12 (Esta parte permanece a mesma)             ==
    // =========================================================================
    const nr12Modal = document.getElementById("nr12Modal");
    const openNr12Btn = document.getElementById("openNr12ModalBtn");

    if (nr12Modal && openNr12Btn) {
        const closeNr12Btn = nr12Modal.querySelector(".close-btn-nr12");
        const closeNr12FooterBtn = document.getElementById("closeNr12ModalBtnFooter");
        
        const openModal = () => { nr12Modal.style.display = "block"; document.body.classList.add('no-scroll'); };
        const closeModal = () => { nr12Modal.style.display = "none"; document.body.classList.remove('no-scroll'); };

        openNr12Btn.addEventListener('click', (e) => { e.preventDefault(); openModal(); });

        if (closeNr12Btn) { closeNr12Btn.onclick = closeModal; }
        if (closeNr12FooterBtn) { closeNr12FooterBtn.onclick = closeModal; }

        window.addEventListener('click', (e) => {
            if (e.target == nr12Modal) { closeModal(); }
        });
    }
});