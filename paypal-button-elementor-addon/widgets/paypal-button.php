<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Pbea_Elementor_PayPal_Button_Widget extends Widget_Base {

    public function get_name() {
        return 'paypal_button';
    }

    public function get_title() {
        return __('PayPal Button', 'paypal-button-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-paypal-button';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('PayPal Settings', 'paypal-button-elementor-addon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'paypal_email',
            [
                'label' => __('PayPal Email', 'paypal-button-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => 'you@example.com',
                'placeholder' => __('PayPal email address', 'paypal-button-elementor-addon'),
            ]
        );

        $this->add_control(
            'item_name',
            [
                'label' => __('Item Name', 'paypal-button-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your Item Name', 'paypal-button-elementor-addon'),
            ]
        );

        $this->add_control(
            'amount',
            [
                'label' => __('Amount (USD)', 'paypal-button-elementor-addon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10.00,
                'min' => 1,
                'step' => 0.01,
            ]
        );

        $this->add_control(
            'currency_code',
            [
                'label' => __('Currency Code', 'paypal-button-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => 'USD',
            ]
        );

        $this->add_control(
            'return_url',
            [
                'label' => __('Return URL', 'paypal-button-elementor-addon'),
                'type' => Controls_Manager::URL,
                'default' => ['url' => 'https://yourwebsite.com/success'],
            ]
        );

        $this->add_control(
            'cancel_url',
            [
                'label' => __('Cancel URL', 'paypal-button-elementor-addon'),
                'type' => Controls_Manager::URL,
                'default' => ['url' => 'https://yourwebsite.com/cancel'],
            ]
        );

        $this->add_control(
		    'button_icon',
		    [
		        'label' => esc_html__( 'Icon', 'paypal-button-elementor-addon' ),
		        'type' => \Elementor\Controls_Manager::ICONS,
		        'default' => [
		            'value' => 'fab fa-paypal',
		            'library' => 'fa-brands',
		        ],
		    ]
		);

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'paypal-button-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Pay Now with PayPal', 'paypal-button-elementor-addon'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $paypal_url = sprintf(
            'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=%s&item_name=%s&amount=%.2f&currency_code=%s&return=%s&cancel_return=%s',
            urlencode($settings['paypal_email']),
            urlencode($settings['item_name']),
            $settings['amount'],
            strtoupper($settings['currency_code']),
            urlencode($settings['return_url']['url']),
            urlencode($settings['cancel_url']['url'])
        );

        if ( ! empty( $settings['button_icon']['value'] ) ) {
	        $this->add_render_attribute( 'icon', 'class', $settings['button_icon']['value'] );
	        if ( ! empty( $settings['button_icon']['library'] ) ) {
	            $this->add_render_attribute( 'icon', 'class', 'elementor-button-icon' );
	        }
	    }

	    echo '<a href="' . esc_url( $paypal_url ) . '" target="_blank" class="pbea-btn">';

	    if ( ! empty( $settings['button_icon']['value'] ) ) {
	    	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor handles escaping internally
	        echo '<span ' . $this->get_render_attribute_string( 'icon' ) . '></span>';
	    }

	    echo esc_html( $settings['button_text'] );

	    echo '</a>';

    }
}
