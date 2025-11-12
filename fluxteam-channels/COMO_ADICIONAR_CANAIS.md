# Como Adicionar Novos Canais

Este guia explica como adicionar novos canais ao site Canais FluxTeam.

## Passo a Passo

### 1. Localize o arquivo de dados

Abra o arquivo `data/channels.json` no seu editor de código.

### 2. Adicione um novo canal

Copie o formato abaixo e adicione ao final da lista (antes do `]`):

```json
{
  "id": "nome-do-canal",
  "name": "Nome do Canal",
  "url": "https://www.youtube.com/@nome-do-canal",
  "channelId": "UCxxxxxxxxxxxxxxxxxx",
  "description": "Descrição do canal"
}
```

### 3. Preencha as informações

- **id**: Um identificador único (pode ser o nome do canal sem espaços)
- **name**: O nome do canal como aparece no YouTube
- **url**: O link completo do canal do YouTube
- **channelId**: O ID do canal (começa com UC...)
- **description**: Uma breve descrição do conteúdo do canal

### 4. Exemplo completo

```json
[
  {
    "id": "suadookyt",
    "name": "suadookyt",
    "url": "https://youtube.com/@suadookyt",
    "channelId": "UCsuadookyt",
    "description": "Canal de conteúdo criativo e entretenimento"
  },
  {
    "id": "novo-canal",
    "name": "Novo Canal Incrível",
    "url": "https://www.youtube.com/@novocanalincrivel",
    "channelId": "UCnovocanal123456789",
    "description": "Conteúdo sobre tecnologia e games"
  }
]
```

### 5. Como encontrar o Channel ID

1. Acesse o canal no YouTube
2. Clique em "Sobre"
3. Clique em "Compartilhar canal"
4. Copie o link - o ID está no final da URL após `/channel/`

Ou use a URL do canal diretamente se for no formato `@nome-do-canal`.

### 6. Salve e teste

Após adicionar o novo canal:

1. Salve o arquivo `channels.json`
2. Reinicie o servidor de desenvolvimento (se estiver rodando)
3. Atualize a página no navegador

O novo canal aparecerá automaticamente no grid!

## Dicas

- Mantenha as descrições curtas e objetivas (máximo 100 caracteres)
- Certifique-se de que a vírgula está correta entre os objetos
- Não esqueça de fechar as chaves `}` e colchetes `]`
- Use aspas duplas `"` para todas as strings

## Problemas Comuns

### O site não carrega após adicionar um canal

- Verifique se há vírgulas faltando ou sobrando
- Certifique-se de que todas as aspas estão fechadas
- Use um validador JSON online para verificar erros

### O canal não aparece

- Limpe o cache do navegador (Ctrl + Shift + R)
- Reinicie o servidor de desenvolvimento
- Verifique se o formato está correto

## Suporte

Se tiver dúvidas ou problemas, entre em contato com a equipe FluxTeam!
