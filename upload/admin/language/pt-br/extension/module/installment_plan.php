<?php
// Heading
$_['heading_title']                         = 'Plano de Parcelamento';

// Tab info
$_['tab_info_settings']                     = 'Configurações gerais do módulo <strong>Plano de Parcelamento</strong>.';
$_['tab_info_installment']                  = 'Configurações do plano de parcelamento que será exibido ao cliente da loja.';
$_['tab_info_message']                      = 'Configurações da mensagem do plano de parcelamento que sera exibido nas páginas do produtos e nos cards de produtos.';

// Text
$_['text_extension']                        = 'Extensões';
$_['text_success']                          = 'Sucesso: O módulo Plano de Parcelamento foi modificado com sucesso!';
$_['text_notice_store_pages_default']       = '[PARCELA]x de [PRECO] [TIPO_JUROS]';
$_['text_notice_product_page_default']      = '<i class="fa fa-credit-card"></i> <strong>[PARCELA]x de [PRECO]</strong> [TIPO_JUROS]';
$_['text_edit']                             = 'Configurando o módulo Plano de Parcelamento';
$_['text_mode_line']                        = 'Simples';
$_['text_mode_list']                        = 'Modal';
$_['text_mode_grid']                        = 'Grid (Accordion)';

// Abas
$_['tab_settings']                          = 'Configurações';
$_['tab_installment']                       = 'Parcelamento';
$_['tab_message']                           = 'Mensagem';
$_['tab_about']                             = 'Sobre';

// Entry
$_['entry_help_default']                    = '<small>Os termos <strong>[PARCELA]</strong>, <strong>[PRECO]</strong> e <strong>[TIPO_JUROS]</strong> são obrigatórios para o perfeito funcionamento.</small>';
$_['entry_installment_amount']              = 'Valor da parcela';
$_['entry_interest_rate']                   = 'Taxa de juros (%)';
$_['entry_total_installments']              = 'Total de parcelas';
$_['entry_total_interest_free_installments'] = 'Total de parcelas sem juros';
$_['entry_notice_store_pages']              = 'Parcelamento nas páginas da loja';
$_['entry_show_store_pages']                = 'Exibir Parcelamento nas páginas da loja';
$_['entry_notice_product_page']             = 'Parcelamento na página do produto';
$_['entry_show_product_page']               = 'Exibir Parcelamento na página do produto';
$_['entry_update_value']                    = 'Atualizar preço';
$_['entry_show_mode']                       = 'Modo de exibição';
$_['entry_show_total_amount']               = 'Mostrar valor total';
$_['entry_product_out_of_stock']            = 'Produto sem estoque';
$_['entry_status']                          = 'Situação';

// Help
$_['help_installment_amount']               = 'Informe o valor por parcela. Ex: 5.00';
$_['help_interest_rate']                    = 'Informe a porcentagem de juros aplicada sob as parcelas. Ex.: 1 (para 1% de juros) ou deixe 0 para não aplicar juros.';
$_['help_total_installments']               = 'Informe o total de parcelas que o valor do produto/pedido poderá ser parcelado.';
$_['help_total_interest_free_installments'] = 'Informe o total de parcelas sem juros que o valor do produto/pedido poderá ter.';
$_['help_notice_store_pages']               = 'Esquema padrão do aviso de parcelamento do produto/pedido nas demais áreas da loja.';
$_['help_notice_product_page']              = 'Esquema padrão do aviso de parcelamento do produto/pedido na página do produto.';
$_['help_show_mode']                        = 'Modo de exibição do parcelamento do produto. Simples: mostra apenas a maior parcela. Modal: mostra todas as parcelas em janela popup. Grid: mostra parcelas em accordion expansível. Aplicável somente para página do produto.';
$_['help_update_value']                     = 'Atualiza o valor das parcelas ao selecionar opções do produto ou quando alterar a quantidade de itens.';
$_['help_show_total_amount']                = 'Mostra o valor total do parcelamento. Funciona nos modos simples e modal.';
$_['help_product_out_of_stock']             = 'Exibe o parcelamento em produtos sem estoque.';

// Error
$_['error_warning']                         = 'Atenção: O módulo não foi configurado corretamente! Verifique todos os campos para corrigir os erros.';
$_['error_installment_amount']              = 'Defina um valor por parcela do parcelamento.';
$_['error_total_installments']              = 'Informe a quantidade total de parcelas.';
$_['error_permission']                      = 'Atenção: Você não possui permissão para modificar o módulo Plano de Parcelamento!';

// Aba Sobre
$_['about_module_title']                    = 'Sobre o Módulo';
$_['about_description_title']               = 'Descrição';
$_['about_description_text']                = 'O módulo <strong>Plano de Parcelamento</strong> é uma solução completa para exibir opções de parcelamento em sua loja OpenCart. Permite calcular e mostrar parcelas com ou sem juros em diferentes áreas da loja, oferecendo transparência aos clientes sobre as opções de pagamento disponíveis.';

$_['about_features_title']                  = 'Principais Recursos';
$_['about_feature_1']                       = 'Cálculo automático de parcelas com juros compostos (fórmula PMT)';
$_['about_feature_2']                       = 'Configuração de valor mínimo por parcela';
$_['about_feature_3']                       = 'Definição de parcelas sem juros';
$_['about_feature_4']                       = 'Exibição em páginas de produto, categorias, busca e módulos';
$_['about_feature_5']                       = 'Compatibilidade com tema padrão';
$_['about_feature_6']                       = 'Atualização dinâmica via AJAX ao alterar opções do produto';

$_['about_modes_title']                     = 'Modos de Exibição';
$_['about_mode_simple']                     = 'Modo Simples';
$_['about_mode_simple_desc']                = 'Mostra apenas a maior parcela possível inline na página.';
$_['about_mode_modal']                      = 'Modo Modal';
$_['about_mode_modal_desc']                 = 'Botão que abre popup com todas as parcelas em tabela detalhada.';
$_['about_mode_grid']                       = 'Modo Grid (Accordion)';
$_['about_mode_grid_desc']                  = 'Botão que abre accordion com todas as parcelas em tabela detalhada.';

$_['about_calculation_title']               = 'Cálculos';
$_['about_calculation_desc']                = 'O módulo utiliza a fórmula PMT (Payment) padrão do mercado financeiro para cálculos de parcelas com juros compostos, garantindo precisão nos valores apresentados.';

$_['about_important_title']                 = 'Importante';
$_['about_important_desc']                  = 'Este módulo calcula apenas a <strong>simulação</strong> de parcelamento para exibição. A forma de pagamento real deve ser configurada através dos métodos de pagamento apropriados no OpenCart.';

$_['about_developer_title']                 = 'Desenvolvedor';
$_['about_developer_desc']                  = 'Módulo desenvolvido pela AnderWWeb HS, especializada em soluções para OpenCart.';
$_['about_visit_website']                   = 'Visitar Site';

$_['about_support_title']                   = 'Suporte';
$_['about_support_desc']                    = 'Precisa de ajuda ou encontrou algum problema? Entre em contato conosco!';
$_['about_contact_support']                 = 'Contatar Suporte';

$_['about_version_title']                   = 'Informações Técnicas';
$_['about_version_label']                   = 'Versão';
$_['about_opencart_label']                  = 'OpenCart';
$_['about_php_label']                       = 'PHP';
