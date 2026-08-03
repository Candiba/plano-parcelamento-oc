# Módulo Plano de Parcelamento para OpenCart 3.x

Módulo de exibição e cálculo de plano de parcelamento para lojas virtuais utilizando **OpenCart 3.x**. Exibe as opções de parcelamento (com ou sem juros) na página do produto, listagens de categorias, destaques, promoções e demais páginas da loja.

---

## 🚀 Funcionalidades

- **Cálculo Automático de Parcelas**: Exibe o parcelamento calculado com base no valor do produto.
- **Configuração de Parcelas sem Juros**: Permite definir até quantas parcelas a compra pode ser parcelada sem acréscimo.
- **Taxa de Juros Configurável**: Suporte a cálculo de juros simples/compostos para parcelas adicionais.
- **Valor Mínimo da Parcela**: Define um valor mínimo necessário para habilitar o parcelamento.
- **Integração Ampla na Loja**:
  - Página de detalhes do produto.
  - Listagens de categorias, busca e fabricantes.
  - Módulos de destaque, mais vendidos, lançamentos e promoções.
- **Layout Responsivo e Customizável**: Acompanha arquivo CSS dedicado (`installment_plan.css`) para personalização do estilo visual.

---

## 📋 Requisitos

- **OpenCart**: 3.0.0.0 ou superior (versões 3.x)
- **PHP**: 7.3 ou superior (compatível com PHP 8.x)

---

## 🛠️ Instalação

1. Baixe a versão mais recente da extensão ou utilize o arquivo predefinido `installment_plan.ocmod.zip`.
2. Acesse o painel administrativo da sua loja OpenCart.
3. Vá em **Extensões** > **Instalador** (`Extension > Installer`).
4. Clique em **Upload** e selecione o arquivo `installment_plan.ocmod.zip`.
5. Após concluir o upload, vá em **Extensões** > **Modificações** (`Extension > Modifications`) e clique no botão **Atualizar** (ícone azul no canto superior direito) para renovar o cache do OCMod.
6. Vá para **Extensões** > **Extensões** (`Extension > Extensions`), selecione o tipo **Módulos** (`Modules`).
7. Localize **Plano de Parcelamento**, clique no botão **Instalar** (ícone verde) e em seguida em **Editar** (ícone azul) para configurar as regras de parcelamento e ativar o módulo.

---

## ⚙️ Configuração

No painel de administração da extensão, configure os seguintes campos:

- **Status**: Ativar/Desativar o módulo.
- **Valor Mínimo da Parcela**: Menor valor permitido por parcela (ex: `5.00`).
- **Quantidade Máxima de Parcelas**: Número máximo de parcelas exibidas (ex: `12`).
- **Parcelas sem Juros**: Quantidade de parcelas que não terão acréscimo (ex: `6`).
- **Taxa de Juros (%)**: Porcentagem de juros aplicada nas parcelas excedentes.
- **Exibir na Página do Produto**: Habilita a simulação completa de parcelamento na página do produto.
- **Exibir nas Listagens/Vitrines**: Habilita a mensagem de resumo da melhor parcela nas vitrines e categorias.

---

## 📄 Licença

Este projeto está licenciado sob a licença **MIT** - consulte o arquivo [LICENSE](LICENSE) para mais detalhes.

---

Desenvolvido por [AnderWeb HS](http://anderweb.com.br).
