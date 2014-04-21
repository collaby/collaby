# Análise GRASP

O Zend Framework é um grande exemplo de utilização de padrões de projeto.

## Caso de Uso: Novo Documento

Para o caso de uso Novo Documento precisamos de um Controlador, um Criador e um Especialista.
Vejamos a figura \ref{dia-seq-novo-documento}.

\begin{figure}[h]
	\includegraphics[scale=0.4]{img/DiagramaSequenciaNovoDocumento.jpg}
	\caption{Dia. Seq. Novo Documento}
    \label{dia-seq-novo-documento}
\end{figure}

Nela podemos ver de cara o padrão Controlador na classe **DocumentController**. Ela
é uma classe que extende de **AbstractActionController**, que faz parte do Zend Framework.
É a classe responsável por capturar a interação do usuário e delegar os eventos para
uma determinada **Action** (ação). Veja que a chamada que origina tudo é **newAction**.
No Zend sempre que você colocar **Action** no final do método, quer dizer que esse método
é uma ação que o controlador deve receber e tratar.

Em seguida o controlador cria o Formulário **NewDocument**. É função do controlador criar
o formulário sempre que a ação **newAction** for requisitada. Aqui podemos ver o padrão
criador sendo executado pelo controlador.

Existe ainda um especialista que não está presente no diagrama mas é de extrema importância,
o ServiceManager. Segundo a
[documentação](http://framework.zend.com/manual/2.0/en/modules/zend.service-manager.quick-start.html)
ele é responsável por prover:

* Fábricas abastratas
* _Aliases_
* Fábricas
* _Invokables_
* Serviços
* Serviços Compartilhados

No controlador **DocumentController** ele tem como objetivo obter uma instância de
**TemplateTable** e **DocumentTemplateTable**, dois **Models** do sistema; obter um objeto
de **Sessão**, contendo os dados do usuário logado; e obter o **Adapter** do banco de dados,
responsável pela conexão, para que possamos criar uma transação na hora de criar o documento,
devido a necessidade de inserir dados em duas tabelas diferentes. Ex.:

~~~
/* ... */
$sm = $this->getServiceLocator();
$modelTemplates = $sm->get('Application\Model\TemplateTable');

if ($request->isPost()) {
    $session = $sm->get('Session');
    /* ... */
}
~~~