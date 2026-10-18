<?php
class ControllerExtensionModuleInstallmentPlan extends Controller
{
    const EXT_MODULE = 'module_installment_plan';

    public function checkInstallment($product_info = array())
    {
        $plan_installment = '';

        if ($product_info['special']) {
            $price = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
        } else {
            $price = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
        }

        // VALIDAÇÃO PRECOCE - Preço deve ser maior que zero
        if ((float)$price <= 0) {
            return '';
        }

        // Validação de estoque
        $installment_product_out_of_stock = true;
        if (((int)$product_info['quantity'] <= 0 || (int)$product_info['quantity'] < (int)$product_info['minimum']) && !$this->config->get(self::EXT_MODULE . '_product_out_of_stock')) {
            $installment_product_out_of_stock = false;
        }

        if ($installment_product_out_of_stock) {
            $plan_installment = $this->getInstallment($price, (isset($product_info['product_page']) ? true : false));
        }

        return $plan_installment;
    }

    public function getInstallment($price, $product_page = false)
    {
        $this->load->language('extension/module/installment_plan');

        // Cache de configurações
        $config = [
            'installment_amount' => (float)$this->config->get(self::EXT_MODULE . '_installment_amount'),
            'total_installments' => (int)$this->config->get(self::EXT_MODULE . '_total_installments'),
            'interest_rate' => (float)$this->config->get(self::EXT_MODULE . '_interest_rate'),
            'total_interest_free' => (int)$this->config->get(self::EXT_MODULE . '_total_interest_free_installments')
        ];

        $show_total_amount = false;

        // Modo de exibição sem Simples nos cards dos produtos
        $show_mode = 'line';

        $text_mask = html_entity_decode($this->config->get(self::EXT_MODULE . '_notice_store_pages'));

        if ($product_page) {
            $text_mask = html_entity_decode($this->config->get(self::EXT_MODULE . '_notice_product_page'));

            // Modo de exibição para páginas de produtos
            $show_mode = $this->config->get(self::EXT_MODULE . '_show_mode');

            if ($this->config->get(self::EXT_MODULE . '_show_total_amount')) {
                $show_total_amount = true;
            }
        }

        //$data['total_installments'] = $this->config->get(self::EXT_MODULE . '_total_installments');

        $data['view_mode'] = $show_mode;

        $data['installments'] = array();

        // Calcular todas as parcelas válidas (≥ valor mínimo)
        $valid_installments = array();

        $best_installment = null;

        // Maior parcela SEM juros válida (usada nos modos simple/line)
        $best_interest_free_installment = null;

        for ($i = 1; $i <= $config['total_installments']; $i++) {
            // Calcular valor da parcela
            $is_interest_free = ($i <= $config['total_interest_free'] || $config['interest_rate'] == 0);

            if ($is_interest_free) {
                $installment_value = $price / $i;
                $installment_text_sufix = $this->language->get('text_interest_free');
            } else {
                // Fórmula PMT para juros compostos
                $monthly_rate = $config['interest_rate'] / 100;
                $installment_value = ($price * $monthly_rate * pow(1 + $monthly_rate, $i)) / (pow(1 + $monthly_rate, $i) - 1);
                $installment_text_sufix = $this->language->get('text_interest');
            }

            // Se a parcela é válida (≥ valor mínimo), adiciona à lista
            if ($installment_value >= $config['installment_amount']) {
                $text_installment_value = $this->currency->format($installment_value, $this->session->data['currency']);
                $total_amount = '';

                if ($show_total_amount) {
                    $total_amount = $this->currency->format(($installment_value * $i), $this->session->data['currency']);
                }

                $installment_data = array(
                    'text' => str_replace(array('[PARCELA]', '[PRECO]', '[TIPO_JUROS]'), array($i, $text_installment_value, $installment_text_sufix), $text_mask),
                    'installment' => $i,
                    'value' => $text_installment_value,
                    'interest_type' => $installment_text_sufix,
                    'total' => $total_amount
                );

                $valid_installments[] = $installment_data;

                // Guarda a maior parcela válida (com ou sem juros)
                $best_installment = $installment_data;

                // Guarda a maior parcela válida SEM juros (referência simple/line)
                if ($is_interest_free) {
                    $best_interest_free_installment = $installment_data;
                }
            }
        }

        // Se não há parcelas válidas, não mostra parcelamento
        if (empty($valid_installments)) {
            return '';
        }

        // Maior parcela SEM juros válida alimenta todos os resumos
        // (modos simple/line e a linha-resumo do grid); fallback para a maior
        // parcela válida caso nenhuma sem juros exista.
        $summary_installment = $best_interest_free_installment ? $best_interest_free_installment : $best_installment;

        // Definir quais parcelas mostrar baseado no modo
        if ($show_mode == 'modal' || $show_mode == 'grid') {
            // Modos Modal/Grid: mostra todas as parcelas válidas
            $data['installments'] = $valid_installments;
        } else {
            // Modos Simples/Line: mostra apenas a maior parcela SEM juros válida
            $data['installments'] = array($summary_installment);
        }

        $installment_end = $summary_installment['installment'];
        $installment_end_sufix = $summary_installment['interest_type'];
        $installment_end_value = $summary_installment['value'];

        $data['interest_text'] = '';

        if (($show_mode == 'modal' || $show_mode == 'grid') && $config['interest_rate']) {
            $data['interest_text'] = str_replace('[JUROS]', $config['interest_rate'], $this->language->get('text_interest_rate'));
        }

        $data['text_installment_line'] = '';

        if ($show_mode == 'modal' || $show_mode == 'grid') {
            $data['text_installment_line'] = str_replace(array('[PARCELA]', '[PRECO]', '[TIPO_JUROS]'), array($installment_end, $installment_end_value, $installment_end_sufix), $text_mask);
        }

        return $this->load->view('extension/module/installment_plan', $data);
    }

    public function updateInstallments()
    {

        $this->load->model('catalog/product');

        $json = array('status' => 'error', 'installments' => '');

        $product_id = (int)$this->request->post['product_id'];

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            $quantity = (int)$this->request->post['quantity'];

            // options price
            $options_price = 0;

            if (isset($this->request->post['option']) && $this->request->post['option']) {

                foreach ($this->model_catalog_product->getProductOptions($product_id) as $option) {

                    foreach ($option['product_option_value'] as $option_value) {
                        if (isset($this->request->post['option'][$option['product_option_id']]) && $this->request->post['option'][$option['product_option_id']] == $option_value['product_option_value_id']) {
                            if ($option_value['subtract'] || ($option_value['quantity'] > 0)) {
                                if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                                    $price = $this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                                } else {
                                    $price = false;
                                }

                                if ($price) {
                                    if ($option_value['price_prefix'] === '+') {
                                        $options_price += (float)$price;
                                    }

                                    if ($option_value['price_prefix'] === '-') {
                                        $options_price -= (float)$price;
                                    }
                                }
                            }
                        }
                    }
                    unset($price);
                }
            }

            $this->load->model('extension/module/installment_plan');
            $base_price = $this->model_extension_module_installment_plan->getProductDiscount($product_id, $quantity);

            if (!$base_price) {
                $base_price = $product_info['price'];
            }

            $price = $this->tax->calculate($base_price + $options_price, $product_info['tax_class_id'], $this->config->get('config_tax')) * $quantity;

            if ((float)$price > 0) {
                if ($this->config->get(self::EXT_MODULE . '_update_value')) {
                    $json['installments'] = $this->getInstallment($price, true);
                    $json['status'] = 'success';
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
