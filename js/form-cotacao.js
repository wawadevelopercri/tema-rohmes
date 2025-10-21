document.addEventListener('DOMContentLoaded', function() {
    // --- Variáveis essenciais ---
    const modal = document.getElementById("cotacaoModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.querySelector("#cotacaoModal .close-btn");
    const form = document.getElementById("cotacaoForm");

    // Interrompe a execução se os elementos do modal não existirem na página
    if (!modal || !form) {
        return;
    }

    // --- LÓGICA DE GERENCIAMENTO DE URL ---
    const baseUrl = window.location.pathname.replace(/\/forms-geral\/?$/, '');
    const formUrl = baseUrl.replace(/\/$/, '') + '/forms-geral';

    // --- FUNÇÕES DO MODAL ---
    const openModal = () => {
        modal.style.display = "block";
        document.body.classList.add('no-scroll');
        if (window.location.pathname !== formUrl) {
            history.pushState({ modal: true }, '', formUrl);
        }
    };

    const closeModal = () => {
        modal.style.display = "none";
        document.body.classList.remove('no-scroll');
        if (window.location.pathname === formUrl) {
            history.pushState({ modal: false }, '', baseUrl);
        }
    };

    // --- EVENTOS DE ABERTURA E FECHAMENTO ---
    if (openModalBtn) {
        openModalBtn.addEventListener('click', function(event) {
            event.preventDefault();
            openModal();
        });
    }
    if (closeModalBtn) { closeModalBtn.onclick = closeModal; }
    window.onclick = function(event) { if (event.target == modal) { closeModal(); } };

    if (window.location.pathname.endsWith('/forms-geral') || window.location.pathname.endsWith('/forms-geral/')) {
        openModal();
    }

    window.addEventListener('popstate', function() {
        if (window.location.pathname.includes('/forms-geral')) {
            modal.style.display = 'block';
            document.body.classList.add('no-scroll');
        } else {
            modal.style.display = 'none';
            document.body.classList.remove('no-scroll');
        }
    });

    // --- LÓGICA DE CONSULTA AUTOMÁTICA DE CNPJ ---
    const cnpjInput = document.getElementById('cnpj');
    const cnpjStatus = document.getElementById('cnpj-status');
    const cnpjErrorMessage = document.getElementById('cnpj-error-message');
    const nomeEmpresaInput = document.getElementById('nomeEmpresa');
    const emailInput = document.getElementById('email');

    if (cnpjInput && cnpjStatus && cnpjErrorMessage) {
        
        cnpjInput.addEventListener('input', function() {
            let cnpjValue = this.value.replace(/\D/g, '').slice(0, 14);
            
            let maskedValue = cnpjValue;
            if (maskedValue.length > 12) {
                maskedValue = maskedValue.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
            } else if (maskedValue.length > 8) {
                maskedValue = maskedValue.replace(/^(\d{2})(\d{3})(\d{3})(\d{1,4})/, '$1.$2.$3/$4');
            } else if (maskedValue.length > 5) {
                maskedValue = maskedValue.replace(/^(\d{2})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (maskedValue.length > 2) {
                maskedValue = maskedValue.replace(/^(\d{2})(\d{1,3})/, '$1.$2');
            }
            
            this.value = maskedValue;

            cnpjInput.classList.remove('is-invalid');
            cnpjErrorMessage.textContent = '';
            
            if (nomeEmpresaInput.value && cnpjValue.length < 14) {
                nomeEmpresaInput.value = '';
                emailInput.value = '';
            }
            
            if (cnpjValue.length !== 14) {
                return;
            }

            cnpjStatus.style.display = 'flex';
            fetch(`https://brasilapi.com.br/api/cnpj/v1/${cnpjValue}`)
                .then(response => {
                    if (!response.ok) { throw new Error('CNPJ não encontrado.'); }
                    return response.json();
                })
                .then(data => {
                    if (data.razao_social) nomeEmpresaInput.value = data.razao_social;
                    // Linha do e-mail removida daqui
                })
                .catch(error => {
                    console.error("Erro ao buscar CNPJ:", error.message);
                    cnpjInput.classList.add('is-invalid');
                    cnpjErrorMessage.textContent = 'CNPJ inválido ou não encontrado.';
                })
                .finally(() => {
                    cnpjStatus.style.display = 'none';
                });
        });
    }

    // --- LÓGICA DE ENVIO DO FORMULÁRIO VIA AJAX ---
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (cnpjInput.classList.contains('is-invalid')) {
            alert('Por favor, corrija o CNPJ antes de enviar.');
            return;
        }

        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';

        const formData = new FormData(form);
        formData.append('action', 'enviar_cotacao_ajax');

        fetch(rohmes_ajax.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = window.location.origin + '/agradecimento/';
            } else {
                alert('Houve um erro ao enviar sua cotação. Tente novamente.');
                console.error('Erro do servidor:', data.data);
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            alert('Houve um erro de comunicação. Verifique sua conexão e tente novamente.');
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
    });
});