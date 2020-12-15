# Sistema Suporte

A idéia deste projeto foi criar um sistema para receber chamados de colaboradores e ter um controle de ocorrências e inventário de ativos de infra.
> O FrontEnd foi feito utilizando bootstrap 4 e php no BackEnd.
<br>

Nesta tela o usuário abre um chamado, é importante que utilize um e-mail válido pois o link para tratar o chamado será enviado por lá.
![new ticket](readme-data/newTicket.png)
> Rota: "/abrir-chamado"
<br>

Ao abrir um chamado, receber uma mensagem no chamado, ter o chamado fechado ou reaberto, o usuário irá receber um e-mail informando.
![email](readme-data/emailExample.png)
<br>

Tela de login para o administrador.
![login](readme-data/login.gif)
> Rota: "/login"
<br>

Ao acessar o sistema, a tela inicial permite que cada usuário crie anotações para se lembrar de tarefas futuras ou algo do tipo.
![notes](readme-data/notes.png)
![notes](readme-data/newNote.gif)
![notes](readme-data/noteEdit.gif)
> Rota: "/admin"
<br>

Na tela de inventário é possível registrar ativos de TI.
![inventory](readme-data/inventory.png)
![inventory](readme-data/addInventory.png)
![inventory](readme-data/inventoryEdit.gif)
> Rota: "/admin/inventario"
<br>

Todos os chamados ficam aqui, é possível reabrir ou fecha-los.
![ticket](readme-data/tickets.png)
> Rota: "/admin/chamados"
<br>

Nesta tela o chamado é tratado com o usuário em um chat. O administrador pode mandar quantas mensagens quiser.
![ticket](readme-data/adminTicket.png)
> Rota: "/admin/chamados/abrir" + token único
<br>

Esta é a tela do chamado do usuário, o link de acesso dela é enviado no seu e-mail. O usuário pode mandar uma mensagem de até 1500 caracteres por vez.
![ticket](readme-data/userTicket.png)
> Rota: "/chamado" + token único
<br>

Processo para fechar chamados.
![ticket](readme-data/closeTicket.gif)
<br>

Mesmo com o chamado concluido, o usuário ainda pode acessar o link para ver o histórico de mensagens.
![ticket](readme-data/userTicketClose.png)
<br>

Apenas administradores possuem acesso á esta tela, aqui é possível criar novos usuários para auxiliarem com os chamados.
![users](readme-data/users.png)
![users](readme-data/newUser.gif)
> Rota: "/admin/usuarios"
