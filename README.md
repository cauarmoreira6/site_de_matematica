# MathPlay Solutions

Plataforma educacional gamificada para Matemática do Ensino Fundamental II, feita somente com HTML, CSS, JavaScript puro, PHP e MySQL.

## Como executar no Laragon

1. Abra o Laragon e inicie Apache e MySQL.
2. Acesse `http://localhost/phpmyadmin`.
3. Importe o arquivo `banco/mathplay.sql` ou copie seu conteúdo na aba SQL.
4. Confirme que o banco `mathplay` foi criado.
5. Abra `http://localhost/site_de_matematica/`.
6. Crie uma conta de aluno em `cadastro.php`.

A conexão padrão em `includes/conexao.php` usa MySQL em `localhost`, usuário `root` e senha vazia. Altere esses quatro valores se sua instalação usar outra configuração.

## Criar um professor/admin

Depois de criar uma conta normal, execute no phpMyAdmin, trocando o e-mail pelo cadastrado:

```sql
USE mathplay;
UPDATE usuarios SET tipo = 'admin' WHERE email = 'professor@exemplo.com';
```

Faça login novamente. O usuário será enviado para `admin/dashboard.php`, onde poderá consultar alunos e resultados.

## Fluxo da aplicação

`Cadastro -> Login -> Dashboard -> Jogo -> Resultado -> XP/Nível/Medalha -> Ranking`

As partidas são enviadas pelo JavaScript para `api/salvar_resultado.php`. O endpoint valida os dados, grava a partida, soma XP e registra conquistas sem duplicá-las.

## Regras de XP

- Cada acerto vale 10 pontos/XP.
- A partir de três acertos consecutivos há bônus de 5 pontos por resposta.
- Concluir uma partida vale 20 XP.
- Cada 100 XP avançam um nível.

## Jogos

- **Batalha dos Inteiros:** soma de números positivos e negativos.
- **Cofre das Equações:** equações de primeiro grau.
- **Loja MathPlay:** descontos e porcentagens.
- **Detetive dos Gráficos:** leitura de quantidades em colunas.

Cada jogo tem cinco desafios, três dificuldades e explicação didática quando a resposta está errada.
