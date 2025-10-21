document.addEventListener('DOMContentLoaded', function () {

    /* =================================================================== */
    /* == LÓGICA PARA O FORMULÁRIO DE CONTATO                           == */
    /* =================================================================== */
    const form = document.querySelector('#form-contato');
    if (form) {
        const resultadoDiv = form.querySelector('.resultado-email');
        const modalSucesso = new bootstrap.Modal(document.getElementById('modalSucesso'));
        const whatsappInput = document.getElementById('whatsapp');
        const roboQuestionText = document.getElementById('robo-question-text');

        // Função para buscar a pergunta anti-robô
        function fetchRoboQuestion() {
            if (!roboQuestionText) return;
            const formData = new FormData();
            formData.append('action', 'get_anti_robo_question');

            fetch(ajax_object.ajax_url, { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        roboQuestionText.textContent = `Quanto é ${data.data.num1} + ${data.data.num2}?`;
                    } else {
                        roboQuestionText.textContent = 'Erro ao carregar. Recarregue a página.';
                    }
                })
                .catch(() => {
                    roboQuestionText.textContent = 'Erro de conexão. Recarregue a página.';
                });
        }

        // Busca a pergunta assim que a página carrega
        fetchRoboQuestion();

        // Máscara de telefone
        if (whatsappInput && typeof IMask !== 'undefined') {
            const mask = IMask(whatsappInput, { mask: '(00) 00000-0000' });

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (!validateForm(mask)) return; // Passa a máscara para a validação

                if (resultadoDiv) resultadoDiv.innerHTML = '';
                const formData = new FormData(form);
                formData.append('action', 'enviar_formulario_ajax');

                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Enviando...';

                fetch(ajax_object.ajax_url, { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            form.reset();
                            mask.updateValue();
                            modalSucesso.show();
                            fetchRoboQuestion();
                        } else {
                            resultadoDiv.innerHTML = `<div class="alert alert-danger">${data.data || 'Ocorreu um problema.'}</div>`;
                            if (data.data && data.data.toLowerCase().includes('anti-robô')) {
                                fetchRoboQuestion();
                            }
                        }
                    })
                    .catch(() => {
                        resultadoDiv.innerHTML = '<div class="alert alert-danger">Erro inesperado. Tente novamente.</div>';
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Enviar';
                    });
            });
        }
        
        // Função de validação
        function validateForm(maskInstance) {
            let isFormValid = true;
            form.querySelectorAll('[required]').forEach(input => {
                const feedbackEl = input.nextElementSibling;
                input.classList.remove('is-invalid');
                if (feedbackEl && feedbackEl.classList.contains('invalid-feedback')) {
                    feedbackEl.textContent = '';
                }

                if (!input.value.trim()) {
                    isFormValid = false;
                    input.classList.add('is-invalid');
                    if (feedbackEl) feedbackEl.textContent = 'Este campo é obrigatório.';
                }
            });

            const emailInput = document.getElementById('email');
            if (emailInput && emailInput.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                isFormValid = false;
                emailInput.classList.add('is-invalid');
                emailInput.nextElementSibling.textContent = 'Por favor, insira um e-mail válido.';
            }

            if (maskInstance && maskInstance.unmaskedValue.length < 10) {
                isFormValid = false;
                whatsappInput.classList.add('is-invalid');
                whatsappInput.nextElementSibling.textContent = 'Por favor, preencha o telefone completo.';
            }

            const roboInput = document.getElementById('resposta_robo');
            if (roboInput && roboInput.value.trim() && isNaN(roboInput.value)) {
                isFormValid = false;
                roboInput.classList.add('is-invalid');
                roboInput.nextElementSibling.textContent = 'Responda com apenas números.';
            }

            return isFormValid;
        }
    }


    /* =================================================================== */
    /* == CONFIGURAÇÃO DO LIGHTBOX                                      == */
    /* =================================================================== */
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "Imagem %1 de %2"
        });
    }


    /* =================================================================== */
    /* == LÓGICA DE ANIMAÇÃO PARA O MAPA E CONTADORES (OTIMIZADA)       == */
    /* =================================================================== */
    function animateCounters() {
        const counters = document.querySelectorAll('.mapa-clientes .counter');
        counters.forEach(counter => {
            const finalValue = +counter.getAttribute('data-final-value');
            if (isNaN(finalValue)) return;
            
            let startValue = 0;
            const duration = 1500; // 1.5 segundos
            const increment = finalValue / (duration / 10);

            const timer = setInterval(() => {
                startValue += increment;
                if (startValue >= finalValue) {
                    startValue = finalValue;
                    clearInterval(timer);
                }
                // Adiciona o sinal de "+" se não houver
                counter.innerText = Math.floor(startValue).toString().startsWith('+') 
                    ? Math.floor(startValue) 
                    : `+${Math.floor(startValue)}`;
            }, 10);
        });
    }
    
    function handleMapAnimation(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const mapaBrasil = document.getElementById('mapa-brasil');
                const pontos = document.querySelectorAll('.sede-ponto');
                
                if (mapaBrasil) mapaBrasil.classList.add('scale-in');
                
                setTimeout(() => {
                    pontos.forEach(ponto => ponto.classList.add('pontos-visiveis'));
                }, 1000); // Mostra os pontos 1s após o mapa começar a animar
                
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }

    const mapaArea = document.getElementById('mapa-area');
    if (mapaArea) {
        const observer = new IntersectionObserver(handleMapAnimation, { threshold: 0.4 });
        observer.observe(mapaArea);
    }

});