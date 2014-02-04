# Requisitos

Estes são os requisitos escolhidos para serem feitos no sprint 01.

## Requisitos Funcionais

### Login

Mapeada como: `/login [Application\Controller\Auth.login]`

Responsável: Átila

Página de login tradicional usando usuário e senha.

Colocar opções para Criar Conta \ref{signup}.

### Criar Conta \label{signup}

Mapeado como: `/signup [Application\Controller\Account.signup]`

Responsável: Péricles

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

Responsável: Átila

Quando o usuário requisitar um novo documento, o mesmo é criado com valores padrão e
logo em seguida o usuário é levado a Editar Documento \label{edit-document}.

Ao editar o documento pela primeira vez, uma tela modal aparece para que o usuário
possa editar o nome do documento e escolher um tema. Ao final ele clica em um botão "Ok".

Daí ele vai para a edição do documento em si \ref{edit-document}.

### Editar Documento \label{edit-document}

Mapeado como: `/d/:id [Application\Controller\Document.edit]`

Responsável: Jovane

#### Usuário logado e dono do documento

Abre o documento em modo de edição.

Esta tela deve ser aberta em nova aba, isso se deve ao fato de que ela será
uma tela diferenciada e além disso será uma tela que pode ser compartilhada
para que outras pessoas possam editá-la ao mesmo tempo de forma colaborativa.
Além disso faz com que não seja possível usar o botão "Voltar" do browser,
tendo em vista que o histórico não existe numa aba aberta pela primeira vez.

Ela possui um editor de texto com suporte a _highlight_ para **Markdown**.

Deve haver um menu com as opções de Salvar e Pré-visualizar. Além de opções de formatação
como negrito, itálico, links, código _inline_, desfazer, refazer.