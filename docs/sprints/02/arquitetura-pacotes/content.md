# Arquitetura Lógica do Sistema

\begin{figure}
	\includegraphics[scale=0.5]{img/arquitetura-pacotes-01.png}
    \caption{Parte 1}
\end{figure}

## Referente a figura Parte 1

#### config/application.config.php

Define quais módulos serão utilizados e quais bibliotecas externas devem ser carregadas.

#### config/autoload/*

Define variáveis globais, locais, parâmetros de conexão com banco de dados.

#### docs/db/*

Arquivos para criação do banco de dados e restrições ACL.

#### docs/sprints/*

Arquivos e artefatos dos sprints numerados sequencialmente: 00, 01, 02, ...

\begin{figure}
	\includegraphics[scale=0.5]{img/arquitetura-pacotes-02.png}
    \caption{Parte 2}
\end{figure}

## Referente a figura Parte 2

#### modules/*

Cada diretório representa um módulo. Módulos no Zend2 foram feitos para serem genéricos
e poderosos onde podemos criar nossas próprias funcionalidades e _plugins_.

Por exemplo, **Admin** e **Application** são módulos MVC. **ZealMessages** é um módulo para
mostrar mensagens de uma _action_ para outra na tela do usuário. No módulo
**Core** temos implementações iniciais de algumas classes e classes que vão ser usadas
por outros módulos MVC.

#### modules/Application/*

Módulo MVC principal, com todos os componentes e interfaces de usuário que interessam
ao usuário comum.

#### modules/Application/config/module.config.php

Responsável pelo mapeamento de rotas, mapeamentos dos _Controllers_, instanciação
dos _Models_, carregar arquivos _gettext_ para a internacionalização (i18n).

#### modules/Application/language/*

Contém os arquivos _.po_ usados pelo _gettext_.

#### modules/Application/src/Application/*

Possui a estrutura:

* **Controller**: trata da regra de negócios.
* **Form**: classes responsáveis pelos formulários e filtros de validação.
* **Model**: classes modelo e classes de acesso ao banco.
* **Service**: serviços, como autenticação.

#### modules/Application/tests/*

Testes unitários do sistema.

#### modules/Application/view/*

Único local que código _PHP_ é misturado com _HTML_. Sua estrutura:

* **application**: arquivos _.phtml_ referentes aos _controllers/actions_ do módulo _application_.
* **error**: _layout_ para páginas de erro, podemos criar layouts para erro _404 (Not Found)_, etc.
* **layout**: _layout_ que faz _wrapper_ (envolve) todas as páginas, contém código
	comum a todas as páginas e inclui todas as outras.
* **partials**: trechos de código que se repetem, ou trechos não acoplados que são separados
	para deixar código mais limpo e de fácil manutenção.

\begin{figure}
	\includegraphics[scale=0.5]{img/arquitetura-pacotes-03.png}
    \caption{Parte 3}
\end{figure}

## Referente a figura Parte 3

#### public/*

Contém todos os arquivos públicos. Sua estrutura:

* **css**: folhas de estilo.
* **js**: arquivos javascript.
* **images**: arquivos de imagens.
* **lib**: bibliotecas externas.
	* **css**: folhas de estilo das bibliotecas externas.
    * **js**: arquivos javascript.
    * **fonts**: web fonts.

#### public/index.php

Único arquivo php público responsável por fazer o Bootstrap (arranque) do sistema.

