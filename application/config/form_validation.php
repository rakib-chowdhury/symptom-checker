<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array (
    'crm_add_form' => array (
        array(
            'field' => 'n_ordine',
            'label' => 'No. Ordine',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'margine',
            'label' => 'Margine',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'price_list',
            'label' => 'Price List',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'chrono24',
            'label' => '% Chrono24',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'prezzo_vendita',
            'label' => 'Prezzo Vendita',
            'rules' => 'greater_than['.floatval($this->input->post('acquisto_forn')).']',
            'errors' => array(
                'greater_than' => 'Prezzo Vendita must be greater than Acquisto Forn',
            ),
        ),
        array(
            'field' => 'ricavo_al_netto_comm_chrono24',
            'label' => 'Ricavo al netto comm chrono24',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'guadagno',
            'label' => 'Guadagno',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'acconto',
            'label' => 'Acconto',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'saldo',
            'label' => 'Saldo',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'valid_email'
        ),
		array(
			'field' => 'fornitore',
			'label' => 'Fornitore',
			'rules' => 'trim|required'
		),
		array(
            'field' => 'ordinato_il',
            'label' => 'Ordinato Il',
            'rules' => 'trim|required'
        )
    ),
    'crm_edit_form' => array (
        array(
            'field' => 'margine',
            'label' => 'Margine',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'price_list',
            'label' => 'Price List',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'chrono24',
            'label' => '% Chrono24',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'prezzo_vendita',
            'label' => 'Prezzo Vendita',
            'rules' => 'greater_than['.floatval($this->input->post('acquisto_forn')).']',
            'errors' => array(
                'greater_than' => 'Prezzo Vendita must be greater than Acquisto Forn',
            ),
        ),
        array(
            'field' => 'ricavo_al_netto_comm_chrono24',
            'label' => 'Ricavo al netto comm chrono24',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'guadagno',
            'label' => 'Guadagno',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'acconto',
            'label' => 'Acconto',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'saldo',
            'label' => 'Saldo',
            'rules' => 'greater_than[0]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'valid_email'
        ),
		array(
			'field' => 'fornitore',
			'label' => 'Fornitore',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'ordinato_il',
			'label' => 'Ordinato Il',
			'rules' => 'trim|required'
		)
    ),
    'user_add_form' => array (
        array(
            'field' => 'user_name',
            'label' => 'User Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'phone_number',
            'label' => 'Phone Number',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'valid_email'
        )
    ),
    'user_edit_form' => array (
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'phone_number',
            'label' => 'Phone Number',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'valid_email'
        )
    )
);
