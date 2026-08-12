<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Booked_Calender extends Widget_Base {

    public function get_name() {
        return 'htmega-bookedcalender-addons';
    }
    
    public function get_title() {
        return __( 'Booked Calendar', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-table';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return [ 'booked ', 'booked calendar', 'calendar','htmega','htmega' ];
    }

    public function get_help_url() {
		return 'https://wphtmega.com/docs/general-widgets/booked-calendar-widget/';
	}
    
    protected function register_controls() {
        if ( ! is_plugin_active('booked/booked.php') ) {
            $this->messing_parent_plg_notice();
        } else {
            $this->booked_calender_regster_fields();
        }
    }
    protected function booked_calender_regster_fields() {

        $this->start_controls_section(
            'booked_calender_content',
            [
                'label' => __( 'Booked Calender', 'ht-mega-for-elementor' ),
            ]
        );
            
            $this->add_control(
                'calendar_style',
                [
                    'label'   => __( 'Style', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        ''     => __('Default', 'ht-mega-for-elementor') ,
                        'list' => __('List', 'ht-mega-for-elementor') ,
                    ],
                ]
            );

            $this->add_control(
                'calendar_day',
                [
                    'label'   => __( 'Day', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => gmdate('d'),
                    'options' => [
                        '01'     => __( '01', 'ht-mega-for-elementor' ),
                        '02'     => __( '02', 'ht-mega-for-elementor' ),
                        '03'     => __( '03', 'ht-mega-for-elementor' ),
                        '04'     => __( '04', 'ht-mega-for-elementor' ),
                        '05'     => __( '05', 'ht-mega-for-elementor' ),
                        '06'     => __( '06', 'ht-mega-for-elementor' ),
                        '07'     => __( '07', 'ht-mega-for-elementor' ),
                        '08'     => __( '08', 'ht-mega-for-elementor' ),
                        '09'     => __( '09', 'ht-mega-for-elementor' ),
                        '10'     => __( '10', 'ht-mega-for-elementor' ),
                        '11'     => __( '11', 'ht-mega-for-elementor' ),
                        '12'     => __( '12', 'ht-mega-for-elementor' ),
                        '13'     => __( '13', 'ht-mega-for-elementor' ),
                        '14'     => __( '14', 'ht-mega-for-elementor' ),
                        '15'     => __( '15', 'ht-mega-for-elementor' ),
                        '16'     => __( '16', 'ht-mega-for-elementor' ),
                        '17'     => __( '17', 'ht-mega-for-elementor' ),
                        '18'     => __( '18', 'ht-mega-for-elementor' ),
                        '19'     => __( '19', 'ht-mega-for-elementor' ),
                        '20'     => __( '20', 'ht-mega-for-elementor' ),
                        '21'     => __( '21', 'ht-mega-for-elementor' ),
                        '22'     => __( '22', 'ht-mega-for-elementor' ),
                        '23'     => __( '23', 'ht-mega-for-elementor' ),
                        '24'     => __( '24', 'ht-mega-for-elementor' ),
                        '25'     => __( '25', 'ht-mega-for-elementor' ),
                        '26'     => __( '26', 'ht-mega-for-elementor' ),
                        '27'     => __( '27', 'ht-mega-for-elementor' ),
                        '28'     => __( '28', 'ht-mega-for-elementor' ),
                        '29'     => __( '29', 'ht-mega-for-elementor' ),
                        '30'     => __( '30', 'ht-mega-for-elementor' ),
                        '31'     => __( '31', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'calendar_month',
                [
                    'label'   => __( 'Month', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => gmdate('m'),
                    'options' => [
                        '01' => __('January', 'ht-mega-for-elementor'),
                        '02' => __('February', 'ht-mega-for-elementor'),
                        '03' => __('March', 'ht-mega-for-elementor'),
                        '04' => __('April', 'ht-mega-for-elementor'),
                        '05' => __('May', 'ht-mega-for-elementor'),
                        '06' => __('June', 'ht-mega-for-elementor'),
                        '07' => __('July', 'ht-mega-for-elementor'),
                        '08' => __('August', 'ht-mega-for-elementor'),
                        '09' => __('September', 'ht-mega-for-elementor'),
                        '10' => __('October', 'ht-mega-for-elementor'),
                        '11' => __('November', 'ht-mega-for-elementor'),
                        '12' => __('December', 'ht-mega-for-elementor'),
                    ],
                ]
            );

            $this->add_control(
                'calendar_year',
                [
                    'label'   => __( 'Year', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => gmdate('Y'),
                    'options' => [
                        '2018'     => __( '2018', 'ht-mega-for-elementor' ),
                        '2019'     => __( '2019', 'ht-mega-for-elementor' ),
                        '2020'     => __( '2020', 'ht-mega-for-elementor' ),
                        '2021'     => __( '2021', 'ht-mega-for-elementor' ),
                        '2022'     => __( '2022', 'ht-mega-for-elementor' ),
                        '2023'     => __( '2023', 'ht-mega-for-elementor' ),
                        '2024'     => __( '2024', 'ht-mega-for-elementor' ),
                        '2025'     => __( '2025', 'ht-mega-for-elementor' ),
                        '2026'     => __( '2026', 'ht-mega-for-elementor' ),
                        '2027'     => __( '2027', 'ht-mega-for-elementor' ),
                        '2028'     => __( '2028', 'ht-mega-for-elementor' ),
                        '2029'     => __( '2029', 'ht-mega-for-elementor' ),
                        '2030'     => __( '2030', 'ht-mega-for-elementor' ),
                        '2031'     => __( '2031', 'ht-mega-for-elementor' ),
                        '2032'     => __( '2032', 'ht-mega-for-elementor' ),
                        '2033'     => __( '2033', 'ht-mega-for-elementor' ),
                        '2034'     => __( '2034', 'ht-mega-for-elementor' ),
                        '2035'     => __( '2035', 'ht-mega-for-elementor' ),
                        '2036'     => __( '2036', 'ht-mega-for-elementor' ),
                        '2037'     => __( '2037', 'ht-mega-for-elementor' ),
                        '2038'     => __( '2038', 'ht-mega-for-elementor' ),
                        '2039'     => __( '2039', 'ht-mega-for-elementor' ),
                        '2040'     => __( '2040', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'calendar_size',
                [
                    'label'   => __( 'Calendar Size', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        ''      => __('Default', 'ht-mega-for-elementor') ,
                        'small' => __('Small', 'ht-mega-for-elementor') ,
                    ],
                ]
            );

            $this->add_control(
                'calendar_members_only',
                [
                    'label' => __( 'Members Only', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SWITCHER,
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'booked_calender_header_style_section',
            [
                'label' => __( 'Header', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'calendar_style!' => 'list',
                ],
            ]
        );
            
            $this->add_control(
                'header_background',
                [
                    'label'     => __( 'Header Background', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar thead th' => 'background-color: {{VALUE}} !important;',
                        '{{WRAPPER}} table.booked-calendar thead'    => 'background-color: transparent !important',
                    ],
                ]
            );

            $this->add_control(
                'header_color',
                [
                    'label'     => __( 'Header Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar thead th' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_control(
                'header_day_background',
                [
                    'label'     => __( 'Day Name Background', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar tr.days th' => 'background-color: {{VALUE}} !important;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'header_day_color',
                [
                    'label'     => __( 'Day Name Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar tr.days th' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style Calender Body tab section
        $this->start_controls_section(
            'booked_calender_body_style_section',
            [
                'label' => __( 'Body', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'calendar_style!' => 'list',
                ],
            ]
        );
            $this->add_control(
                'calender_body_background',
                [
                    'label'     => __( 'Background', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar td.prev-month .date'           => 'background-color: {{VALUE}} !important;',
                        '{{WRAPPER}} table.booked-calendar td.next-month .date'           => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} table.booked-calendar td.prev-date:hover .date'      => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} table.booked-calendar td.prev-date .date'            => 'background-color: {{VALUE}} !important;',
                        '{{WRAPPER}} table.booked-calendar td.prev-date:hover .date span' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_control(
                'calender_body_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar td.prev-date .date'            => 'color: {{VALUE}} !important;',
                        '{{WRAPPER}} table.booked-calendar td.prev-month .date span'      => 'color: {{VALUE}} !important;',
                        '{{WRAPPER}} table.booked-calendar td.next-month .date span'      => 'color: {{VALUE}} !important;',
                        '{{WRAPPER}} table.booked-calendar td.prev-date:hover .date span' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style Calender Date tab section
        $this->start_controls_section(
            'booked_calender_date_style_section',
            [
                'label' => __( 'Date', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'calendar_style!' => 'list',
                ],
            ]
        );

            $this->start_controls_tabs( 'booked_calender_date_style_tabs' );
                
                // Available date style
                $this->start_controls_tab(
                    'booked_calender_date',
                    [
                        'label' => __( 'Available Date', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'booked_calender_date_background',
                        [
                            'label'     => __( 'Background', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td .date' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_date_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_date_hover_background',
                        [
                            'label'     => __( 'Hover Background', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td:hover .date span' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_date_hover_color',
                        [
                            'label'     => __( 'Hover Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td:hover .date span' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();
                
                // Current Date style
                $this->start_controls_tab(
                    'booked_calender_current_date',
                    [
                        'label' => __( 'Current Date', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'booked_calender_current_date_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td.today .date span' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_current_date_border_color',
                        [
                            'label'     => __( 'Border Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td.today .date span' => 'border-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_current_date_hover_background',
                        [
                            'label'     => __( 'Hover Background', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td.today:hover .date span' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_current_date_hover_color',
                        [
                            'label'     => __( 'Hover Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} table.booked-calendar td.today:hover .date span' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Appointments Style Section
        $this->start_controls_section(
            'booked_calender_style_apointments',
            [
                'label'     => __( 'Appointments', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'calendar_style!' => 'list',
                ],
            ]
        );

            $this->add_control(
                'apointments_background',
                [
                    'label'     => __( 'Background', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar .booked-appt-list' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot:hover' => 'background-color: rgba(255, 255, 255, 0.3);',
                    ],
                ]
            );

            $this->add_control(
                'apointments_text_color',
                [
                    'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list h2' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time i.booked-icon' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'active_date_background_color',
                [
                    'label'     => __( 'Active Date Background Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.booked-calendar tr.week td.active .date' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} table.booked-calendar tr.week td.active:hover .date' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} table.booked-calendar tr.entryBlock' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .spots-available' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'timeslot_time_text_color',
                [
                    'label'     => __( 'Time Slot Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .spots-available' => 'color: {{VALUE}};',
                    ],
                ]
            );
        $this->end_controls_section();

        // List style Heading Section
        $this->start_controls_section(
            'booked_calender_section_style_heading',
            [
                'label'     => __( 'Heading', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'calendar_style' => 'list',
                ],
            ]
        );

            $this->add_control(
                'booked_calender_list_heading_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .booked-appt-list > h2' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'booked_calender_list_heading_typography',
                    'selector' => '{{WRAPPER}} .booked-appt-list > h2',
                ]
            );

        $this->end_controls_section();

        // List Time 
        $this->start_controls_section(
            'booked_calender_section_style_time',
            [
                'label'     => __( 'Time', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'calendar_style' => 'list',
                ],
            ]
        );

            $this->add_control(
                'booked_calender_list_time_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .timeslot-range' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'booked_calender_list_time_icon_color',
                [
                    'label'     => __( 'Icon Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .timeslot-range .booked-icon.booked-icon-clock' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'booked_calender_list_text_color',
                [
                    'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .spots-available,{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .spots-available' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'booked_calender_list_time_typography',
                    'selector' => '{{WRAPPER}} .timeslot-range',
                ]
            );

        $this->end_controls_section();

        // Appointment Button
        $this->start_controls_section(
            'booked_calender_section_style_appointment_button',
            [
                'label'     => __( 'Appointment Button', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,

            ]
        );

            $this->start_controls_tabs( 'booked_calender_tabs_appointment_button_style' );

                $this->start_controls_tab(
                    'booked_calender_tab_appointment_button_normal',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'booked_calender_appointment_button_text_color',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .new-appt.button' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name'      => 'booked_calender_appointment_button_background',
                            'types'     => [ 'classic', 'gradient' ],
                            'selector'  => '{{WRAPPER}} .new-appt.button',
                            'separator' => 'after',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'        => 'booked_calender_appointment_button_border',
                            'placeholder' => '1px',
                            'default'     => '1px',
                            'selector'    => '{{WRAPPER}} .new-appt.button',
                            'separator'   => 'before',
                        ]
                    );

                    $this->add_control(
                        'booked_calender_appointment_button_radius',
                        [
                            'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .new-appt.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name'     => 'booked_calender_appointment_button_shadow',
                            'selector' => '{{WRAPPER}} .new-appt.button',
                        ]
                    );

                    $this->add_control(
                        'booked_calender_appointment_button_padding',
                        [
                            'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .new-appt.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name'      => 'booked_calender_appointment_button_typography',
                            'selector'  => '{{WRAPPER}} .new-appt.button',
                            'separator' => 'before',
                        ]
                    );

                $this->end_controls_tab(); // Appointment Button Normal

                $this->start_controls_tab(
                    'booked_calender_tab_appointment_button_hover',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'booked_calender_appointment_button_hover_color',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .new-appt.button:hover' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_appointment_button_hover_background',
                        [
                            'label'     => __( 'Background Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .new-appt.button:hover' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'        => 'booked_calender_appointment_button_border_hover',
                            'selector'    => '{{WRAPPER}} .new-appt.button:hover',
                            'separator'   => 'before',
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name'     => 'booked_calender_appointment_button_shadow_hover',
                            'selector' => '{{WRAPPER}} .new-appt.button:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Navigation Button
        $this->start_controls_section(
            'booked_calender_section_style_navigation_button',
            [
                'label'     => __( 'Navigation Button', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,

            ]
        );

            $this->start_controls_tabs( 'booked_calender_tabs_navigation_button_style' );

                $this->start_controls_tab(
                    'booked_calender_tab_navigation_button_normal',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'booked_calender_navigation_button_text_color',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} [class*="booked-list-view-date-"],{{WRAPPER}} table.booked-calendar th .monthName a,{{WRAPPER}} table.booked-calendar thead th .page-left,{{WRAPPER}} table.booked-calendar thead th .page-right' => 'color: {{VALUE}}!important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name'      => 'booked_calender_navigation_button_background',
                            'types'     => [ 'classic', 'gradient' ],
                            'selector'  => '{{WRAPPER}} [class*="booked-list-view-date-"]',
                            'separator' => 'after',
                                'condition' => [
                                    'calendar_style' => 'list',
                                ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'        => 'booked_calender_navigation_button_border',
                            'placeholder' => '1px',
                            'default'     => '1px',
                            'selector'    => '{{WRAPPER}} [class*="booked-list-view-date-"]',
                            'separator'   => 'before',
                            'condition' => [
                                'calendar_style' => 'list',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_navigation_button_radius',
                        [
                            'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} [class*="booked-list-view-date-"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'condition' => [
                                'calendar_style' => 'list',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name'     => 'booked_calender_navigation_button_shadow',
                            'selector' => '{{WRAPPER}} [class*="booked-list-view-date-"]',
                            'condition' => [
                                'calendar_style' => 'list',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_navigation_button_padding',
                        [
                            'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} [class*="booked-list-view-date-"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                            'condition' => [
                                'calendar_style' => 'list',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name'      => 'booked_calender_navigation_button_typography',
                            'selector'  => '{{WRAPPER}} [class*="booked-list-view-date-"],{{WRAPPER}} table.booked-calendar th .monthName a',
                            'separator' => 'before',
                        ]
                    );

                    $this->end_controls_tab();

                    $this->start_controls_tab(
                        'booked_calender_tab_navigation_button_hover',
                        [
                            'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                        ]
                    );

                    $this->add_control(
                        'booked_calender_navigation_button_hover_color',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} [class*="booked-list-view-date-"]:hover,{{WRAPPER}} table.booked-calendar th .monthName a:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name'      => 'booked_calender_navigation_button_hover_background',
                            'types'     => [ 'classic', 'gradient' ],
                            'selector'  => '{{WRAPPER}} [class*="booked-list-view-date-"]:hover',
                            'separator' => 'after',
                            'condition' => [
                                'calendar_style' => 'list',
                            ],
                        ]
                    );

                    $this->add_control(
                        'booked_calender_navigation_button_hover_border_color',
                        [
                            'label'     => __( 'Border Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'condition' => [
                                'navigation_button_border_border!' => '',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} [class*="booked-list-view-date-"]:hover' => 'border-color: {{VALUE}};',
                            ],
                            'separator' => 'before',
                            'condition' => [
                                'calendar_style' => 'list',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Calender Style 
        $this->start_controls_section(
            'booked_calender_section_style_additional',
            [
                'label'     => __( 'Calendar', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'calendar_style' => 'list',
                ],
            ]
        );

            $this->add_control(
                'booked_calender_calendar_icon_color',
                [
                    'label'     => __( 'Calendar Icon Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'booked_calendar_icon_background',
                [
                    'label'     => __( 'Calendar Icon Background', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'        => 'booked_calendar_icon_border',
                    'placeholder' => '1px',
                    'default'     => '1px',
                    'selector'    => '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger',
                    'separator'   => 'before',
                ]
            );

            $this->add_control(
                'booked_calendar_icon_radius',
                [
                    'label'      => __( 'Calendar Icon Radius', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'booked_calendar_icon_shadow',
                    'selector' => '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger'
                ]
            );

            $this->add_control(
                'booked_calendar_icon_padding',
                [
                    'label'      => __( 'Calendar Icon Padding', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'booked_calendar_row_border_color',
                [
                    'label'     => __( 'Row Border Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'booked_calendar_row_border_width',
                [
                    'label' => __( 'Row Border Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 10,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot' => 'border-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    protected function messing_parent_plg_notice() {

        $this->start_controls_section(
            'messing_parent_plg_notice_section',
            [
                'label' => __( 'Booked Calender', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'htmega_plugin_parent_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        /* translators: %1$s: plugin name with install/activate link */
                        __( 'It appears that %1$s is not currently installed on your site. Kindly use the link below to install or activate %1$s. After completing the installation or activation, please refresh this page.', 'ht-mega-for-elementor' ),
                        '<a href="' . esc_url( admin_url( 'plugin-install.php?s=bbpress&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">Booked Calender</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );
        

            $this->add_control(
                'parent_plugin_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="'.esc_url( admin_url( 'plugin-install.php?s=bbpress&tab=search&type=term' ) ).'" target="_blank" rel="noopener">Click to install or activate Booked Calender</a>',
                ]
            );
        $this->end_controls_section();

    }
    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        if ( ! is_plugin_active('booked/booked.php') ) {
            htmega_plugin_missing_alert( __('Booked Calender', 'ht-mega-for-elementor') );
            return;
        }
        $calender_attributes = [
            'style'        => esc_attr( $settings['calendar_style'] ),
            'year'         => esc_attr( $settings['calendar_year'] ),
            'month'        => esc_attr( $settings['calendar_month'] ),
            'day'          => esc_attr( $settings['calendar_day'] ),
            'size'         => esc_attr( $settings['calendar_size'] ),
            'members-only' => ( 'yes' === $settings['calendar_members_only'] ) ? 'true' : '',
        ];
        $this->add_render_attribute( 'shortcode', $calender_attributes );
        
        echo do_shortcode( sprintf( '[booked-calendar %s]', $this->get_render_attribute_string( 'shortcode' ) ) );

    }

}

