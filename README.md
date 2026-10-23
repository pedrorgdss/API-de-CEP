# Localiza — Consulta de CEP

Aplicação web desenvolvida para a disciplina de Programação Web II. O usuário informa um CEP e recebe o endereço completo, consultado em tempo real pelo **PHP na API pública ViaCEP**.

## Tecnologias

- PHP 8.0 ou superior: requisição HTTP GET e interpretação do JSON com `json_decode`.
- HTML5 e CSS3: página responsiva, formulário e apresentação do endereço.
- JavaScript: máscara do CEP, consulta assíncrona ao PHP com `fetch` e atualização da página sem recarregar.
- [ViaCEP](https://viacep.com.br/): API pública sem necessidade de chave.

## Como executar

É necessário ter PHP 8+ com cURL habilitado (recomendado), ou `allow_url_fopen` habilitado para a alternativa com `file_get_contents`. O servidor precisa de acesso HTTPS à internet e certificados CA configurados. Não desative a validação de certificados.

No terminal, dentro desta pasta:

```powershell
cd "C:\Users\Usuário\Desktop\ETEC\PW2\Site API"
php -S localhost:8000
```

Acesse **http://localhost:8000**. Se `php` não estiver no PATH, use o caminho completo do executável. Com XAMPP, por exemplo:

```powershell
C:\xampp\php\php.exe -S localhost:8000
```

Outra opção é copiar a pasta para o `htdocs` do XAMPP, iniciar o Apache e acessar `http://localhost/Site%20API/`. Abrir o arquivo diretamente pelo explorador não executa o PHP.

## Funcionamento

1. O usuário informa um CEP com 8 dígitos, com ou sem hífen.
2. O navegador chama `GET api/cep.php?cep=01001000`.
3. O PHP valida a entrada e realiza `GET https://viacep.com.br/ws/01001000/json/`.
4. O PHP interpreta o JSON, trata erros e retorna os campos necessários.
5. O JavaScript apresenta CEP, logradouro, bairro, cidade, estado e complemento. Campos vazios aparecem como “Não informado”.

O endereço da API é fixo e o CEP é validado no servidor. Os resultados são inseridos com `textContent`, sem interpretar HTML. Há limites de tempo para a requisição e mensagens de carregamento, CEP inexistente, entrada inválida e serviço indisponível. Nenhum dado é persistido.

## Estrutura

```text
Site API/
├── index.php          # Página inicial
├── api/cep.php        # Consulta HTTP e tratamento do JSON no PHP
├── assets/app.js      # Interação e atualização dinâmica
├── assets/style.css   # Estilos responsivos
├── README.md
└── .gitignore
```

## Verificação manual

Com o servidor ligado:

| Ação | Resultado esperado |
| --- | --- |
| Consultar `01001000` | Praça da Sé, Sé, São Paulo, SP, CEP 01001-000 |
| Consultar `01001-000` | Mesmo resultado |
| Clicar em um exemplo | Consultar automaticamente o CEP escolhido |
| Consultar `99999999` | Mensagem de CEP não encontrado |
| Enviar campo vazio ou incompleto | Validação do formulário |
| Abrir `/api/cep.php?cep=abc` | HTTP 400 e erro em JSON |
| Abrir `/api/cep.php?cep[]=01001000` | HTTP 400, sem erro interno |
| Enviar POST para `/api/cep.php` | HTTP 405 |
| Consultar sem acesso à API | Mensagem de indisponibilidade |
| Usar em celular ou apenas teclado | Layout adaptado e controles acessíveis |

Para verificar a sintaxe do backend:

```powershell
php -l index.php
php -l api/cep.php
```

## Publicação no GitHub

Crie um repositório na sua conta, sem inicializar outro README. Com Git instalado, execute nesta pasta, substituindo a URL pela do seu repositório:

```powershell
git init
git add .
git commit -m "Adiciona aplicação Localiza com consulta ViaCEP em PHP"
git branch -M main
git remote add origin https://github.com/SEU-USUARIO/localiza-cep.git
git push -u origin main
```

Também é possível enviar os arquivos pela opção **Add file → Upload files** no GitHub, preservando as pastas. O GitHub armazena o código; **GitHub Pages não executa PHP**. Para disponibilizar o sistema online, use uma hospedagem com PHP 8+, HTTPS e acesso externo ao ViaCEP.

## Roteiro do vídeo (2 a 3 minutos)

1. Apresente o nome Localiza e o objetivo da aplicação.
2. Mostre o site rodando em `localhost` ou em uma hospedagem PHP.
3. Consulte `01001000` e explique os campos do endereço retornado.
4. Mostre um CEP inexistente (`99999999`) e a validação de entrada incompleta.
5. Mostre `api/cep.php`, destacando a requisição GET e o `json_decode`.
6. Mostre o repositório e este README.
7. Grave a tela, envie o vídeo ao YouTube e copie o link. Se permitido pela atividade, selecione visibilidade “Não listado”.

## Links para entrega

Preencha após publicar nas suas contas:

- Repositório GitHub: **a preencher**
- Vídeo no YouTube: **a preencher**

## Créditos

Dados de endereço: [ViaCEP](https://viacep.com.br/). Fontes DM Sans e Manrope via Google Fonts, com fontes locais alternativas quando não houver conexão. Projeto acadêmico sem vínculo oficial com o ViaCEP.
