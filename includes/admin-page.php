<?php
/**
 * Admin page template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$active_status = get_option( 'merchant_ai_active_status', '1' );
$auto_sync_status = get_option( 'merchant_ai_auto_sync_status', '1' );

// Mock data, in a real scenario we'd query real stats
$total_products = isset( wp_count_posts( 'product' )->publish ) ? wp_count_posts( 'product' )->publish : 0;
$total_synced = $total_products;
$pending = $total_products - $total_synced;
?>
<div class="wrap merchant-ai-wrap">
    
    <div class="merchant-ai-header">
        <div class="merchant-ai-header-left">
            <img src="<?php echo esc_url( plugins_url( '../assets/images/icon-128x128.gif', __FILE__ ) ); ?>" alt="Merchant AI Feed">
            <h1>Merchant AI Feed</h1>
        </div>
        <div class="merchant-ai-header-right">
            <div class="version">V <?php echo esc_html( WebClyde_Merchant_AI_Feed::VERSION ); ?></div>
            <h2>Dashboard</h2>
        </div>
    </div>

    <form method="post" action="options.php">
        <?php
        settings_fields( 'merchant_ai_feed_settings' );
        do_settings_sections( 'merchant_ai_feed_settings' );
        ?>
        <div class="merchant-ai-grid">
            <!-- Left Column: Products Indexed Card -->
            <div class="merchant-ai-card products-indexed-card">
                <h3>Products <span class="gold-text">Indexed</span></h3>
                <div class="products-stats">
                    <div class="products-icon">
                        <svg width="68" height="68" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Box Icon -->
                            <path d="M24 6L6 14L24 22L42 14L24 6Z" fill="#FFF" stroke="#6b5b22" stroke-width="4" stroke-linejoin="round"/>
							<path d="M6 14V34L24 42V22L6 14Z" fill="#FFF" stroke="#a38927" stroke-width="4" stroke-linejoin="round"/>
							<path d="M42 14V34L24 42V22L42 14Z" fill="#FFF" stroke="#c0a631" stroke-width="4" stroke-linejoin="round"/>
							<path d="M24 22L15 18" stroke="#6b5b22" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="stats-numbers">
                        <div class="stat-item">
                            <span class="stat-label">Total Synced</span>
                            <span class="stat-value"><?php echo esc_html( $total_synced ); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Pending</span>
                            <span class="stat-value"><?php echo esc_html( $pending ); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Toggles and statuses -->
            <div class="merchant-ai-toggles">
                <div class="merchant-ai-card toggle-card">
                    <div class="toggle-label">Active Status</div>
                    <label class="switch">
                        <input type="checkbox" name="merchant_ai_active_status" value="1" <?php checked( '1', $active_status ); ?> onchange="this.form.submit()">
                        <span class="slider round"></span>
                    </label>
                </div>
                
                <div class="merchant-ai-card toggle-card">
                    <div class="toggle-label">Auto Sync Status</div>
                    <label class="switch">
                        <input type="checkbox" name="merchant_ai_auto_sync_status" value="1" <?php checked( '1', $auto_sync_status ); ?> onchange="this.form.submit()">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="merchant-ai-card status-card">
                    <div class="status-label">ACP Compliance Status</div>
                    <div class="status-indicator"></div>
                </div>

                <div class="merchant-ai-card status-card">
                    <div class="status-label">API Health Indicator</div>
                    <div class="status-indicator"></div>
                </div>
            </div>
        </div>

        <div class="merchant-ai-card feed-url-card">
            <h4>Your Feed URL</h4>
            <p><input type="text" value="<?php echo esc_url( get_rest_url( null, 'merchant-ai/v1/feed' ) ); ?>" readonly></p>
            <button class="copy-btn" onclick="copyFeedUrl(event)">Copy URL</button>
            <button class="view-btn" onclick="viewFeedUrl(event)">View Feed</button>
            <p>Copy this URL and paste it into the AI Merchant Center feed settings.</p>
        </div>

        <div class="merchant-ai-card sync-time-card">
            <div class="sync-left">
                <h3>Last <span class="gold-text">Sync Time</span></h3>
            </div>
            <div class="sync-mid">
                <span class="sync-label">Timestamp</span>
                <span class="sync-value">17.15 PM</span>
            </div>
            <div class="sync-right">
                <span class="sync-label">Next scheduled sync (15 min cycle)</span>
                <span class="sync-value">17.30 PM</span>
            </div>
        </div>

        <div class="merchant-ai-card info-card">
            <h4>Always Up-to-Date <span class="gold-text-light">automatically</span></h4>
            <p>Our feed is 'Live-Linked'—meaning as soon as you change a price or sell an item on your site, the AI feed updates instantly. It's hands-free accuracy that keeps your customers happy.</p>
        </div>
    </form>
</div>
<script>
    function copyFeedUrl(e) {
        e.preventDefault();
        var copyText = document.querySelector("input[readonly]");
        copyText.select();
        document.execCommand("copy");
        e.target.innerHTML = "Copied";  
        setTimeout(() => {
            e.target.innerHTML = "Copy URL";
        }, 2000);
    }
    function viewFeedUrl(e) {
        e.preventDefault();
        var feedUrl = document.querySelector("input[readonly]").value;
        window.open(feedUrl, "_blank");
    }
</script>