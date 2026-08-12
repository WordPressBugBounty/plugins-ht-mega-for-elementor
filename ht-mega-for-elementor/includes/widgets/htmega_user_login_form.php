<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_User_Login_Form extends Widget_Base {

    public function get_name() {
        return 'htmega-userlogin-form-addons';
    }
    
    public function get_title() {
        return __( 'User Login Form', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-lock-user';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['user login form', 'login form','htmega','ht mega'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/general-widgets/user-login-form-widget/';
    }

    protected function register_controls() {

        $this->start_controls_section(
            'user_login_form_content',
            [
                'label' => __( 'Login Form', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'htmega_loginform_style',
                [
                    'label' => __( 'Style', 'ht-mega-for-elementor' ),
                    'type' => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Style One', 'ht-mega-for-elementor' ),
                        '2'   => __( 'Style Two', 'ht-mega-for-elementor' ),
                        '3'   => __( 'Style Three', 'ht-mega-for-elementor' ),
                        '4'   => __( 'Style Four', 'ht-mega-for-elementor' ),
                        '5'   => __( 'Style Five', 'ht-mega-for-elementor' ),
                        '6'   => __( 'Style Six', 'ht-mega-for-elementor' ),
                        '7'   => __( 'Style Seven', 'ht-mega-for-elementor' ),
                    ],
                ]
            );
            
            $this->add_control(
                'htmega_loginform_header',
                [
                    'label' => __( 'Login Header', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );  

            $this->add_control(
                'show_loginform_heading',
                [
                    'label' => __( 'Show Heading And Content', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'loginform_header_title',
                [
                    'label' => __( 'Login Header Title', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => __( 'Hello!', 'ht-mega-for-elementor' ),
                    'placeholder' => __( 'Hello!', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'show_loginform_heading'=>'yes',
                    ],
                ]
            );

            $this->add_control(
                'loginform_heading_content',
                [
                    'label' => __( 'Login Content', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( "Don’t Have account? You can create an account by using this form.","ht-mega-for-elementor" ),
                    'placeholder' => __( "Don’t Have account? You can create an account by using this form.","ht-mega-for-elementor" ),
                    'condition'=>[
                        'show_loginform_heading' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'loginform_heading_singup',
                [
                    'label' => __( 'Register Heading Login', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'label_off' => __( 'No', 'ht-mega-for-elementor' ),
                    'label_on' => __( 'Yes', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'show_loginform_heading' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'loginform_heading_singup_control',
                [
                    'label' => __( 'SingUp Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Sign Up', 'ht-mega-for-elementor' ),
                    'placeholder' => __( 'Sign Up', 'ht-mega-for-elementor' ),
                    'condition'     => [
                        'loginform_heading_singup' => 'yes',
                        'show_loginform_heading' => 'yes',
                    ],
                ]
            );   

            $this->add_responsive_control(
                'login_form_text_color_alignment',
                [
                    'label' => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .user-register-header' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'left',
                    'condition'=>[
                        'show_loginform_heading'=>'yes',
                    ],
                ]
            );
            
            $this->add_control(
                'htmega_loginform_form',
                [
                    'label' => __( 'Login Form', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );    

            $this->add_control(
                'htmega_form_show_label',
                [
                    'label' => esc_html__( 'Label', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_off' => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
                    'label_on' => esc_html__( 'Show', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'htmega_form_show_customlabel',
                [
                    'label' => esc_html__( 'Custom label', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'label_off' => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
                    'label_on' => esc_html__( 'Show', 'ht-mega-for-elementor' ),
                    'condition' =>[
                        'htmega_form_show_label' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'htmega_user_label',
                    [
                    'label'     => esc_html__( 'Username Label', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => esc_html__( 'Username or Email', 'ht-mega-for-elementor' ),
                    'condition' => [
                        'htmega_form_show_label'   => 'yes',
                        'htmega_form_show_customlabel' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'htmega_user_placeholder',
                [
                    'label'     => esc_html__( 'Username Placeholder', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => esc_html__( 'Username or Email', 'ht-mega-for-elementor' ),
                    'condition' => [
                        'htmega_form_show_label'   => 'yes',
                        'htmega_form_show_customlabel' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'htmega_password_label',
                [
                    'label'     => esc_html__( 'Password Label', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => esc_html__( 'Password', 'ht-mega-for-elementor' ),
                    'condition' => [
                        'htmega_form_show_label'   => 'yes',
                        'htmega_form_show_customlabel' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'htmega_password_placeholder',
                [
                    'label'     => __( 'Password Placeholder', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'Password', 'ht-mega-for-elementor' ),
                    'condition' => [
                        'htmega_form_show_label'   => 'yes',
                        'htmega_form_show_customlabel' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'lost_password_label',
                [
                    'label' => __( 'Lost Your Password ', 'ht-mega-for-elementor' ) . ' <i class="eicon-pro-icon"></i>',
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Lost your password?', 'ht-mega-for-elementor' ),
                    'classes' => 'htmega-disable-control',
                    'condition'     => [
                        'htmega_form_show_customlabel' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'remember_me_label',
                [
                    'label' => __( 'Remember Me ', 'ht-mega-for-elementor' ) . ' <i class="eicon-pro-icon"></i>',
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Remember Me', 'ht-mega-for-elementor' ),
                    'classes' => 'htmega-disable-control',
                    'condition'     => [
                        'htmega_form_show_customlabel' => 'yes',
                    ],
                    'separator' =>'after'
                ]
            );

            $this->add_control(
                'redirect_page',
                [
                    'label' => __( 'Redirect page after Login', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'label_off' => __( 'No', 'ht-mega-for-elementor' ),
                    'label_on' => __( 'Yes', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'redirect_page_url',
                [
                    'type'          => Controls_Manager::URL,
                    'show_label'    => false,
                    'show_external' => false,
                    'separator'     => false,
                    'placeholder'   => 'http://your-link.com/',
                    'condition'     => [
                        'redirect_page' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'lost_password',
                [
                    'label'     => esc_html__( 'Lost your password?', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'default'   => 'yes',
                    'label_off' => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
                    'label_on'  => esc_html__( 'Show', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'lost_password_position',
                [
                    'label' => __( 'Forget Password Position', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'before-login',
                    'options' => [
                        'before-login'    => __( 'Before/Top Login Button', 'ht-mega-for-elementor' ),
                        'after-login'     => __( 'After/Bottom Login Button', 'ht-mega-for-elementor' ),
                    ],
                    'condition'     => [
                        'lost_password' => 'yes',
                    ],
                ]
            );            
            $this->add_control(
                'remember_me',
                [
                    'label'     => esc_html__( 'Remember Me', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'default'   => 'yes',
                    'label_off' => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
                    'label_on'  => esc_html__( 'Show', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes'
                    
                ]
            );
            
            if ( get_option( 'users_can_register' ) ) {
                $this->add_control(
                    'register_link',
                    [
                        'label'     => esc_html__( 'Register Button', 'ht-mega-for-elementor' ),
                        'type'      => Controls_Manager::SWITCHER,
                        'default'   => 'no',
                        'label_off' => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
                        'label_on'  => esc_html__( 'Show', 'ht-mega-for-elementor' ),
                    ]
                );

                $this->add_control(
                    'register_link_text',
                    [
                        'label' => __( 'Register Link Text', 'ht-mega-for-elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Register', 'ht-mega-for-elementor' ),
                        'condition'     => [
                            'register_link' => 'yes',
                        ],
                    ]
                );
                $this->add_control(
                    'custom_register_url',
                    [
                        'label' => __( 'Register Custom URL', 'ht-mega-for-elementor' ).' <i class="eicon-pro-icon"></i>',
                        'type' => Controls_Manager::URL,
                        'placeholder' => __( 'https://your-link.com/register', 'ht-mega-for-elementor' ),
                        'show_external' => true,
                        'classes' => 'htmega-disable-control',
                        'default' => [
                            'url'         => '#',
                            'is_external' => false,
                            'nofollow'    =>  false,
                        ],
                        'condition'=>[
                            'register_link' => 'yes',
                        ]
                    ]
                );
            }

            $this->add_control(
                'login_button_heading',
                [
                    'label' => __( 'Login Button', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'login_button_text',
                [
                    'label' => __( 'Button Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Login', 'ht-mega-for-elementor' ),
                ]
            );
            
            $this->add_responsive_control(
                'login_button_alignment',
                [
                    'label' => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .htmega-login-button' => 'justify-content: {{VALUE}};',
                    ],
                    'default' => 'left',
                    'condition'     => [
                        'register_link!' => 'yes',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'login_button_flex_direction',
                [
                    'label' => __( 'Display as', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'row' => [
                            'title' => __( 'Row', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-align-end-v',
                        ],
                        'column' => [
                            'title' => __( 'Column', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-column',
                        ],
                        'row-reverse' => [
                            'title' => __( 'Row Reverse', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-h-align-stretch',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .htmega-login-button' => 'flex-direction: {{VALUE}};',
                    ],
                    'default' => 'row',
                    'condition'     => [
                        'register_link' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'login_button_justify_content',
                [
                    'label' => __( 'Justify Content', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'space-between',
                    'options' => [
                        'flex-start'    => __( 'Start', 'ht-mega-for-elementor' ),
                        'flex-end'      => __( 'End', 'ht-mega-for-elementor' ),
                        'center'        => __( 'Center', 'ht-mega-for-elementor' ),
                        'space-between' => __( 'Space Between', 'ht-mega-for-elementor' ),
                        'space-around'  => __( 'Space Around', 'ht-mega-for-elementor' ),
                        'space-evenly'  => __( 'Space Evenly', 'ht-mega-for-elementor' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .htmega-login-button' => 'justify-content: {{VALUE}};',
                    ],
                    'condition'     => [
                        'register_link' => 'yes',
                        'login_button_flex_direction!' => 'column',
                    ],
                ]
            );

            $this->add_responsive_control(
                'login_form_register_button_space_row',
                [
                    'label' => __( 'Manual Space', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text' => 'margin-left: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => [
                        'login_button_flex_direction' => 'row',
                        'login_button_justify_content' => ['flex-start','flex-end','center'],
                        'register_link' => 'yes',
                    ],
                ]
            );  

            $this->add_responsive_control(
                'login_form_register_button_space_column',
                [
                    'label' => __( 'Manual Space', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .htmega-login-button .login-register-buit' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => [
                        'login_button_flex_direction' => 'column',
                        'register_link' => 'yes',
                    ],
                ]
            );  

            $this->add_responsive_control(
                'login_form_register_button_space_row_reverse',
                [
                    'label' => __( 'Manual Space', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => [
                        'login_button_flex_direction' => 'row-reverse',
                        'login_button_justify_content' => ['flex-start','flex-end','center'],
                        'register_link' => 'yes',
                    ],
                ]
            );   

            
        $this->end_controls_section();
        $this->start_controls_section(
            'validation_messages_section',
                [
                'label' => __( 'Errors and Success Messages ', 'ht-mega-for-elementor' ).'<i class="eicon-pro-icon"></i>',
            ]
        );
            $this->add_control(
                'update_pro_validation_messages',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf( /* translators: 1: Opening strong and anchor tags for Pro Version link, 2: Closing anchor and strong tags */
                        __('Upgrade to pro version to use this feature %1$s Pro Version %2$s', 'ht-mega-for-elementor'),
                        '<strong><a href="https://wphtmega.com/pricing/" target="_blank">',
                        '</a></strong>'),
                    'content_classes' => 'htmega-addons-notice',
                ]
            );
        $this->end_controls_section();
        // Style tab section
        $this->start_controls_section(
            'htmega_login_form_style_section',
            [
                'label' => __( 'Form Wrapper', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'login_form_section_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-login-form-wrapper',
                ]
            );

            $this->add_responsive_control(
                'login_form_style_align',
                [
                    'label' => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .input-alignment' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}} .htmega-rem-lost-alignment-single .log-remember' => 'justify-content: {{VALUE}};',
                    ],
                    'default' => 'left',
                    'separator' =>'before',
                ]
            );            

            $this->add_responsive_control(
                'htmega_login_area_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'login_form_section_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'login_form_section_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'login_form_section_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-login-form-wrapper',
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'login_form_heading_style',
            [
                'label' => __( 'Form Header', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_loginform_heading'=>'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'login_form_text_color_padding',
            [
                'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .user-register-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'login_form_heading_style_heading',
            [
                'label' => __( 'Heading Title Style', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition'=>[
                    'loginform_header_title!'=>'',
                ]
            ]
        );  

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'login_form_heading_typography',
                'selector' => '{{WRAPPER}} .user-register-header h2',
                'condition'=>[
                    'loginform_header_title!'=>'',
                ]
            ]
        );
            
        $this->add_control(
            'login_form_heading_color',
            [
                'label'     => __( 'Header Color', 'ht-mega-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .user-register-header h2'   => 'color: {{VALUE}};',
                ],
                'condition'=>[
                    'loginform_header_title!'=>'',
                ]
            ]
        );

        $this->add_responsive_control(
            'login_form_text_color_margin',
            [
                'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .user-register-header h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'=>[
                    'loginform_header_title!'=>'',
                ]
            ]
        );        

        $this->add_control(
            'login_form_heading_style_content',
            [
                'label' => __( 'Header Content', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition'=>[
                    'loginform_heading_content!'=>'',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'login_form_content_typography',
                'selector' => '{{WRAPPER}} .user-register-header p',
                'condition'=>[
                    'loginform_heading_content!'=>'',
                ]
            ]
        );
            
        $this->add_control(
            'login_form_content_color',
            [
                'label'     => __( 'Content Color', 'ht-mega-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .user-register-header p'   => 'color: {{VALUE}};',
                ],
                'condition'=>[
                    'loginform_heading_content!'=>'',
                ]
            ]
        );

        $this->add_responsive_control(
            'login_form_content_color_margin',
            [
                'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .user-register-header p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'=>[
                    'loginform_heading_content!'=>'',
                ]
            ]
        ); 
            
        $this->add_control(
            'login_form_content_link_color',
            [
                'label'     => __( 'Link Color', 'ht-mega-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .user-register-header p a'   => 'color: {{VALUE}};',
                ],
                'separator' =>'before',
                'condition'=>[
                    'loginform_heading_content!'=>'',
                ]
            ]
        );
            
        $this->add_control(
            'login_form_content_link_hover_color',
            [
                'label'     => __( 'Link Hover Color', 'ht-mega-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .user-register-header p a:hover'   => 'color: {{VALUE}};',
                ],
                'condition'=>[
                    'loginform_heading_content!'=>'',
                ]
            ]
        );        

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'login_form_style_input',
            [
                'label' => __( 'Input', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'login_form_input_typography',
                    'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input',
                ]
            );

            $this->add_responsive_control(
                'login_form_input_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'login_form_input_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'login_form_input_height',
                [
                    'label' => __( 'Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper input[type="text"],{{WRAPPER}} .htmega-login-form-wrapper input[type="password"]' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            $this->add_responsive_control(
                'input_alignment',
                [
                    'label' => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .input-alignment input' => 'text-align: {{VALUE}};',
                    ],
                ]
            );  
            $this->add_control(
                'input_color_border_heading',
                [
                    'label' => __( 'Colors and Border', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->start_controls_tabs(
                'input_fields_tab'
            );
                // Normal Style Tab
                $this->start_controls_tab(
                    'input_normal',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'login_form_input_text_color',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'login_form_input_placeholder_color',
                        [
                            'label'     => __( 'Placeholder Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="text"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="text"]::-moz-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="text"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="password"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="password"]::-moz-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="password"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="email"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="email"]::-moz-placeholder'  => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type*="email"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'login_form_input_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'login_form_input_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'login_form_input_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'input_fields_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper .input-alignment input',
                            'separator' =>'before',
                        ]
                    );
                $this->end_controls_tab();

                // Hover Style Tab
                $this->start_controls_tab(
                    'input_focus',
                    [
                        'label' => __( 'Focus', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'login_form_input_text_color_focus',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input:focus'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'login_form_input_background_focus',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input:focus',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'login_form_input_border_focus',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input:focus',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'login_form_input_border_radius_focus',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'input_fields_shadow_focus',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper .input-alignment input:focus',
                            'separator' =>'before',
                        ]
                    );
                $this->end_controls_tab();
            $this->end_controls_tabs();
        $this->end_controls_section();

        // Forget text section start
        $this->start_controls_section(
            'login_form_style_forget_text',
            [
                'label' => __( 'Lost Password', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lost_password' => 'yes'
                ]
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'login_form_input_forget_typography',
                    'selector' => '{{WRAPPER}} .log-remember a.fright',
                ]
            );
            
            $this->add_control(
                'login_form_input_forget_label_text_color',
                [
                    'label'     => __( 'Forget Text Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .log-remember a.fright'   => 'color: {{VALUE}};',
                    ],
                ]
            );
            
            $this->add_control(
                'login_form_input_forget_label_text_hover_color',
                [
                    'label'     => __( 'Forget Text Hover Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .log-remember a.fright:hover'   => 'color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Rememberme section start
        $this->start_controls_section(
            'login_form_style_rememberme',
            [
                'label' => __( 'Remember Me Checkbox', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                 'condition' => [
                    'remember_me' => 'yes'
                 ]
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'login_form_input_rememberme_typography',
                    'selector' => '{{WRAPPER}} .log-remember label.lable-content',
                ]
            );
            
            $this->add_control(
                'login_form_input_remember_me_text_color',
                [
                    'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .log-remember label.lable-content'   => 'color: {{VALUE}};',
                    ],
                ]
            );
            
            $this->add_control(
                'login_form_input_remember_me_text_hover_color',
                [
                    'label'     => __( 'Hover Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .log-remember label.lable-content:hover'   => 'color: {{VALUE}};',
                    ],
                ]
            );
            
            $this->add_control(
                'login_form_input_rememberme_label_text_color',
                [
                    'label'     => __( 'Checkbox Icon Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper span.checkmark, {{WRAPPER}} .lable-content .checkmark:after'   => 'color: {{VALUE}};border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'login_form_input_rememberme_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper span.checkmark' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'login_form_input_rememberme_height',
                [
                    'label' => __( 'Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 18,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper span.checkmark' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); // Checkbox section end

        // Submit Button
        $this->start_controls_section(
            'login_form_style_submit_button',
            [
                'label' => __( 'Submit Button', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'login_form_submitbutton_typography',
                'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]',
            ]
        );
            $this->add_responsive_control(
                'login_form_submitbutton_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'login_form_submitbutton_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper .htmega-login-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            $this->add_control(
                'login_form_submitbutton_height',
                [
                    'label' => __( 'Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'login_form_submitbutton_width',
                [
                    'label' => __( 'Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'submit_button_cb_heading',
                [
                    'label' => __( 'Colors and Border', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            // Button Tabs Start
            $this->start_controls_tabs('login_form_style_submit_tabs');

                // Start Normal Submit button tab
                $this->start_controls_tab(
                    'login_form_style_submit_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'login_form_submitbutton_text_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'login_form_submitbutton_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'login_form_submitbutton_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'login_form_submitbutton_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal submit Button tab end

                // Start Hover Submit button tab
                $this->start_controls_tab(
                    'login_form_style_submit_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'login_form_submitbutton_hover_text_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]:hover'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'login_form_submitbutton_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'login_form_submitbutton_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]:hover',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'login_form_submitbutton_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper input[type="submit"]:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover Submit Button tab End

            $this->end_controls_tabs(); // Button Tabs End

        $this->end_controls_section();

        // Register Button
        $this->start_controls_section(
            'login_form_style_register_button',
            [
                'label' => __( 'Register Button', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'register_link'=>'yes',
                ],
            ]
        );

            // Button Tabs Start
            $this->start_controls_tabs('login_form_style_register_tabs');

                // Start Normal Submit button tab
                $this->start_controls_tab(
                    'login_form_style_register_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'login_form_register_button_text_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'login_form_register_button_typography',
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'login_form_register_button_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text',
                        ]
                    );            

                    $this->add_responsive_control(
                        'login_form_register_button_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'login_form_register_button_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'login_form_register_button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal submit Button tab end

                // Start Hover Submit button tab
                $this->start_controls_tab(
                    'login_form_style_register_button_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'login_form_register_button_hover_text_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text:hover'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'login_form_register_button_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'login_form_register_button_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text:hover',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'login_form_register_button_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-login-form-wrapper .login-register-buit a.login_register_text:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover Submit Button tab End

            $this->end_controls_tabs(); // Button Tabs End

        $this->end_controls_section();

        // Label Style Start
        $this->start_controls_section(
            'login_form_style_label',
            [
                'label' => __( 'Label', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'login_form_label_text_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper label , {{WRAPPER}} .htmega-login-form-wrapper .login_register_text'   => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'login_form_label_typography',
                    'selector' => '{{WRAPPER}} .htmega-login-form-wrapper label,{{WRAPPER}} .htmega-login-form-wrapper .login_register_text',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'login_form_label_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-login-form-wrapper label',
                ]
            );

            $this->add_responsive_control(
                'login_form_label_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'login_form_label_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'login_form_label_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-login-form-wrapper label',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'login_form_label_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-login-form-wrapper label' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();
        // Validation message
        $this->start_controls_section(
            'validation_message_style',
            [
                'label' => __( 'Errors & Success ', 'ht-mega-for-elementor' ).' <i class="eicon-pro-icon"></i>',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'update_pro_error_style',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => sprintf(/* translators: 1: Opening strong and anchor tags for Pro Version link, 2: Closing anchor and strong tags */
                    __('Upgrade to pro version to use this feature %1$s Pro Version %2$s', 'ht-mega-for-elementor'),
                    '<strong><a href="https://wphtmega.com/pricing/" target="_blank">',
                    '</a></strong>'),
                'content_classes' => 'htmega-addons-notice',
            ]
        );
        
        $this->end_controls_section(); 
    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $current_url = remove_query_arg( 'fake_arg' );
        $id = $this->get_id();

        if ( $settings['redirect_page'] == 'yes' && ! empty( $settings['redirect_page_url']['url'] ) ) {
            $redirect_url = esc_url( $settings['redirect_page_url']['url'] );
        } else {
            $redirect_url = $current_url;
        }
        if ( $settings['lost_password'] == 'yes' &&  'yes' == $settings['remember_me'] ) {
            $remember_lost_p_alignment = 'htmega-rem-lost-alignment-both';
        } else {
            $remember_lost_p_alignment = 'htmega-rem-lost-alignment-single';
        }



        $this->add_render_attribute( 'loginform_area_attr', 'class', 'htmega-login-form-wrapper' );
        $this->add_render_attribute( 'loginform_area_attr', 'class', 'htmega-login-form-style-' . esc_attr( $settings['htmega_loginform_style'].' '.$remember_lost_p_alignment ) );

        // Label Value
        $user_label = isset( $settings['htmega_user_label'] ) ? $settings['htmega_user_label'] : __('Username','ht-mega-for-elementor');
        $user_placeholder = isset( $settings['htmega_user_placeholder'] ) ? $settings['htmega_user_placeholder'] : __('Username','ht-mega-for-elementor');
        $pass_label = isset( $settings['htmega_password_label'] ) ? $settings['htmega_password_label'] : __('Password','ht-mega-for-elementor');
        $pass_placeholder = isset( $settings['htmega_password_placeholder'] ) ? $settings['htmega_password_placeholder'] : __('Password','ht-mega-for-elementor');
       
        ?>
            <div <?php echo $this->get_render_attribute_string( 'loginform_area_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core, values added via add_render_attribute() were esc_attr()'d above ?> >

                <div id="htmega_message_<?php echo esc_attr( $id ); ?>" class="htmega_message">&nbsp;</div>

                <?php
                    if ( is_user_logged_in() && ! Plugin::instance()->editor->is_edit_mode() ) {
                        $current_user = wp_get_current_user();
                        $logout_url = wp_logout_url( $current_url );
                    
                        echo '<div class="htmega-user-login">' .
                            sprintf(
                                /* translators: 1: user's display name, 2: logout URL */
                                esc_html__( 'You are logged in as %1$s (%2$s)', 'ht-mega-for-elementor' ),
                                esc_html( $current_user->display_name ),
                                '<a href="' . esc_url( $logout_url ) . '">' . esc_html__( 'Logout', 'ht-mega-for-elementor' ) . '</a>'
                            ) .
                        '</div>';
                        return;
                    }

                ?>

                    <?php if($settings['show_loginform_heading']): ?>
                    <div class="user-register-header">
                        <?php if($settings['loginform_header_title']):
                            echo '<h2>'. htmega_kses_title($settings['loginform_header_title']) .'</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php
                        endif; ?>
                        <?php if($settings['loginform_heading_content']):
                            echo '<p>' .
                            sprintf( '%1$s <a href="%2$s">%3$s</a>' , wp_kses_post($settings['loginform_heading_content']) , esc_url( wp_registration_url() ) , wp_kses_post($settings['loginform_heading_singup_control']) ) . // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_kses_post() sanitizes the two text pieces, wp_registration_url() esc_url()'d
                            '</p>';
                        endif; ?>
                    </div>
                    <?php endif; ?>                    

                <form id="htmega_login_form_<?php echo esc_attr( $id ); ?>" action="formloginaction" method="post">

                    <div class="htb-row">

                        <div class="htb-col-lg-12 input-alignment">
                            <?php

                                if( $settings['htmega_form_show_label'] == 'yes'){
                                    echo sprintf('<label for="%1$s">%2$s</label>' , esc_attr('login_username'. $id ), htmega_kses_title( $user_label )); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php
                                }

                            ?>
                            <input 
                                type="text"  
                                id="login_username<?php echo esc_attr( $id ); ?>" 
                                name="login_username" 
                                placeholder="<?php echo esc_attr( $user_placeholder );?>">
                        </div>

                        <div class="htb-col-lg-12 input-alignment">
                            <?php
                                if( $settings['htmega_form_show_label'] == 'yes'){
                                    echo sprintf('<label for="%1$s">%2$s</label>', esc_attr( 'login_password'. $id ) , htmega_kses_title( $pass_label )); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php
                                }
                            ?>
                            <input 
                                type="password" 
                                id="login_password<?php echo esc_attr( $id ); ?>" 
                                name="login_password" 
                                placeholder="<?php echo esc_attr( $pass_placeholder );?>">
                        </div>

                        <div class="htb-col-lg-12 lost-password">
                            <div class="log-remember">
                                <?php if( $settings['remember_me'] == 'yes' ): ?>
                                    <label class="lable-content"><?php esc_html_e('Remember Me','ht-mega-for-elementor'); ?>
                                        <input name="rememberme" type="checkbox" id="rememberme" value="forever">
                                        <span class="checkmark"></span>
                                    </label>
                                <?php endif; if( $settings['lost_password'] == 'yes' && $settings['lost_password_position'] == 'before-login' ): ?>
                                    <a href="<?php echo esc_url( wp_lostpassword_url( $current_url ) ); ?>" class="fright"><?php esc_html_e('Forgot Password?','ht-mega-for-elementor'); ?></a>
                                <?php endif;?>
                            </div>
                        </div>

                        <div class="htb-col-lg-12">
                            <div class="htmega-login-button">
                                <input 
                                    type="submit" 
                                    id="login_form_submit_<?php echo esc_attr( $id ); ?>" 
                                    name="login_form_submit<?php echo esc_attr( $id ); ?>" 
                                    value="<?php if( !empty( $settings['login_button_text'] ) ){ echo esc_attr( $settings['login_button_text'] ); } else { esc_html_e( 'Login', 'ht-mega-for-elementor' ); } ?>">
                                    <div class="login-register-buit">
                                        <?php if( get_option( 'users_can_register' ) && $settings['register_link'] == 'yes' ): ?>
                                            <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="login_register_text">
                                                <?php if( !empty( $settings['register_link_text'] ) ){ echo esc_attr( $settings['register_link_text'] ); } else { esc_html_e( 'Register', 'ht-mega-for-elementor' ); } ?>
                                            </a>
                                        <?php endif;?>    
                                    </div>

                            </div>   
                            <?php if( $settings['lost_password'] == 'yes' && $settings['lost_password_position'] == 'after-login' ): ?>
                            <div class="log-remember">
                                <a href="<?php echo esc_url( wp_lostpassword_url( $current_url ) ); ?>" class="fright"><?php esc_html_e('Forgot Password?','ht-mega-for-elementor'); ?></a>
                            </div> 
                            <?php endif;?>
                        </div>

                    </div>

                    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>

                </form>

            </div>

        <?php

        $this->htmega_login_check( $settings['redirect_page'], $redirect_url, $id );

    }

    public function htmega_login_check( $reddirectstatus, $redirect_url, $id ) {

        ?>

        <script type="text/javascript">

            jQuery(document).ready(function($) {
                "use strict";

                var ajaxurl = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
                var loadingmessage = '<?php echo esc_html__('Please wait...','ht-mega-for-elementor'); ?>';
                var login_form_id = 'form#htmega_login_form_<?php echo esc_attr( $id ); ?>';
                var login_button_id = '#login_form_submit_<?php echo esc_attr( $id ); ?>';
                var redirect = '<?php echo esc_attr( $reddirectstatus ); ?>';

                $( login_button_id ).on('click', function(){

                    $('#htmega_message_<?php echo esc_attr( $id ); ?>').html('<span class="htmega_lodding_msg">'+ loadingmessage +'</span>').fadeIn();

                    $.ajax({  
                        type: 'POST',
                        dataType: 'json',  
                        url:  ajaxurl,  
                        data: { 
                            'action': 'htmega_ajax_login',
                            'username': $( login_form_id + ' #login_username<?php echo esc_js( $id ); ?>').val(), 
                            'password': $( login_form_id + ' #login_password<?php echo esc_js( $id ); ?>').val(), 
                            'security': $( login_form_id + ' #security').val()
                        },
                        success: function(msg){
                            if ( msg.loggeauth == true ){
                                $('#htmega_message_<?php echo esc_js( $id ); ?>').html('<div class="htmega_success_msg alert alert-success">'+ msg.message +'</div>').fadeIn();
                                if( redirect === 'yes' ){
                                    if(document.location.href == '<?php echo esc_url( $redirect_url ); ?>'){
                                        window.location.reload();
                                        window.location.reload();
                                    } else {
                                        document.location.href = '<?php echo esc_url( $redirect_url ); ?>';
                                    }
                                }
                            }else{
                                $('#htmega_message_<?php echo esc_js( $id ); ?>').html('<div class="htmega_invalid_msg alert alert-danger">'+ msg.message +'</div>').fadeIn();
                            }
                        }  
                    });

                    return false;
                  
                });

            });

        </script>

        <?php

    }
    
}