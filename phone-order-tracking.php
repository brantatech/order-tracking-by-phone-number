<?php
/**
 * Copyright (C) 2025 BrantaTech (https://brantatech.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 



 * Plugin Name: Order Tracking by Phone Number
 * Plugin URI: https://brantatech.com/order-tracking-by-phone-number
 * Description: A plugin that allows customers to track their WooCommerce orders using their phone numbers. Includes customizable settings for display and appearance.
 * Version: 1.0.0
 * Author: BrantaTech
 * Author URI: https://brantatech.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: order-tracking-by-phone-number
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Ensure WooCommerce is active
// Register settings
function order_tracking_register_settings() {
    register_setting('order_tracking_settings_group', 'order_tracking_settings');

    // Settings for displaying order details
    add_settings_section(
        'order_tracking_display_section',
        'Order Details Display',
        'order_tracking_display_section_callback',
        'order_tracking_settings'
    );

    add_settings_field(
        'display_billing_name',
        'Display Billing Name',
        'order_tracking_display_billing_name',
        'order_tracking_settings',
        'order_tracking_display_section'
    );

    add_settings_field(
        'display_billing_address',
        'Display Billing Address',
        'order_tracking_display_billing_address',
        'order_tracking_settings',
        'order_tracking_display_section'
    );

    add_settings_field(
        'display_billing_phone',
        'Display Billing Phone',
        'order_tracking_display_billing_phone',
        'order_tracking_settings',
        'order_tracking_display_section'
    );

    // Settings for customizing form appearance
    add_settings_section(
        'order_tracking_appearance_section',
        'Form Appearance',
        'order_tracking_appearance_section_callback',
        'order_tracking_settings'
    );

    add_settings_field(
        'button_color',
        'Button Color',
        'order_tracking_button_color',
        'order_tracking_settings',
        'order_tracking_appearance_section'
    );

    add_settings_field(
        'field_color',
        'Field Color',
        'order_tracking_field_color',
        'order_tracking_settings',
        'order_tracking_appearance_section'
    );

    add_settings_field(
        'typography',
        'Typography Style',
        'order_tracking_typography',
        'order_tracking_settings',
        'order_tracking_appearance_section'
    );
}

add_action('admin_init', 'order_tracking_register_settings');

// Displaying and customizing the settings page in admin panel
function order_tracking_settings_page() {
    ?>
    <div class="wrap">
        <h1>Order Tracking Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('order_tracking_settings_group');
            do_settings_sections('order_tracking_settings');
            submit_button();
            ?>
        </form>

        <div class="highlighted-instructions">
            <h2>How to Use the Order Tracking Form:</h2>
            <p><strong>To display the order tracking form on your site, create a new page and add the following shortcode:</strong></p>
            <pre style="background-color: #f4f4f4; padding: 10px; border-radius: 5px; font-size: 18px;">
[order_tracking_by_phone]</pre>
            <p><span style="color: #0071a1; font-weight: bold;">This shortcode will display a form where customers can track their orders by entering their phone number.</span></p>
            <p>Once the shortcode is added to the page, customers will be able to enter their phone number and see their order details in a modal window.</p>

            <h3>Example of the form:</h3>
            <ul>
                <li>Phone number field for entering customer details.</li>
                <li>Button to submit and fetch the order information.</li>
                <li>Modal that shows order details including product names, quantities, and prices.</li>
            </ul>

            <p><span style="color: #FF0000; font-weight: bold;">Note:</span> Make sure that WooCommerce is installed and orders are created with customer phone numbers for this functionality to work.</p>
        </div>
    </div>
    <?php
}

// Add custom CSS for highlighting the instructions
function order_tracking_admin_styles() {
    echo '
    <style>
        .highlighted-instructions {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
        .highlighted-instructions h2 {
            color: #333;
        }
        .highlighted-instructions pre {
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            font-size: 18px;
            font-family: Consolas, monospace;
        }
        .highlighted-instructions ul {
            list-style-type: square;
            margin-left: 20px;
        }
    </style>';
}
add_action('admin_head', 'order_tracking_admin_styles');

// Add the menu for the settings page
function order_tracking_menu() {
    add_menu_page(
        'Order Tracking Settings',
        'Order Tracking Settings',
        'manage_options',
        'order-tracking-settings',
        'order_tracking_settings_page'
    );
}
add_action('admin_menu', 'order_tracking_menu');

// Callback functions for displaying settings sections and fields
function order_tracking_display_section_callback() {
    echo '<p>Customize how the order details are displayed on the frontend when tracking orders.</p>';
}

function order_tracking_display_billing_name() {
    $options = get_option('order_tracking_settings');
    $checked = isset($options['display_billing_name']) ? 'checked' : '';
    echo "<input type='checkbox' name='order_tracking_settings[display_billing_name]' value='1' $checked>";
}

function order_tracking_display_billing_address() {
    $options = get_option('order_tracking_settings');
    $checked = isset($options['display_billing_address']) ? 'checked' : '';
    echo "<input type='checkbox' name='order_tracking_settings[display_billing_address]' value='1' $checked>";
}

function order_tracking_display_billing_phone() {
    $options = get_option('order_tracking_settings');
    $checked = isset($options['display_billing_phone']) ? 'checked' : '';
    echo "<input type='checkbox' name='order_tracking_settings[display_billing_phone]' value='1' $checked>";
}

// Appearance settings
function order_tracking_appearance_section_callback() {
    echo '<p>Customize the form appearance (e.g., colors, typography).</p>';
}

function order_tracking_button_color() {
    $options = get_option('order_tracking_settings');
    $value = isset($options['button_color']) ? esc_attr($options['button_color']) : '';
    echo "<input type='text' name='order_tracking_settings[button_color]' value='$value' class='color-field'>";
}

function order_tracking_field_color() {
    $options = get_option('order_tracking_settings');
    $value = isset($options['field_color']) ? esc_attr($options['field_color']) : '';
    echo "<input type='text' name='order_tracking_settings[field_color]' value='$value' class='color-field'>";
}

function order_tracking_typography() {
    $options = get_option('order_tracking_settings');
    $value = isset($options['typography']) ? esc_attr($options['typography']) : '';
    echo "<input type='text' name='order_tracking_settings[typography]' value='$value'>";
}

// Shortcode functionality for tracking orders
function order_tracking_by_phone_shortcode() {
    ob_start();

    // Display the form
    ?>
    <style>
        /* Basic styling for the form */
        .order-tracking-form {
            margin-bottom: 20px;
        }
        .order-tracking-form input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
        }
        .order-tracking-form button {
            background-color: #0071a1;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .order-tracking-form button:hover {
            background-color: #005b82;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            overflow-y: auto; /* Enable scrolling */
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 90%;
            max-width: 600px;
            position: relative;
            margin: 20px auto; /* Add margin for better appearance on small screens */
            max-height: 90%; /* Ensure content doesn't overflow */
            overflow-y: auto; /* Enable scrolling for content */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .modal-content h2 {
            text-align: center;
            margin-top: 0;
        }
        .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            color: #555;
        }
        .close-modal:hover {
            color: #000;
        }
        .modal-content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .modal-content table th,
        .modal-content table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .modal-content button {
            background-color: #0071a1;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto 0;
        }
        .modal-content button:hover {
            background-color: #005b82;
        }

        @media (max-width: 600px) {
            .modal-content {
                width: 95%; /* Better fit on smaller screens */
            }
        }
    </style>

    <form method="post" class="order-tracking-form">
        <p>
            <label for="phone_number">Enter Your Phone Number:</label><br>
            <input type="text" id="phone_number" name="phone_number" placeholder="e.g., 1234567890" required>
        </p>
        <p>
            <button type="submit">Track Order</button>
        </p>
    </form>

    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>

    <script>
        // Close the modal when the close button is clicked
        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        // Close the modal when clicking outside the modal content
        document.addEventListener('click', function (event) {
            const modal = document.getElementById('orderModal');
            const modalContent = document.querySelector('.modal-content');
            
            if (event.target === modal && !modalContent.contains(event.target)) {
                closeModal();
            }
        });
    </script>

    <?php
    // Process the phone number
    if (isset($_POST['phone_number'])) {
        $phone_number = sanitize_text_field($_POST['phone_number']);
        $orders = wc_get_orders(array(
            'billing_phone' => $phone_number,
            'limit'         => -1, // Get all orders
        ));

        ob_start();
        if (!empty($orders)) {
            foreach ($orders as $order) {
                ?>
                <div>
                    <h2><strong>Order ID:</strong> <?php echo $order->get_id(); ?></h2>
                    <p><strong>Order Date:</strong> <?php echo $order->get_date_created()->date('Y-m-d H:i:s'); ?></p>
                    <hr>
                    <h3>Billing Details</h3>
                    <p><strong>Name:</strong> <?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?></p>
                    <p><strong>Address:</strong> <?php echo $order->get_billing_address_1() . ', ' . $order->get_billing_city() . ', ' . $order->get_billing_state() . ', ' . $order->get_billing_postcode() . ', ' . $order->get_billing_country(); ?></p>
                    <p><strong>Email:</strong> <?php echo $order->get_billing_email(); ?></p>
                    <p><strong>Phone:</strong> <?php echo $order->get_billing_phone(); ?></p>
                    <hr>
                    <h3>Order Details</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($order->get_items() as $item) {
                                $product_name = $item->get_name();
                                $quantity = $item->get_quantity();
                                $price = wc_price($item->get_total() / $quantity); // Calculate unit price
                                ?>
                                <tr>
                                    <td><?php echo $product_name; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td><?php echo $price; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <p><strong>Order Total:</strong> <?php echo $order->get_formatted_order_total(); ?></p>
                    <p><strong>Customer Note:</strong> <?php echo $order->get_customer_note() ?: 'No notes provided'; ?></p>
                    <hr>
                </div><br><br>
                <?php
            }
        } else {
            echo '<p>No orders found for the provided phone number.</p>';
        }
        $output = ob_get_clean();

        ?>
        <script>
            document.getElementById('modalBody').innerHTML = <?php echo json_encode($output); ?>;
            document.getElementById('orderModal').style.display = 'flex';
        </script>
        <?php
    }

    return ob_get_clean();
}
add_shortcode('order_tracking_by_phone', 'order_tracking_by_phone_shortcode');
