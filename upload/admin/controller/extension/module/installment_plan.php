<?php
class ControllerExtensionModuleInstallmentPlan extends Controller
{
    const EXT_MODULE = 'module_installment_plan';
    private $version = 'v1.0';
    private $error = array();

    public function index()
    {
        $this->load->language('extension/module/installment_plan');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            if (strstr($this->request->post[self::EXT_MODULE . '_installment_amount'], ',')) {
                $this->request->post[self::EXT_MODULE . '_installment_amount'] = str_replace(',', '.', $this->request->post[self::EXT_MODULE . '_installment_amount']);
            }

            if (strstr($this->request->post[self::EXT_MODULE . '_interest_rate'], ',')) {
                $this->request->post[self::EXT_MODULE . '_interest_rate'] = str_replace(',', '.', $this->request->post[self::EXT_MODULE . '_interest_rate']);
            }

            $this->model_setting_setting->editSetting(self::EXT_MODULE, $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        // Mensagens de erros
        $notice_errors = array(
            'warning',
            'installment_amount',
            'interest_rate',
            'total_installments',
            'total_interest_free_installments'
        );

        foreach ($notice_errors as $notice_error) {
            if (isset($this->error[$notice_error])) {
                $data['error_' . $notice_error] = $this->error[$notice_error];
            } else {
                $data['error_' . $notice_error] = '';
            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/installment_plan', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/installment_plan', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['user_token'] = $this->session->data['user_token'];
        $data['version'] = $this->version;

        // Valor da parcela
        if (isset($this->request->post[self::EXT_MODULE . '_installment_amount'])) {
            $data[self::EXT_MODULE . '_installment_amount'] = $this->request->post[self::EXT_MODULE . '_installment_amount'];
        } else {
            $data[self::EXT_MODULE . '_installment_amount'] = $this->config->get(self::EXT_MODULE . '_installment_amount');
        }

        // Taxa de juros
        if (isset($this->request->post[self::EXT_MODULE . '_interest_rate'])) {
            $data[self::EXT_MODULE . '_interest_rate'] = $this->request->post[self::EXT_MODULE . '_interest_rate'];
        } else {
            $data[self::EXT_MODULE . '_interest_rate'] = $this->config->get(self::EXT_MODULE . '_interest_rate');
        }

        // Total de parcelas
        if (isset($this->request->post[self::EXT_MODULE . '_total_installments'])) {
            $data[self::EXT_MODULE . '_total_installments'] = $this->request->post[self::EXT_MODULE . '_total_installments'];
        } else {
            $data[self::EXT_MODULE . '_total_installments'] = $this->config->get(self::EXT_MODULE . '_total_installments');
        }

        // Total de parcelas sem juros
        if (isset($this->request->post[self::EXT_MODULE . '_total_interest_free_installments'])) {
            $data[self::EXT_MODULE . '_total_interest_free_installments'] = $this->request->post[self::EXT_MODULE . '_total_interest_free_installments'];
        } else {
            $data[self::EXT_MODULE . '_total_interest_free_installments'] = $this->config->get(self::EXT_MODULE . '_total_interest_free_installments');
        }

        // Aviso do parcelamento na loja
        if (isset($this->request->post[self::EXT_MODULE . '_notice_store_pages'])) {
            $data[self::EXT_MODULE . '_notice_store_pages'] = $this->request->post[self::EXT_MODULE . '_notice_store_pages'];
        } elseif ($this->config->get(self::EXT_MODULE . '_notice_store_pages')) {
            $data[self::EXT_MODULE . '_notice_store_pages'] = $this->config->get(self::EXT_MODULE . '_notice_store_pages');
        } else {
            $data[self::EXT_MODULE . '_notice_store_pages'] = $this->language->get('text_notice_store_pages_default');
        }

        // Exibir parcelamento na loja
        if (isset($this->request->post[self::EXT_MODULE . '_show_store_pages'])) {
            $data[self::EXT_MODULE . '_show_store_pages'] = $this->request->post[self::EXT_MODULE . '_show_store_pages'];
        } else {
            $data[self::EXT_MODULE . '_show_store_pages'] = $this->config->get(self::EXT_MODULE . '_show_store_pages');
        }

        // Aviso do parcelamento na página do produto
        if (isset($this->request->post[self::EXT_MODULE . '_notice_product_page'])) {
            $data[self::EXT_MODULE . '_notice_product_page'] = $this->request->post[self::EXT_MODULE . '_notice_product_page'];
        } elseif ($this->config->get(self::EXT_MODULE . '_notice_product_page')) {
            $data[self::EXT_MODULE . '_notice_product_page'] = $this->config->get(self::EXT_MODULE . '_notice_product_page');
        } else {
            $data[self::EXT_MODULE . '_notice_product_page'] = $this->language->get('text_notice_product_page_default');
        }

        // Exibir parcelamento na página do produto
        if (isset($this->request->post[self::EXT_MODULE . '_show_product_page'])) {
            $data[self::EXT_MODULE . '_show_product_page'] = $this->request->post[self::EXT_MODULE . '_show_product_page'];
        } else {
            $data[self::EXT_MODULE . '_show_product_page'] = $this->config->get(self::EXT_MODULE . '_show_product_page');
        }

        // Modo de exibição do parcelamento
        if (isset($this->request->post[self::EXT_MODULE . '_show_mode'])) {
            $data[self::EXT_MODULE . '_show_mode'] = $this->request->post[self::EXT_MODULE . '_show_mode'];
        } elseif ($this->config->get(self::EXT_MODULE . '_show_mode')) {
            $data[self::EXT_MODULE . '_show_mode'] = $this->config->get(self::EXT_MODULE . '_show_mode');
        } else {
            $data[self::EXT_MODULE . '_show_mode'] = 'simple';
        }

        // Atualiza o valor das parcelas
        if (isset($this->request->post[self::EXT_MODULE . '_update_value'])) {
            $data[self::EXT_MODULE . '_update_value'] = $this->request->post[self::EXT_MODULE . '_update_value'];
        } else {
            $data[self::EXT_MODULE . '_update_value'] = $this->config->get(self::EXT_MODULE . '_update_value');
        }

        // Mostrar valor total
        if (isset($this->request->post[self::EXT_MODULE . '_show_total_amount'])) {
            $data[self::EXT_MODULE . '_show_total_amount'] = $this->request->post[self::EXT_MODULE . '_show_total_amount'];
        } else {
            $data[self::EXT_MODULE . '_show_total_amount'] = $this->config->get(self::EXT_MODULE . '_show_total_amount');
        }

        // Exibir parcelamento em produto sem estoque
        if (isset($this->request->post[self::EXT_MODULE . '_product_out_of_stock'])) {
            $data[self::EXT_MODULE . '_product_out_of_stock'] = $this->request->post[self::EXT_MODULE . '_product_out_of_stock'];
        } else {
            $data[self::EXT_MODULE . '_product_out_of_stock'] = $this->config->get(self::EXT_MODULE . '_product_out_of_stock');
        }

        // Situação do módulo
        if (isset($this->request->post[self::EXT_MODULE . '_status'])) {
            $data[self::EXT_MODULE . '_status'] = $this->request->post[self::EXT_MODULE . '_status'];
        } else {
            $data[self::EXT_MODULE . '_status'] = $this->config->get(self::EXT_MODULE . '_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/installment_plan', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/installment_plan')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $notice_errors = array(
            'installment_amount',
            'interest_rate',
            'total_interest_free_installments',
            'total_installments'
        );

        foreach ($notice_errors as $notice_error) {
            if (empty($this->request->post[self::EXT_MODULE . '_' . $notice_error])) {
                $this->error[$notice_error] = $this->language->get('error_' . $notice_error);
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }
}
