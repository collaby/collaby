# Introdução

Num mundo cada vez mais _online_ pessoas necessitam cada vez mais ferramentas onde
possam trabalhar juntas sem a necessidade de estarem no mesmo lugar. Com essa ideia
surgiram ferramentas colaborativas como Google Docs, que permite editar Documentos,
Planilhas e Apresentações com vários usuários envolvidos. Daí surge outra necessidade,
uma ferramenta que se encaixe no âmbito científico. Surge então o Projeto Collaby.

## Finalidade

* Proporcionar um local central de informações compartilhadas
* Descentralizar a resolução de exercícios
* Criar um local especializado na geração de documentos científicos
* Incentivar alunos a utilizarem LaTeX desde cedo
* Incentivar uso de tecnologias como markdown na criação de documentos
* Aumentar o nível dos projetos haja vista que o número de projetos diferentes
	deverá aumentar.

## Definições, Acrônimos e Abreviações

* Front-end: é a parte do sistema de software que interage diretamente com o usuário.
* _free_: termo que, em software, significa liberdades em relação a distribuição do código-fonte,
	criado por Richard M. Stallman.
* _open-source_: propriedade intelectual que é disponível livremente através de licença pública
	por seus criadores.
* ajax: Asynchronous JavaScript and XML.

## Referências

* [TogetherJS: torna página colaborativa](https://togetherjs.com/)
* [Definição da linguagem de marcação Markdown](http://daringfireball.net/projects/markdown/dingus)
* [Pandoc: converte documentos em Markdown para PDF, HTML](http://johnmacfarlane.net/pandoc/)
* [Mathjax: renderiza fórmulas matemáticas LaTeX no browser](http://www.mathjax.org/)
* [Zend Framework 2 - ambiente web estável e completo](http://framework.zend.com/zf2)
* [Twitter Bootstrap 3 - front-end](http://getbootstrap.com/)
* [jQuery 2 - eventos, ajax](http://jquery.com/)
* [Ace Editor - editor markdown web](http://ace.c9.io/#nav=about)
* [FontAwesome 4 - icon web fonts](http://FontAwesome.github.io/)
* [Marked - fast mardown compiler](https://github.com/chjj/marked)
* [localForage - offline storage](https://github.com/mozilla/localForage)

## Visão Geral

# Descrição do Produto

Collaby é uma ferramenta web para aprendizado colaborativo,
onde é possível compartilhar exercícios, listas, materiais de estudo, apresentação de slides, etc.

# Contexto do Negócio

Funcionará no contexto acadêmico, tanto para discentes quanto docentes. É um projeto _free_ e _open-source_.

#### Mas porque usar linguagem Markdown?

Essa resposta pode ser obtida vendo o uso do Markdown na internet. Veja alguns sites que
a utilizam:

* [Github](http://github.com) - README e outros documentos; Wiki;
* [Stackoverflow](http://stackoverflow.com/) - perguntas e respostas;
* [Leanpub](https://leanpub.com/authors#how_leanpub_works) - autoria de livros;
* [Ghost](https://ghost.org/) - blogging platform;
* [dillinger](https://github.com/joemccann/dillinger) - editor _online_ com suporte a upload
	para Dropbox, Google Drive ou Github.
* entre outros.

Além disso hoje temos a necessidade de ter livros, artigos ou outros tipos de texto
disponíveis para Desktop, Tablet e smartphones. Dessa forma usar Markdown
centraliza o foco no texto e deixa a formatação para outras ferramentas como
o pandoc.

# Objetivos do Produto

* Exercícios, materiais de aula, etc. são criados e compartilhados.
* Documentos podem ser editados em equipe utilizando TogetherJS
* Documentos são públicos para leitura, podendo também ser públicos
	para escrita se assim o usuário desejar.
* Documentos são escritos em markdown com suporte a fórmulas matemáticas
	em LaTeX usando pandoc, MathJax.
* Documentos podem ser exportados para PDF ou HTML usando pandoc.
* Lista de links de referência.
* Importar/Exportar de um arquivo markdown.
* Documentos tem suporte a linguagens de programação, podendo o código
	ser embutido e mostrado com o devido highlighting.
* Documentos podem ser apresentações em LaTeX beamer ou slides em HTML5.

# Estimativas Financeiras

Gastos incluem:

* Domínio
* Hospedagem

# Restrições

* A colaboratividade pode ser afetada caso a ferramenta TogetherJS seja descontinuada.
* O editor web codemirror caso deixe de ser mantido pode deixar de funcionar nos browsers cada vez mais modernos.

