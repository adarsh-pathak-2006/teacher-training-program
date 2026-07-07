<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Analytics Engine (GA4 DataLayer Integration)
 */
class TTP_Analytics {

    // IMPORTANT: Replace this placeholder with the live GA4 Measurement ID before launch
    private $ga_id = 'G-XXXXXXXXXX';

    public function __construct() {
        // Inject Base GA4 Script
        add_action('wp_head', [$this, 'inject_ga4_script'], 5);

        // Event Hooks
        add_action('user_register', [$this, 'track_registration'], 10, 1);
        add_action('woocommerce_thankyou', [$this, 'track_purchase'], 10, 1);
        add_action('tutor_course_complete_after', [$this, 'track_course_completion'], 10, 2);
        add_action('tutor_quiz/attempt_ended', [$this, 'track_quiz_completion'], 10, 1);
        
        // We'll use wp_ajax_ hooks to inject JS directly on the next page load for server-side events
        add_action('wp_footer', [$this, 'output_queued_events'], 99);
    }

    /**
     * 1. Base Script Injection
     */
    public function inject_ga4_script() {
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics - TTP Engine -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($this->ga_id); ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '<?php echo esc_attr($this->ga_id); ?>');
        </script>
        <?php
    }

    /**
     * Helper to queue events for the next page load (for PHP redirects)
     */
    private function queue_event($event_name, $event_data = []) {
        $events = get_transient('ttp_ga4_events_' . get_current_user_id());
        if (!$events) $events = [];
        
        $events[] = [
            'name' => $event_name,
            'data' => $event_data
        ];
        
        set_transient('ttp_ga4_events_' . get_current_user_id(), $events, 300); // 5 mins expiration
    }

    /**
     * Output queued events in footer
     */
    public function output_queued_events() {
        $user_id = get_current_user_id();
        if (!$user_id) return;

        $events = get_transient('ttp_ga4_events_' . $user_id);
        if ($events && is_array($events)) {
            echo '<script>';
            foreach ($events as $event) {
                $data_json = json_encode($event['data']);
                echo "gtag('event', '" . esc_js($event['name']) . "', " . $data_json . ");\n";
            }
            echo '</script>';
            delete_transient('ttp_ga4_events_' . $user_id);
        }
    }

    /**
     * 2. Track Registration
     */
    public function track_registration($user_id) {
        $this->queue_event('sign_up', [
            'method' => 'WordPress'
        ]);
    }

    /**
     * 3. Track WooCommerce Purchase (Enrollment & Revenue)
     */
    public function track_purchase($order_id) {
        $order = wc_get_order($order_id);
        if (!$order) return;

        $items = $order->get_items();
        $products = [];
        
        foreach ($items as $item) {
            $products[] = [
                'item_id' => $item->get_product_id(),
                'item_name' => $item->get_name(),
                'price' => $item->get_total(),
                'quantity' => $item->get_quantity()
            ];
        }

        // Output directly on the Thank You page
        echo '<script>';
        echo "gtag('event', 'purchase', {
            transaction_id: '" . esc_js($order->get_order_number()) . "',
            value: " . esc_js($order->get_total()) . ",
            currency: '" . esc_js($order->get_currency()) . "',
            items: " . json_encode($products) . "
        });";
        echo '</script>';
    }

    /**
     * 4. Track Course Completion
     */
    public function track_course_completion($course_id, $user_id) {
        $course_title = get_the_title($course_id);
        $this->queue_event('course_completed', [
            'course_id' => $course_id,
            'course_name' => $course_title
        ]);
    }

    /**
     * 5. Track Quiz Results
     */
    public function track_quiz_completion($attempt_id) {
        global $wpdb;
        $attempt = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}tutor_quiz_attempts WHERE attempt_id = %d", $attempt_id));
        
        if ($attempt) {
            $this->queue_event('quiz_completed', [
                'quiz_id' => $attempt->quiz_id,
                'earned_marks' => $attempt->earned_marks,
                'total_marks' => $attempt->total_marks,
                'passed' => $attempt->is_pass
            ]);
        }
    }
}

new TTP_Analytics();
?>
