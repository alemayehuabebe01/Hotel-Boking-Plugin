<div class="wrap" style="background-color: white; padding:20px;">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <?php $active_tab = $_GET['tab'] ?? 'general'; ?>

    <h2 class="nav-tab-wrapper">
        <a href="?post_type=accommodation&page=accommodation-settings&tab=general" class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>">General</a>
        <a href="?post_type=accommodation&page=accommodation-settings&tab=email" class="nav-tab <?php echo $active_tab === 'email' ? 'nav-tab-active' : ''; ?>">Email</a>
        <a href="?post_type=accommodation&page=accommodation-settings&tab=customer" class="nav-tab <?php echo $active_tab === 'customer' ? 'nav-tab-active' : ''; ?>">Customer Email</a>
    </h2>

    <form method="post" action="options.php">
        <?php
        switch ($active_tab) {
            case 'general':
                settings_fields('nehabi_hotel_group');
                do_settings_sections('nehabi_search_page_section');
                submit_button('Save Settings');
                break;

            case 'email':
                echo '<p>Coming soon: Email configuration.</p>';
                break;

            case 'customer':
                echo '<p>Coming soon: Customer email templates.</p>';
                break;

            default:
                echo '<p>No settings found for this tab.</p>';
                break;
        }
        ?>
    </form>
</div>
