# Requisitos

## Requisitos Funcionais

### Página inicial \label{home}

Mapeada como: `/ [Application\Controller\Index.index]`

#### Usuário deslogado

Deve mostrar uma lista com os últimos documentos com a seguinte ordem: última
atualização descendente.

Na lista deve aparecer o nome do documento, um link para visualização,
nome do dono do documento, link para o usuário dono, data de atualização,
tags para o documento, link para buscar documento por tag.

Caso o documento seja um clone mostrar o link para documento original.

#### Usuário logado

Deve mostrar os documentos do usuário logado, permitindo link de edição ao invés
de visualização.

### Login

Mapeada como: `/login [Application\Controller\Auth.login]`

Página de login tradicional usando usuário e senha, com adição da opção de
login com a conta do _Twitter_, _Facebook_ ou _Google+_.

Links úteis:

* <https://dev.twitter.com/docs/auth/sign-twitter>
* <https://developers.facebook.com/docs/facebook-login/login-flow-for-web/>
* <https://developers.google.com/+/quickstart/javascript>

Colocar opções para Redefinir Senha \ref{reset-pass} e Criar Conta \ref{signup}.

### Redefinir Senha \label{reset-pass}

Mapeado como: `/reset-password [Application\Controller\Account.reset-password]`

Caso o usuário esqueça a senha é necessário que ele a redefina. Para isso ele deve
preencher uma tela com os dados:

* nome de usuário ou e-mail
* Captcha, para garantir que não é um robô.

Em seguida um _hash_ de recuperação de senha é criado com a validade de 1 dia.
Daí um e-mail é enviado para o usuário com os dados da solicitação: mensagem,
link de recuperação, validade do link.

Ao acessar o link, verifica se o _hash_ é válido e mostra a tela para digitar nova senha.

### Criar Conta \label{signup}

Mapeado como: `/signup [Application\Controller\Account.signup]`

Criar uma conta deve ser muito simples. A página requisita apenas:

* nome de usuário
* senha
* e-mail

Em seguida um e-mail será enviado para o e-mail informado contendo uma mensagem
de boas vindas e o link para a validação do cadastro. O link é composto pela url
do site seguida de um _hash_. Ao fazer a requisição o _hash_ é verificado com no
banco de dados e o usuário é validado.

O _hash_ deve ser criado a partir do nome do usuário, o e-mail e um _salt_,
que é um pequeno _hash_.

Referências sobre _salt_:

* [Salted Password Hashing - Doing it Right](https://crackstation.net/hashing-security.htm#salt)
* [Salt (cryptography)](http://en.wikipedia.org/wiki/Salt_(cryptography))

O nome de usuário deve ser único, assim como o e-mail. Assim sendo antes de criar a conta
deve-se verificá-los antes de prosseguir com a criação da conta.

### Novo Documento

Mapeado como: `/new [Application\Controller\Document.new]`

Quando o usuário requisitar um novo documento, o mesmo é criado com valores padrão e
logo em seguida o usuário é levado a Editar Documento \label{edit-document}.

Ao editar o documento pela primeira vez, uma tela modal aparece para que o usuário
possa editar o nome do documento e escolher um tema. Ao final ele clica em um botão "Ok".

Daí ele vai para a edição do documento em si \ref{edit-document}.

### Editar Documento \label{edit-document}

Mapeado como: `/d/:id [Application\Controller\Document.edit]`

#### Usuário deslogado ou usuário logado que não é dono do documento

Redireciona usuário para modo de visualização (_read-only_) \ref{view-document}.

#### Usuário logado e dono do documento

Abre o documento em modo de edição.

Esta tela deve ser aberta em nova aba, isso se deve ao fato de que ela será
uma tela diferenciada e além disso será uma tela que pode ser compartilhada
para que outras pessoas possam editá-la ao mesmo tempo de forma colaborativa.
Além disso faz com que não seja possível usar o botão "Voltar" do browser,
tendo em vista que o histórico não existe numa aba aberta pela primeira vez.

Ela possui um editor de texto com suporte a _highlight_ para **Markdown**.

Deve haver um menu com as opções de Salvar e Pré-visualizar.

Do lado esquerdo um menu para definir qual arquivo editar, **content** ou **template**.

Logo abaixo a estrutura do arquivo em forma de árvore, onde aparecerão
links para as linhas que iniciam com \#.

E no rodapé uma caixa de mensagens, com o _log_ para detectar possíveis erros ao
gerar o ducumento em pdf.

### Exportar Documento

Mapeado como: `/d/:id/export[/:type] [Application\Controller\Document.export]`

Opção vista em Editar Documento \ref{edit-document} e Visualizar Documento \ref{view-document}.

Permite exportar o documento para PDF ou HTML, sendo o tipo padrão é PDF. Ao gerar o arquivo
ele deve ser mandando para o browser em forma de download.

Caso o arquivo seja HTML, ele deve ser mandado como um arquivo único. Isso significa que
se ele possui CSS ou Javascript deve vir embutido no arquivo.

### Importar Documento

Mapeado como: `/import [Application\Controller\Document.import]`

Página destinada a usuários logados que desejam submeter um arquivo Markdown existente
e a partir dele criar um documento.

Além de um formulário contendo um _input file_ deve permitir o nome do arquivo
bem como o layout a ser usado.

### Clonar Documento

Mapeado como: `/clone/:id [Application\Controller\Document.clone]`

Todo documento deve ser público, sendo posível assim clonar qualquer um deles.
É possível clonar um documento a partir da página Visualizar Documento \ref{view-document}.

É um processo simples onde todas as informações do documento são copiadas de um usuário
para outro. Todavia, como um clone, a edição dos arquivos se torna independente.

### Visualizar Usuário

Mapeado como: `/u/:username [Application\Controller\User.view]`

Página destinada a mostrar dados e os documentos de um usuário. De onde outros usuário podem
ver e clonar seus documentos.

Os documentos tem a mesma visualização da página inicial \ref{home}.

### Visualizar Documento \label{view-document}

Mapeado como: `/view/:id [Application\Controller\Document.view]`

Visualização HTML do documento **Markdown** com suporte a fórmulas matemáticas (MathJax).

## Requisitos Não-funcionais

### Traduzir a ferramenta TogetherJS

Por ser uma ferramenta muito nova ainda não possui tradução nem mesmo está sujeita ainda.
Devido a isso temos duas opções:

* Traduzir os arquivos de forma bruta (Mais fácil mas de difícil manutenção pois quando
	a ferramenta for atualizada temos que sair de arquivo em arquivo retraduzindo).
* Criar um mecanismo de tradução que irá ajudar a ferramenta para que seja possível
	traduzir para qualquer língua (Mais difícil mas podemos ser os primeiros a
    tornar a ferramenta traduzível e contribuir com um programa da Mozilla).

### Sincronização de cursor do Ace Editor

Existe um problema com a ferramenta TogetherJS em conjunto com o Ace Editor no qual
quando o documento é atualizado o cursor dos outros participantes é resetado para
o início do documento.

Outros detalhes em:

* <https://github.com/mozilla/togetherjs/pull/927>
* <https://github.com/triglian/togetherjs>
* [Ace Editor](http://ace.c9.io/#nav=about)