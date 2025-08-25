# Detector de Orientação para WordPress

Um script simples, leve e seguro para WordPress que deteta a orientação de ecrã em dispositivos móveis. Se o dispositivo estiver na vertical (modo retrato), exibe uma notificação amigável sugerindo ao utilizador que o rode para a horizontal (modo paisagem) para uma melhor experiência de visualização.

---

## ✨ Funcionalidades

- **Leve e Eficiente:** Utiliza JavaScript nativo (`window.matchMedia`) e não depende de bibliotecas externas como jQuery, garantindo um impacto mínimo no desempenho.
- **Otimizado para WordPress:** O código PHP só é executado em dispositivos móveis (`wp_is_mobile()`) e fora do painel de administração, não carregando recursos desnecessários.
- **Seguro:** Todo o código é contido numa única função e utiliza as melhores práticas do WordPress, como a utilização do hook `wp_footer`.
- **Não Intrusivo:** A notificação aparece de forma suave no rodapé e pode ser facilmente dispensada pelo utilizador.
- **Fácil de Instalar:** Não requer a criação de um plugin completo. Pode ser adicionado através do plugin "Code Snippets" ou diretamente no ficheiro `functions.php` do seu tema.
- **Personalizável:** O texto da notificação e os estilos CSS podem ser facilmente alterados diretamente no código PHP.

## 🚀 Instalação

Existem duas formas simples de adicionar esta funcionalidade ao seu site WordPress:

### Método 1: Usando o Plugin "Code Snippets" (Recomendado)

1.  No seu painel de administração do WordPress, vá a **Plugins > Adicionar Novo**.
2.  Procure por "Code Snippets", instale e ative o plugin.
3.  Vá a **Snippets > Adicionar Novo**.
4.  Dê um título ao seu snippet (ex: "Aviso de Orientação de Ecrã").
5.  Copie o conteúdo completo do ficheiro `orientation-detector.php` e cole na área de código.
6.  Selecione a opção "Executar snippet em todo o lado" (ou "Only run on site front-end").
7.  Guarde as alterações e ative o snippet.

### Método 2: Adicionar ao functions.php

1.  Aceda ao ficheiro `functions.php` do seu tema filho (child theme). **Atenção:** Não é recomendado editar diretamente o `functions.php` do tema principal, pois as alterações serão perdidas ao atualizar o tema.
2.  Copie o conteúdo completo do ficheiro `orientation-detector.php` e cole no final do ficheiro.
3.  Guarde as alterações.

## ⚙️ Como Funciona

- **Verificação no Servidor (PHP):** A função `juiceathome_orientation_notice` é ligada ao `wp_footer` do WordPress. Primeiro, verifica se o pedido vem de um dispositivo móvel (`wp_is_mobile()`). Se não for, a função termina para não carregar código desnecessário.
- **Injeção de Código:** Se a verificação for positiva, o script injeta um bloco de CSS, um elemento HTML para a notificação e um bloco de JavaScript no rodapé da página.
- **Deteção no Cliente (JavaScript):** O JavaScript aguarda que a página esteja totalmente carregada (`DOMContentLoaded`). Depois, utiliza `window.matchMedia("(orientation: portrait)")` para verificar se a orientação do ecrã é vertical. Um *event listener* no evento `resize` garante que a verificação é refeita sempre que o utilizador roda o dispositivo.
- **Interação do Utilizador:** A notificação é exibida ou ocultada com base no resultado da verificação. O utilizador pode fechá-la permanentemente para a sua sessão de navegação clicando no botão '×'.

## 📄 Licença

Este projeto é de código aberto e está licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT).
