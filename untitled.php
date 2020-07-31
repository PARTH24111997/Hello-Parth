<?php
class ModelTotalShipping extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
			if($this->session->data['shipping_method']['title']=="Levering door GLS"){
				$cost = str_replace(",",".",mb_substr($this->session->data['shipping_method']['text'],0,-1));
				$total_data[] = array( 
					'code'       => 'shipping',
	        		'title'      => $this->session->data['shipping_method']['title'],
	        		'text'       => $this->currency->format($cost+0.866033049),/*
					'text'       => $this->session->data['shipping_method']['text']
	        		$this->currency->format($this->session->data['shipping_method']['cost']),*/
	        		'value'      => $this->session->data['shipping_method']['cost'],
					'sort_order' => $this->config->get('shipping_sort_order')
				);
			}
			else{
				$total_data[] = array( 
					'code'       => 'shipping',
	        		'title'      => $this->session->data['shipping_method']['title'],
	        		'text'       => $this->session->data['shipping_method']['text'],/*
					'text'       => $this->session->data['shipping_method']['text']
	        		$this->currency->format($this->session->data['shipping_method']['cost']),*/
	        		'value'      => $this->session->data['shipping_method']['cost'],
					'sort_order' => $this->config->get('shipping_sort_order')
				);
			}

			if ($this->session->data['shipping_method']['tax_class_id']) {
				$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
				
				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}
			if($this->session->data['shipping_method']['title']=="Levering door GLS"){
				$total += $cost;
			}
			else{
				$total += $this->session->data['shipping_method']['cost'];
			}
		}			
	}
}
?>