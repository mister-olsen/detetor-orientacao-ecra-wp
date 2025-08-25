<?php
/**
 * Função para detetar a orientação do dispositivo e sugerir a rotação.
 * Adiciona um aviso não intrusivo no rodapé do site para dispositivos móveis em modo retrato.
 * Este código deve ser adicionado através do plugin "Code Snippets" ou no functions.php do seu tema.
 */
add_action('wp_footer', 'juiceathome_orientation_notice');

function juiceathome_orientation_notice() {
    // 1. CONDIÇÕES DE EXECUÇÃO
    // Apenas executa o código se for um dispositivo móvel e não estivermos na área de administração.
    // A função wp_is_mobile() do WordPress é eficiente para esta verificação inicial.
    if (is_admin() || !wp_is_mobile()) {
        return;
    }

    // 2. DEFINIÇÃO DAS MENSAGENS E ESTILOS (HEREDOC para melhor legibilidade)
    // Usar a sintaxe Heredoc torna a gestão de blocos de HTML, CSS e JS mais limpa e segura.
    
    $notice_text = 'Para uma melhor experiência, por favor, rode o seu dispositivo.';

    // CSS para o aviso. É 'inline' para evitar um pedido HTTP adicional, otimizando o carregamento.
    $styles = <<<CSS
    <style>
        #orientation-notice {
            display: none; /* Começa oculto por defeito */
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.85);
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 15px; /* Cantos arredondados para um look moderno */
            z-index: 99999;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            text-align: center;
            align-items: center;
            justify-content: center;
            gap: 15px; /* Espaço entre o texto e o botão de fechar */
            opacity: 0;
            transition: opacity 0.5s ease-in-out, bottom 0.5s ease-in-out;
            max-width: 90%;
        }
        #orientation-notice.visible {
            display: flex;
            opacity: 1;
            bottom: 30px;
        }
        #close-orientation-notice {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            padding: 0 5px;
            line-height: 1;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        #close-orientation-notice:hover {
            opacity: 1;
        }
    </style>
CSS;

    // HTML do aviso
    $html = <<<HTML
    <div id="orientation-notice" role="alert" aria-live="assertive">
        <p style="margin:0;">{$notice_text}</p>
        <button id="close-orientation-notice" type="button" aria-label="Fechar Aviso">&times;</button>
    </div>
HTML;

    // JavaScript que contém toda a lógica de deteção.
    $javascript = <<<JS
    <script>
        (function() {
            // Espera que o conteúdo da página esteja totalmente carregado.
            document.addEventListener('DOMContentLoaded', function() {
                const notice = document.getElementById('orientation-notice');
                const closeButton = document.getElementById('close-orientation-notice');

                if (!notice || !closeButton) return;

                // Variável para guardar o estado do aviso (se foi fechado pelo utilizador)
                let isDismissed = false;

                // Função principal que verifica a orientação.
                const checkOrientation = () => {
                    // Se o aviso foi fechado, não faz mais nada.
                    if (isDismissed) return;
                    
                    // window.matchMedia é a forma mais compatível e eficiente de verificar a orientação.
                    // Corresponde a uma media query CSS, mas em JavaScript.
                    const isPortrait = window.matchMedia("(orientation: portrait)").matches;

                    if (isPortrait) {
                        notice.classList.add('visible');
                    } else {
                        notice.classList.remove('visible');
                    }
                };

                // Adiciona um 'listener' para o evento de redimensionamento da janela,
                // que também é acionado na mudança de orientação.
                window.addEventListener('resize', checkOrientation);

                // Verifica a orientação assim que a página carrega.
                checkOrientation();

                // Adiciona a funcionalidade ao botão de fechar.
                closeButton.addEventListener('click', function() {
                    isDismissed = true;
                    notice.classList.remove('visible');
                    // Opcional: remover o listener para poupar recursos mínimos após o fecho.
                    window.removeEventListener('resize', checkOrientation);
                });
            });
        })();
    </script>
JS;

    // 3. IMPRESSÃO DO CÓDIGO NO RODAPÉ
    // Imprime o CSS, depois o HTML e finalmente o JavaScript.
    echo $styles;
    echo $html;
    echo $javascript;
}
?>
