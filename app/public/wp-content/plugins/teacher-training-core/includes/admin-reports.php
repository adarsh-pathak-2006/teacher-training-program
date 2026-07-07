<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register TTP Reports Menu Page
 */
add_action('admin_menu', 'ttp_register_reports_page');
function ttp_register_reports_page() {
    add_menu_page(
        'TTP Reports',
        'TTP Reports',
        'manage_options',
        'ttp-reports',
        'ttp_render_reports_page',
        'dashicons-chart-pie',
        30
    );
}

/**
 * Render TTP Reports Dashboard
 */
function ttp_render_reports_page() {
    // 1. Data Aggregation: Students
    $students = get_users(['role' => 'student']);
    $student_data = [];
    foreach ($students as $student) {
        $attendance = function_exists('ttp_calculate_attendance') ? ttp_calculate_attendance($student->ID)['percentage'] : 'N/A';
        // Check for any certificate hash
        global $wpdb;
        $has_cert = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->usermeta WHERE user_id = %d AND meta_key LIKE '_ttp_cert_hash_%'", $student->ID));
        
        $student_data[] = [
            'name' => $student->display_name,
            'email' => $student->user_email,
            'attendance' => $attendance,
            'cert_status' => $has_cert ? '✅ Issued' : '❌ Pending'
        ];
    }

    // 2. Data Aggregation: Mentors & Trainers
    $mentors = get_users(['role__in' => ['trainer', 'startup_mentor']]);
    
    // 3. Data Aggregation: Startups
    $startup_tasks = get_posts([
        'post_type' => 'startup_task',
        'posts_per_page' => -1
    ]);

    ?>
    <style>
        .ttp-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 20px 20px 0 0; }
        .ttp-header { background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .ttp-header h1 { margin: 0; font-size: 1.5rem; color: #1e293b; }
        .ttp-tabs { display: flex; gap: 8px; margin-bottom: 24px; }
        .ttp-tab-btn { padding: 12px 24px; background: white; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; font-weight: 600; color: #64748b; font-size: 14px; }
        .ttp-tab-btn.active { background: #2563eb; color: white; border-color: #2563eb; }
        .ttp-tab-content { display: none; background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .ttp-tab-content.active { display: block; }
        .ttp-table { width: 100%; border-collapse: collapse; }
        .ttp-table th, .ttp-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .ttp-table th { background: #f8fafc; font-weight: 600; color: #475569; font-size: 13px; text-transform: uppercase; }
        .ttp-table td { color: #1e293b; font-size: 14px; }
        .ttp-stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .ttp-stat-card { background: #f8fafc; padding: 24px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center; }
        .ttp-stat-value { font-size: 2rem; font-weight: 700; color: #2563eb; margin-bottom: 8px; }
        .ttp-stat-label { font-size: 0.875rem; color: #64748b; font-weight: 600; text-transform: uppercase; }
    </style>

    <div class="ttp-wrap">
        <div class="ttp-header">
            <h1>TTP Advanced Reporting</h1>
            <a href="#" onclick="window.print()" class="button button-primary">Print / Export PDF</a>
        </div>

        <div class="ttp-tabs">
            <button class="ttp-tab-btn active" onclick="switchReportTab('students')">Students & Certificates</button>
            <button class="ttp-tab-btn" onclick="switchReportTab('mentors')">Mentors & Trainers</button>
            <button class="ttp-tab-btn" onclick="switchReportTab('startups')">Startup Progress</button>
        </div>

        <!-- Student Report Tab -->
        <div id="tab-students" class="ttp-tab-content active">
            <div class="ttp-stat-grid">
                <div class="ttp-stat-card">
                    <div class="ttp-stat-value"><?php echo count($student_data); ?></div>
                    <div class="ttp-stat-label">Total Students</div>
                </div>
                <div class="ttp-stat-card">
                    <div class="ttp-stat-value">
                        <?php 
                        $certified = array_filter($student_data, function($s) { return strpos($s['cert_status'], 'Issued') !== false; });
                        echo count($certified); 
                        ?>
                    </div>
                    <div class="ttp-stat-label">Certificates Issued</div>
                </div>
            </div>

            <table class="ttp-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Global Attendance</th>
                        <th>Certificate Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($student_data)) : ?>
                        <tr><td colspan="4" style="text-align: center;">No students found.</td></tr>
                    <?php else : ?>
                        <?php foreach ($student_data as $student) : ?>
                            <tr>
                                <td><strong><?php echo esc_html($student['name']); ?></strong></td>
                                <td><?php echo esc_html($student['email']); ?></td>
                                <td>
                                    <?php 
                                    $color = $student['attendance'] >= 80 ? '#10b981' : '#ef4444';
                                    echo '<span style="font-weight: 700; color: ' . $color . '">' . $student['attendance'] . '%</span>'; 
                                    ?>
                                </td>
                                <td><?php echo $student['cert_status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mentors Tab -->
        <div id="tab-mentors" class="ttp-tab-content">
            <table class="ttp-table">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Role</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mentors)) : ?>
                        <tr><td colspan="3" style="text-align: center;">No mentors or trainers found.</td></tr>
                    <?php else : ?>
                        <?php foreach ($mentors as $mentor) : ?>
                            <tr>
                                <td><strong><?php echo esc_html($mentor->display_name); ?></strong></td>
                                <td>
                                    <span style="background: #e2e8f0; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                        <?php echo esc_html(implode(', ', $mentor->roles)); ?>
                                    </span>
                                </td>
                                <td><?php echo esc_html($mentor->user_email); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Startups Tab -->
        <div id="tab-startups" class="ttp-tab-content">
            <table class="ttp-table">
                <thead>
                    <tr>
                        <th>Startup Task / Cohort</th>
                        <th>Date Published</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($startup_tasks)) : ?>
                        <tr><td colspan="3" style="text-align: center;">No startup tasks found.</td></tr>
                    <?php else : ?>
                        <?php foreach ($startup_tasks as $task) : ?>
                            <tr>
                                <td><strong><?php echo esc_html($task->post_title); ?></strong></td>
                                <td><?php echo get_the_date('Y-m-d', $task->ID); ?></td>
                                <td><span style="color: #10b981; font-weight: 600;">Active</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function switchReportTab(tabName) {
            // Hide all contents
            document.querySelectorAll('.ttp-tab-content').forEach(el => el.classList.remove('active'));
            // Remove active class from buttons
            document.querySelectorAll('.ttp-tab-btn').forEach(el => el.classList.remove('active'));
            
            // Show selected
            document.getElementById('tab-' + tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
    <?php
}
?>
