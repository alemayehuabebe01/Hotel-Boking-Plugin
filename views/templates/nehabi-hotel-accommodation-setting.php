<div class="wrap" style="background-color: white; padding:20px;">
      <h1><?php echo esc_html( get_admin_page_title() );  ?></h1>

      <?php 

          $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

      ?>

      <h2 class="nav-tab-wrapper">
           
           <a href="?page=accommodation-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a> 
           
      </h2>
      <form action="options.php" method="post">
           
         <?php 

                switch ( $active_tab ) {
                    case 'general':
                        settings_fields('nehabi_hotel_group');
                        do_settings_sections('nehabi_search_page_section');
                        break;

                    default:
                        echo '<h2>Nothing to show for this tab.</h2>';
                        break;
              }
          ?>

      </form>
</div>