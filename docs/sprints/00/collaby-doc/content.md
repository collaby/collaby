# Projeto Ferramenta colaborativa de aprendizado

Proposta de criação de ferramenta web para aprendizado colaborativo,
onde é possível compartilhar exercícios, listas ou materiais de estudo.

Principais pontos:

* Exercícios, materiais de aula, etc. são criados e compartilhados.
* Documentos podem ser editados em equipe utilizando Together.js

<https://togetherjs.com/>: ferramenta desenvolvida pela Mozilla
que adiciona uma ferramenta colaborativa a qualquer website.

\begin{figure}
	\includegraphics[scale=0.5]{img/togetherjs.png}
	\caption{Together.js}
\end{figure}

* Documentos são públicos para leitura, podendo também ser públicos
	para escrita se assim o usuário desejar.
* Documentos são escritos em markdown com suporte a fórmulas matemáticas
	em LaTeX usando pandoc, MathJax.

<http://daringfireball.net/projects/markdown/dingus>: markdown é uma linguagem
de marcação fácil de ler e escrever que pode gerar textos HTML, LaTeX.

\begin{figure}
	\includegraphics[scale=0.45]{img/markdown.png}
	\caption{Sintaxe Markdown}
\end{figure}

<http://johnmacfarlane.net/pandoc/>: converte textos em markdown para HTML,
LaTeX, entre outros.

<http://www.mathjax.org/>: renderiza fórmulas matemáticas LaTeX no browser.

* Documentos podem ser exportados para PDF ou HTML usando pandoc.
* Lista de links de referência.
* Importar/Exportar de um arquivo markdown.
* Documentos tem suporte a linguagens de programação, podendo o código
	ser embutido e mostrado com o devido highlighting.
* Documentos podem ser apresentações em LaTeX beamer ou slides em HTML5.

# Objetivos

* Proporcionar um local central de informações compartilhadas
* Descentralizar a resolução de exercícios
* Criar um local especializado na geração de documentos científicos
* Incentivar alunos a utilizarem LaTeX desde cedo
* Incentivar uso de tecnologias como markdown na criação de documentos
* Aumentar o nível dos projetos haja vista que o número de projetos diferentes
	deverá aumentar.

# Tecnologias Utilizadas

* Zend Framework 2 - ambiente web estável e completo.
* Together.js - torna página colaborativa.
* Mathjax - mostra fórmulas matemáticas escritas em LaTeX na web.
* Pandoc - converte arquivos markdown em pdf, html.
* Twitter Bootstrap 3 - front-end.
* jQuery 2 - eventos, ajax.
* Codemirror - web text editor.
* FontAwesome 4 - icon web fonts.