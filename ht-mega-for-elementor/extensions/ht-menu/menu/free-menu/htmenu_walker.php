<?php

/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/

use Elementor\Plugin as Elementor;

class HTMega_Menu_Nav_Walker extends Walker_Nav_Menu {

  public $htmenu_menupos = '';
  public $htmenu_menuwidth = '';

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1 ); // because it counts the first submenu as 0
        if ($display_depth == 1) {
         $style = function_exists( 'htmega_walker_submenu_wrapper_style_attr' ) ? htmega_walker_submenu_wrapper_style_attr( $this->htmenu_menuwidth, $this->htmenu_menupos ) : '';
        }else{
          $style = '';
        }

        $classes = array(
            'sub-menu',
            ( $display_depth % 2 ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // Build HTML for output.
        $output .= "\n$indent<ul class='" . $class_names . "' $style >\n";
  }


  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

    if( isset( $item->menuposition ) && $item->ID  ){
        $this->htmenu_menupos =  $item->menuposition;
    }

    if( isset( $item->menuwidth ) &&  $item->ID ){
         $this->htmenu_menuwidth = $item->menuwidth;
    }

    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

    // Depth-dependent classes.
    $depth_classes = array(
      ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
      ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
      ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
      'menu-item-depth-' . $depth
    );
    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

    // Passed classes.
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    // If Enable MegaMenu
    if( isset( $item->template ) && !empty( $item->template ) ){
        $classes[] = 'htmega_mega_menu';
    }

    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) ) );

    // Build HTML.
    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

    // Link attributes.
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';


    $dropdown_icon = '';
    $dropdown_kses = array(
        'i'    => array( 'class' => true, 'aria-hidden' => true ),
        'span' => array( 'class' => true ),
        'svg'  => array( 'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'class' => true, 'stroke-linejoin' => true, 'stroke-miterlimit' => true ),
        'path' => array( 'd' => true, 'fill' => true, 'id' => true ),
    );
    if( !empty( $item->classes ) && 
        is_array( $item->classes ) && 
        in_array( 'menu-item-has-children', $item->classes ) ){
        if($depth > 0 ){
            $dropdown_icon = '<span class="htmenu-icon"><i class="fas fa-angle-right"></i></span>';
        }else{
            if ( isset( $args->extra_menu_settings['dropdown_icon'] ) ) {
                $dropdown_icon = '<span class="htmenu-icon">' . wp_kses( $args->extra_menu_settings['dropdown_icon'], $dropdown_kses ) . '</span>';
            } else {
                $dropdown_icon = '<span class="htmenu-icon"><i class="fas fa-angle-down"></i></span>';
            }
        }

    }

    // Custom Data
    $icon = $buildercontent = $badge = '';

    $icon = ( isset( $item->ficon ) && ! empty( $item->ficon ) && function_exists( 'htmega_walker_menu_icon_markup' ) )
        ? htmega_walker_menu_icon_markup( $item )
        : '';

    if( isset( $item->template ) && !empty( $item->template ) ){
        $buildercontent = $this->getItemBuilderContent( $item->template );
        if ( isset( $args->extra_menu_settings['dropdown_icon'] ) ) {
            $dropdown_icon = '<span class="htmenu-icon">' . wp_kses( $args->extra_menu_settings['dropdown_icon'], $dropdown_kses ) . '</span>';
        } else {
            $dropdown_icon = '<span class="htmenu-icon"><i class="fas fa-angle-down"></i></span>';
        }
    }

    $badge = ( isset( $item->menutag ) && ! empty( $item->menutag ) && function_exists( 'htmega_walker_menu_badge_markup' ) )
        ? htmega_walker_menu_badge_markup( $item )
        : '';

    // Build HTML output and pass through the proper filter.
    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s%6$s%7$s%8$s</a>%9$s',
        $args->before,
        $attributes,
        $args->link_before,
        $icon,
        function_exists( 'htmega_walker_menu_item_title' ) ? htmega_walker_menu_item_title( $item ) : apply_filters( 'the_title', $item->title, $item->ID ),
        $dropdown_icon,
        $badge,
        $args->link_after,
        $args->after
    );

    if( !empty( $buildercontent ) ){
        $item_output .= function_exists( 'htmega_walker_megamenu_wrap_markup' )
            ? htmega_walker_megamenu_wrap_markup( $item, $buildercontent )
            : sprintf( '<div class="htmegamenu-content-wrapper sub-menu" style="">%s</div>', $buildercontent );
    }

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
    $id_field = $this->db_fields['id'];
    if ( is_object( $args[0] ) ){
       $args[0]->has_children =  !empty ( $children_elements[ $element->$id_field ] ) ;
    }
    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  // Item Builder Content
  private function getItemBuilderContent( $template_id ){
    static $elementor = null;
    return htmega_get_template_content_by_id( $template_id );
  }
}