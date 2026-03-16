<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_Responsive_Table_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'responsive_table';
	}

	public function get_title() {
		return esc_html__( 'Responsive Table', 'elementor-responsive-tables' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'table', 'data', 'responsive', 'grid' ];
	}

	public function get_style_depends() {
		return [ 'elementor-responsive-table' ];
	}

	protected function register_controls() {

		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Table Data', 'elementor-responsive-tables' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'is_header',
			[
				'label' => esc_html__( 'Is Header Row?', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-responsive-tables' ),
				'label_off' => esc_html__( 'No', 'elementor-responsive-tables' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater->add_control(
			'row_content',
			[
				'label' => esc_html__( 'Row Content', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Cell 1 | Cell 2 | Cell 3', 'elementor-responsive-tables' ),
				'description' => esc_html__( 'Enter table cells separated by the pipe (|) character. It is recommended to keep them on a single line.', 'elementor-responsive-tables' ),
			]
		);

		$this->add_control(
			'table_rows',
			[
				'label' => esc_html__( 'Rows', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'is_header' => 'yes',
						'row_content' => esc_html__( 'Category | Item | Price', 'elementor-responsive-tables' ),
					],
					[
						'is_header' => '',
						'row_content' => esc_html__( 'Electronics | Laptop | $999', 'elementor-responsive-tables' ),
					],
					[
						'is_header' => '',
						'row_content' => esc_html__( 'Furniture | Desk | $199', 'elementor-responsive-tables' ),
					],
				],
				'title_field' => '{{{ row_content }}}',
			]
		);

		$this->end_controls_section();

		// Responsive Settings
		$this->start_controls_section(
			'responsive_section',
			[
				'label' => esc_html__( 'Responsive Settings', 'elementor-responsive-tables' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'responsive_mode',
			[
				'label' => esc_html__( 'Mobile Behavior', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'scroll',
				'options' => [
					'scroll' => esc_html__( 'Scrollable (Horizontal)', 'elementor-responsive-tables' ),
					'stack'  => esc_html__( 'Stacked (Vertical)', 'elementor-responsive-tables' ), // Advanced stacking needs css mapping
				],
				'prefix_class' => 'ert-mobile-',
			]
		);

		$this->end_controls_section();


		// ----------------------------------------------------------------------
		// Style Tab: Table Wrapper
		// ----------------------------------------------------------------------
		$this->start_controls_section(
			'style_table_section',
			[
				'label' => esc_html__( 'Table Wrapper', 'elementor-responsive-tables' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_width',
			[
				'label' => esc_html__( 'Table Width', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 1200 ],
					'%' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .ert-table' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'table_border',
				'label' => esc_html__( 'Border', 'elementor-responsive-tables' ),
				'selector' => '{{WRAPPER}} .ert-table-wrapper',
			]
		);

		$this->add_responsive_control(
			'table_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ert-table-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'elementor-responsive-tables' ),
				'selector' => '{{WRAPPER}} .ert-table-wrapper',
			]
		);

		$this->end_controls_section();

		// ----------------------------------------------------------------------
		// Style Tab: Header
		// ----------------------------------------------------------------------
		$this->start_controls_section(
			'style_header_section',
			[
				'label' => esc_html__( 'Header Row', 'elementor-responsive-tables' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ert-table thead th, {{WRAPPER}} .ert-table tr.ert-is-header th, {{WRAPPER}} .ert-table tr.ert-is-header td' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'header_text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ert-table thead th, {{WRAPPER}} .ert-table tr.ert-is-header th, {{WRAPPER}} .ert-table tr.ert-is-header td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'header_typography',
				'label' => esc_html__( 'Typography', 'elementor-responsive-tables' ),
				'selector' => '{{WRAPPER}} .ert-table thead th, {{WRAPPER}} .ert-table tr.ert-is-header th, {{WRAPPER}} .ert-table tr.ert-is-header td',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label' => esc_html__( 'Padding', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ert-table thead th, {{WRAPPER}} .ert-table tr.ert-is-header th, {{WRAPPER}} .ert-table tr.ert-is-header td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_text_align',
			[
				'label' => esc_html__( 'Horizontal Alignment', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-responsive-tables' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-responsive-tables' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-responsive-tables' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'elementor-responsive-tables' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ert-table thead th, {{WRAPPER}} .ert-table tr.ert-is-header th, {{WRAPPER}} .ert-table tr.ert-is-header td' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_vertical_align',
			[
				'label' => esc_html__( 'Vertical Alignment', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'elementor-responsive-tables' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'elementor-responsive-tables' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'elementor-responsive-tables' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ert-table thead th, {{WRAPPER}} .ert-table tr.ert-is-header th, {{WRAPPER}} .ert-table tr.ert-is-header td' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'header_border_settings',
				'label' => esc_html__( 'Border', 'elementor-responsive-tables' ),
				'selector' => '{{WRAPPER}} .ert-table thead th, {{WRAPPER}} .ert-table tr.ert-is-header th, {{WRAPPER}} .ert-table tr.ert-is-header td',
			]
		);

		$this->end_controls_section();


		// ----------------------------------------------------------------------
		// Style Tab: Body Rows
		// ----------------------------------------------------------------------
		$this->start_controls_section(
			'style_body_section',
			[
				'label' => esc_html__( 'Body Rows', 'elementor-responsive-tables' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'body_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ert-table tbody td:not(.ert-is-header td)' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'body_striped_color',
			[
				'label' => esc_html__( 'Striped Row Color', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ert-table tbody tr:nth-child(even):not(.ert-is-header) td' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'body_text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ert-table tbody td:not(.ert-is-header td)' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'body_typography',
				'label' => esc_html__( 'Typography', 'elementor-responsive-tables' ),
				'selector' => '{{WRAPPER}} .ert-table tbody td:not(.ert-is-header td)',
			]
		);

		$this->add_responsive_control(
			'body_padding',
			[
				'label' => esc_html__( 'Padding', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ert-table tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'body_text_align',
			[
				'label' => esc_html__( 'Horizontal Alignment', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-responsive-tables' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-responsive-tables' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-responsive-tables' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'elementor-responsive-tables' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ert-table tbody td' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'body_vertical_align',
			[
				'label' => esc_html__( 'Vertical Alignment', 'elementor-responsive-tables' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'elementor-responsive-tables' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'elementor-responsive-tables' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'elementor-responsive-tables' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ert-table tbody td' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'body_border_settings',
				'label' => esc_html__( 'Border', 'elementor-responsive-tables' ),
				'selector' => '{{WRAPPER}} .ert-table tbody td',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['table_rows'] ) ) {
			return;
		}

		echo '<div class="ert-table-wrapper">';
		echo '<table class="ert-table">';
		
		$is_first_row = true;
		$in_thead = false;
		$in_tbody = false;
		$header_labels = [];

		foreach ( $settings['table_rows'] as $index => $item ) {
			
			$is_header = ( 'yes' === $item['is_header'] );
			
			// Parse text editor to support shortcodes and formatting
			$content = $this->parse_text_editor( $item['row_content'] );
			$content = trim( $content );
			
			// Elementor WYSIWYG/parse_text_editor might wrap the whole string in <p>...</p>
			// We remove the outermost <p> tags so splitting by | doesn't corrupt HTML structure
			if ( str_starts_with( $content, '<p>' ) && str_ends_with( $content, '</p>' ) ) {
				$content = substr( $content, 3, -4 );
			}

			// Clean up non-breaking spaces around pipes
			$content = str_replace( '&nbsp;', ' ', $content );
			
			$cells = explode( '|', $content );
			
			// Collect headers if first row is header
			if ( $is_first_row && $is_header ) {
				foreach ( $cells as $cell_content ) {
					$header_labels[] = wp_strip_all_tags( trim( $cell_content ) );
				}
			}

			// Auto thead logic: If the first row is a header, wrap it in thead
			if ( $is_first_row && $is_header ) {
				echo '<thead>';
				$in_thead = true;
			} elseif ( $is_first_row && ! $is_header ) {
				echo '<tbody>';
				$in_tbody = true;
			}

			// Transition from thead to tbody
			if ( ! $is_first_row && ! $is_header && $in_thead ) {
				echo '</thead><tbody>';
				$in_thead = false;
				$in_tbody = true;
			}

			$tr_class = $is_header ? 'ert-is-header' : 'ert-is-body-row';
			$tr_class .= ' elementor-repeater-item-' . esc_attr( $item['_id'] );

			echo '<tr class="' . esc_attr( $tr_class ) . '">';
			
			foreach ( $cells as $cell_index => $cell_content ) {
				$cell_tag = $is_header ? 'th' : 'td';
				$data_label = '';
				
				if ( ! $is_header && isset( $header_labels[ $cell_index ] ) ) {
					$data_label = ' data-label="' . esc_attr( $header_labels[ $cell_index ] ) . '"';
				}

				echo '<' . esc_attr( $cell_tag ) . $data_label . '>';
				// Allowed HTML for simple formatting within cells
				echo wp_kses_post( trim( $cell_content ) );
				echo '</' . esc_attr( $cell_tag ) . '>';
			}

			echo '</tr>';

			$is_first_row = false;
		}

		if ( $in_thead ) {
			echo '</thead>';
		}
		if ( $in_tbody ) {
			echo '</tbody>';
		}
		
		echo '</table>';
		echo '</div>'; // End ert-table-wrapper
	}
}
